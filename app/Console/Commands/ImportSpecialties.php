<?php

namespace App\Console\Commands;

use App\Models\Specialty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportSpecialties extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * --state=CA
	 * --taxonomy="family medicine,cardiology"
	 * --limit=200
	 *
	 * This command pulls a minimal dataset per taxonomy/state to upsert specialties locally.
	 */
	protected $signature = 'import:specialties {--state= : Two-letter state code (required if no city)} {--taxonomy= : Comma-separated taxonomy descriptions} {--city= : City name (optional)} {--limit=50 : Page size, max 200}';

	/**
	 * The console command description.
	 */
	protected $description = 'Import unique specialties (taxonomies) from the NPI Registry API.';

	public function handle(): int
	{
		$state = (string) $this->option('state');
		$city = (string) $this->option('city');
		$limit = (int) $this->option('limit');
		if ($limit <= 0 || $limit > 200) {
			$limit = 50;
		}

		$taxonomyInput = (string) $this->option('taxonomy');
		$taxonomyList = $this->parseCsvLower($taxonomyInput);

		if (empty($taxonomyList)) {
			$taxonomyList = [
				'family medicine',
				'cardiology',
				'pediatrics',
				'internal medicine',
				'dermatology',
			];
		}

		if (empty($state) && empty($city)) {
			$this->error('You must provide at least two filters. Provide --state with --taxonomy, or --state with --city.');
			return self::FAILURE;
		}

		$count = 0;
		foreach ($taxonomyList as $taxonomy) {
			$count += $this->fetchAndUpsertSpecialties($state, $city, $taxonomy, $limit);
		}

		$this->info("Upserted {$count} specialties.");
		return self::SUCCESS;
	}

	private function fetchAndUpsertSpecialties(string $state, string $city, string $taxonomy, int $limit): int
	{
		$query = [
			'version' => '2.1',
			// enumeration_type not strictly required for pulling taxonomies; choose NPI-1 to keep data smaller
			'enumeration_type' => 'NPI-1',
			'limit' => $limit,
		];

		$filtersUsed = 0;
		if (!empty($state)) {
			$query['state'] = $state;
			$filtersUsed++;
		}
		if (!empty($taxonomy)) {
			$query['taxonomy_description'] = $taxonomy;
			$filtersUsed++;
		}
		if (!empty($city)) {
			$query['city'] = $city;
			$filtersUsed++;
		}

		if ($filtersUsed < 2) {
			$this->warn('Skipping request due to insufficient filters for specialties import.');
			return 0;
		}

		$this->line("Fetching specialties for taxonomy '{$taxonomy}'" . (!empty($state) ? " in {$state}" : '') . (!empty($city) ? ", {$city}" : '') . ' ...');

		$skip = 0;
		$upserted = 0;
		do {
			$params = array_merge($query, ['skip' => $skip]);
			$response = Http::get('https://npiregistry.cms.hhs.gov/api/', $params);
			if (!$response->ok()) {
				$this->warn("Request failed (HTTP {$response->status()}).");
				break;
			}
			$payload = $response->json();
			$results = $payload['results'] ?? [];
			if (empty($results)) {
				break;
			}

			foreach ($results as $item) {
				if (!empty($item['taxonomies']) && is_array($item['taxonomies'])) {
					foreach ($item['taxonomies'] as $tx) {
						$code = $tx['code'] ?? null;
						$desc = $tx['desc'] ?? null;
						if ($code && $desc) {
							Specialty::updateOrCreate(
								['code' => $code],
								['description' => $desc]
							);
							$upserted++;
						}
					}
				}
			}

			$skip += $limit;
			sleep(1);
		} while (true);

		return $upserted;
	}

	private function parseCsvLower(string $input): array
	{
		if (trim($input) === '') {
			return [];
		}
		$parts = array_map(static function ($v) {
			return mb_strtolower(trim($v));
		}, explode(',', $input));
		$parts = array_values(array_filter(array_unique($parts), static function ($v) {
			return $v !== '';
		}));
		return $parts;
	}
}


