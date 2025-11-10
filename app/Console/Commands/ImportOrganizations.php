<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Models\Specialty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportOrganizations extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * --state=CA
	 * --city="Los Angeles,San Francisco"
	 * --limit=200
	 */
	protected $signature = 'import:organizations {--state= : Two-letter state code (required)} {--city= : Comma-separated city names (required)} {--limit=200 : Page size, max 200}';

	/**
	 * The console command description.
	 */
	protected $description = 'Import organizations (NPI-2) from the NPI Registry API while respecting required filters.';

	public function handle(): int
	{
		$state = (string) $this->option('state');
		$cityInput = (string) $this->option('city');
		$limit = (int) $this->option('limit');
		if ($limit <= 0 || $limit > 200) {
			$limit = 200;
		}

		$cities = $this->parseCsv($cityInput);

		if (empty($state) || empty($cities)) {
			$this->error('You must provide both --state and --city (at least one city) to satisfy the two-filter rule.');
			return self::FAILURE;
		}

		$totalImported = 0;
		foreach ($cities as $city) {
			$totalImported += $this->importOrganizationsByFilters($state, $city, $limit);
		}

		$this->info("Imported/updated {$totalImported} organization records.");
		return self::SUCCESS;
	}

	private function importOrganizationsByFilters(string $state, string $city, int $limit): int
	{
		$query = [
			'version' => '2.1',
			'enumeration_type' => 'NPI-2',
			'state' => $state,
			'city' => $city,
			'limit' => $limit,
		];

		$this->line("Fetching organizations in {$state}, {$city} ...");

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
				Organization::updateOrCreate(
					['npi' => $item['number'] ?? null],
					[
						'name' => $item['basic']['organization_name'] ?? ($item['basic']['name'] ?? null),
						'city' => $item['addresses'][0]['city'] ?? null,
						'state' => $item['addresses'][0]['state'] ?? null,
						'phone' => $item['addresses'][0]['telephone_number'] ?? null,
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

	private function parseCsv(string $input): array
	{
		if (trim($input) === '') {
			return [];
		}
		$parts = array_map(static function ($v) {
			return trim($v);
		}, explode(',', $input));
		$parts = array_values(array_filter(array_unique($parts), static function ($v) {
			return $v !== '';
		}));
		return $parts;
	}
}


