<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportDoctors extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * --state=CA
	 * --taxonomy="family medicine,cardiology"
	 * --limit=200
	 */
	protected $signature = 'import:doctors {--state= : Two-letter state code (required if no city)} {--taxonomy= : Comma-separated taxonomy descriptions} {--city= : City name (optional)} {--limit=200 : Page size, max 200}';

	/**
	 * The console command description.
	 */
	protected $description = 'Import doctors (NPI-1) from the NPI Registry API while respecting required filters.';

	public function handle(): int
	{
		$state = (string) $this->option('state');
		$city = (string) $this->option('city');
		$limit = (int) $this->option('limit');
		if ($limit <= 0 || $limit > 200) {
			$limit = 200;
		}

		$taxonomyInput = (string) $this->option('taxonomy');
		$taxonomyList = $this->parseTaxonomyInput($taxonomyInput);

		// Provide sensible defaults if no taxonomy is provided
		if (empty($taxonomyList)) {
			$taxonomyList = [
				'family medicine',
				'cardiology',
				'pediatrics',
				'internal medicine',
				'dermatology',
			];
		}

		// The API requires at least two filters. We'll use state + taxonomy_description
		// If city is provided, we can optionally add it (state + city also valid).
		if (empty($state) && empty($city)) {
			$this->error('You must provide at least two filters. Provide --state with --taxonomy, or --state with --city.');
			return self::FAILURE;
		}

		$totalImported = 0;
		foreach ($taxonomyList as $taxonomyDescription) {
			$importedForTaxonomy = $this->importDoctorsByFilters($state, $city, $taxonomyDescription, $limit);
			$totalImported += $importedForTaxonomy;
		}

		$this->info("Imported/updated {$totalImported} doctor records.");
		return self::SUCCESS;
	}

	/**
	 * @param string $state
	 * @param string $city
	 * @param string $taxonomyDescription
	 * @param int $limit
	 * @return int number of imported or updated rows
	 */
	private function importDoctorsByFilters(string $state, string $city, string $taxonomyDescription, int $limit): int
	{
		// Build base query with mandatory filters
		$query = [
			'version' => '2.1',
			'enumeration_type' => 'NPI-1',
			'limit' => $limit,
		];

		$filtersUsed = 0;
		if (!empty($state)) {
			$query['state'] = $state;
			$filtersUsed++;
		}
		if (!empty($taxonomyDescription)) {
			$query['taxonomy_description'] = $taxonomyDescription;
			$filtersUsed++;
		}
		if (!empty($city)) {
			$query['city'] = $city;
			$filtersUsed++;
		}

		// Ensure at least two filters (beyond version/limit)
		if ($filtersUsed < 2) {
			// Try to enforce state + taxonomy if possible
			if (!empty($state) && !empty($taxonomyDescription)) {
				// okay
			} elseif (!empty($state) && !empty($city)) {
				// okay
			} else {
				$this->warn('Skipping request due to insufficient filters for doctors import.');
				return 0;
			}
		}

		$this->line("Fetching doctors for taxonomy '{$taxonomyDescription}'" . (!empty($state) ? " in {$state}" : '') . (!empty($city) ? ", {$city}" : '') . ' ...');

		$skip = 0;
		$imported = 0;
		$this->output->progressStart();
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
				$doctorName = $this->extractDoctorName($item);

				Doctor::updateOrCreate(
					['npi' => $item['number'] ?? null],
					[
						'name' => $doctorName,
						'gender' => $item['basic']['gender'] ?? null,
						'city' => $item['addresses'][0]['city'] ?? null,
						'state' => $item['addresses'][0]['state'] ?? null,
						'taxonomy' => $item['taxonomies'][0]['desc'] ?? null,
						'organization_name' => $item['basic']['organization_name'] ?? null,
					]
				);
				$imported++;

				// Extract specialties from taxonomies[]
				if (!empty($item['taxonomies']) && is_array($item['taxonomies'])) {
					foreach ($item['taxonomies'] as $tx) {
						$code = $tx['code'] ?? null;
						$desc = $tx['desc'] ?? null;
						if ($code && $desc) {
							Specialty::updateOrCreate(
								['code' => $code],
								['description' => $desc]
							);
						}
					}
				}
			}

			$this->output->progressAdvance();
			$skip += $limit;
			sleep(1);
		} while (true);
		$this->output->progressFinish();

		return $imported;
	}

	private function parseTaxonomyInput(string $input): array
	{
		if (trim($input) === '') {
			return [];
		}
		$parts = array_map(static function ($v) {
			return trim(Str::lower($v));
		}, explode(',', $input));
		$parts = array_values(array_filter(array_unique($parts), static function ($v) {
			return $v !== '';
		}));
		return $parts;
	}

	private function extractDoctorName(array $item): ?string
	{
		$basic = $item['basic'] ?? [];
		if (!empty($basic['name'])) {
			return $basic['name'];
		}
		// Construct name if first/last exist
		$first = $basic['first_name'] ?? null;
		$last = $basic['last_name'] ?? null;
		if ($first || $last) {
			return trim(($first ?? '') . ' ' . ($last ?? '')) ?: null;
		}
		return null;
	}
}


