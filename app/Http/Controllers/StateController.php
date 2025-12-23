<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
	private function getStateNameMapping(): array
	{
		return config('states.names', []);
	}

	public function index(Request $request)
	{
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

		$stateMapping = $this->getStateNameMapping();
		$excludedStates = ['DC', 'AE', 'AP', 'PR']; // Exclude these states from the list
		$defaultState = $this->resolvePreferredState($request);
		if (!array_key_exists($defaultState, $statesWithCounts)) {
			$statesWithCounts[$defaultState] = 0;
		}
		// Prepare states array with names and counts
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
				'is_default' => $abbr === $defaultState,
			];
		}

		// Sort by default state first, then count descending, then by state name
		usort($states, function($a, $b) use ($defaultState) {
			if ($a['abbreviation'] === $defaultState) {
				return -1;
			}
			if ($b['abbreviation'] === $defaultState) {
				return 1;
			}
			if ($a['count'] === $b['count']) {
				return strcmp($a['name'], $b['name']);
			}
			return $b['count'] <=> $a['count'];
		});

		// Get total counts
		$totalDoctors = Doctor::query()->count();
		$totalOrganizations = Organization::query()->count();

		return view('states.index', [
			'states' => $states,
			'totalDoctors' => $totalDoctors,
			'totalOrganizations' => $totalOrganizations,
			'defaultState' => $defaultState,
		]);
	}

	public function show(Request $request, string $stateAbbr)
	{
		$stateAbbr = strtoupper($stateAbbr);
		$stateMapping = $this->getStateNameMapping();
		
		if (!isset($stateMapping[$stateAbbr])) {
			abort(404, 'State not found');
		}

		session(['preferred_state' => $stateAbbr]);

		$stateName = $stateMapping[$stateAbbr];

		// Get page parameter for pagination
		$doctorsPage = (int) $request->get('doctors_page', 1);
		$organizationsPage = (int) $request->get('organizations_page', 1);

		// Get doctors in this state
		$doctors = Doctor::query()
			->where('state', $stateAbbr)
			->orderBy('name')
			->paginate(20, ['*'], 'doctors_page', $doctorsPage)
			->appends($request->except('doctors_page'));

		// Get organizations in this state
		$organizations = Organization::query()
			->where('state', $stateAbbr)
			->orderBy('name')
			->paginate(20, ['*'], 'organizations_page', $organizationsPage)
			->appends($request->except('organizations_page'));

		// Get counts
		$doctorsCount = Doctor::query()
			->where('state', $stateAbbr)
			->count();

		$organizationsCount = Organization::query()
			->where('state', $stateAbbr)
			->count();

		// Get unique cities in this state
		$cities = Doctor::query()
			->select('city', DB::raw('count(*) as count'))
			->where('state', $stateAbbr)
			->whereNotNull('city')
			->where('city', '!=', '')
			->groupBy('city')
			->orderBy('count', 'desc')
			->orderBy('city')
			->limit(20)
			->get()
			->map(function($item) {
				return [
					'name' => $item->city,
					'count' => $item->count,
				];
			});

		// Get popular specialties in this state
		$specialties = Doctor::query()
			->select('taxonomy', DB::raw('count(*) as count'))
			->where('state', $stateAbbr)
			->whereNotNull('taxonomy')
			->where('taxonomy', '!=', '')
			->groupBy('taxonomy')
			->orderBy('count', 'desc')
			->orderBy('taxonomy')
			->limit(12)
			->get()
			->map(function($item) {
				return [
					'name' => $item->taxonomy,
					'count' => $item->count,
				];
			});

		// Handle AJAX requests
		if ($request->wantsJson()) {
			$type = $request->get('type', 'doctors'); // 'doctors' or 'organizations'
			
			if ($type === 'doctors') {
				$html = view('states._doctors_list', [
					'doctors' => $doctors,
					'stateName' => $stateName,
				])->render();
				
				return response()->json([
					'html' => $html,
					'url' => url()->full(),
					'pagination' => [
						'current' => $doctors->currentPage(),
						'last' => $doctors->lastPage(),
					],
				]);
			} else {
				$html = view('states._organizations_list', [
					'organizations' => $organizations,
					'stateName' => $stateName,
				])->render();
				
				return response()->json([
					'html' => $html,
					'url' => url()->full(),
					'pagination' => [
						'current' => $organizations->currentPage(),
						'last' => $organizations->lastPage(),
					],
				]);
			}
		}

		return view('states.show', [
			'stateAbbr' => $stateAbbr,
			'stateName' => $stateName,
			'doctors' => $doctors,
			'organizations' => $organizations,
			'doctorsCount' => $doctorsCount,
			'organizationsCount' => $organizationsCount,
			'cities' => $cities,
			'specialties' => $specialties,
		]);
	}
}

