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

	public function show(Request $request, string $stateAbbr)
	{
		$stateAbbr = strtoupper($stateAbbr);
		$stateMapping = $this->getStateNameMapping();
		
		if (!isset($stateMapping[$stateAbbr])) {
			abort(404, 'State not found');
		}

		$stateName = $stateMapping[$stateAbbr];

		// Get doctors in this state
		$doctors = Doctor::query()
			->where('state', $stateAbbr)
			->orderBy('name')
			->paginate(20);

		// Get organizations in this state
		$organizations = Organization::query()
			->where('state', $stateAbbr)
			->orderBy('name')
			->paginate(20);

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

