<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Organization;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	private function getStateNameMapping(): array
	{
		return [
			'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
			'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
			'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
			'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
			'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
			'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
			'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
			'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
			'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
			'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
			'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
			'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
			'WI' => 'Wisconsin', 'WY' => 'Wyoming',
		];
	}

	public function index(Request $request)
	{
		$query = trim((string) $request->get('q', ''));

		$doctorsCount = Doctor::query()->count();
		$organizationsCount = Organization::query()->count();
		$specialtiesCount = Specialty::query()->count();

		$featuredDoctors = Doctor::query()
			->orderBy('id', 'desc')
			->limit(8)
			->get();

		$featuredOrganizations = Organization::query()
			->orderBy('id', 'desc')
			->limit(8)
			->get();

		$popularSpecialties = Specialty::query()
			->orderBy('description')
			->limit(12)
			->get();

		$mobileSpecialties = Specialty::query()
			->select(['id', 'description'])
			->orderBy('description')
			->limit(150)
			->get();

		// Get unique states from both doctors and organizations tables
		$doctorStates = Doctor::query()
			->select('state', DB::raw('count(*) as count'))
			->whereNotNull('state')
			->where('state', '!=', '')
			->groupBy('state')
			->get()
			->pluck('count', 'state')
			->toArray();

		$organizationStates = Organization::query()
			->select('state', DB::raw('count(*) as count'))
			->whereNotNull('state')
			->where('state', '!=', '')
			->groupBy('state')
			->get()
			->pluck('count', 'state')
			->toArray();

		// Merge states and sum counts
		$statesWithCounts = [];
		$allStates = array_unique(array_merge(array_keys($doctorStates), array_keys($organizationStates)));
		
		foreach ($allStates as $state) {
			$doctorCount = $doctorStates[$state] ?? 0;
			$orgCount = $organizationStates[$state] ?? 0;
			$statesWithCounts[$state] = $doctorCount + $orgCount;
		}

		// Prepare states array with names and counts
		$stateMapping = $this->getStateNameMapping();
		$excludedStates = ['DC', 'AE', 'AP', 'PR']; // Exclude these states from the list
		$states = [];
		foreach ($statesWithCounts as $abbr => $count) {
			// Skip excluded states and only include valid USA states
			if (in_array($abbr, $excludedStates, true) || !isset($stateMapping[$abbr])) {
				continue;
			}
			$states[] = [
				'abbreviation' => $abbr,
				'name' => $stateMapping[$abbr],
				'count' => $count,
			];
		}

		// Sort by count descending, then by state name
		usort($states, function($a, $b) {
			if ($a['count'] === $b['count']) {
				return strcmp($a['name'], $b['name']);
			}
			return $b['count'] <=> $a['count'];
		});

		// Limit to top 24 popular states
		$states = array_slice($states, 0, 24);

		return view('home', [
			'query' => $query,
			'doctorsCount' => $doctorsCount,
			'organizationsCount' => $organizationsCount,
			'specialtiesCount' => $specialtiesCount,
			'featuredDoctors' => $featuredDoctors,
			'featuredOrganizations' => $featuredOrganizations,
			'popularSpecialties' => $popularSpecialties,
			'mobileSpecialties' => $mobileSpecialties,
			'states' => $states,
		]);
	}
}


