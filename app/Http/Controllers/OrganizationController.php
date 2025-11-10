<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
	public function index(Request $request)
	{
		$state = (string) $request->get('state', '');
		$city = (string) $request->get('city', '');
		$specialty = (string) $request->get('specialty', '');
		$name = (string) $request->get('q', '');

		$organizations = Organization::query()
			->when($name !== '', fn ($q) => $q->where('name', 'like', '%' . $name . '%'))
			->when($state !== '', fn ($q) => $q->where('state', $state))
			->when($city !== '', fn ($q) => $q->where('city', $city))
			->when($specialty !== '', function ($q) use ($specialty) {
				$q->whereIn('name', function ($sub) use ($specialty) {
					$sub->select('organization_name')
						->from((new Doctor())->getTable())
						->where('taxonomy', 'like', '%' . $specialty . '%')
						->whereNotNull('organization_name');
				});
			})
			->orderBy('name')
			->paginate(20)
			->withQueryString();

		$states = Organization::query()->select('state')->whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
		$cities = Organization::query()
			->when($state !== '', fn ($q) => $q->where('state', $state))
			->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

		$specialties = Doctor::query()
			->select('taxonomy')->whereNotNull('taxonomy')->distinct()->orderBy('taxonomy')->pluck('taxonomy');

		return view('organizations.index', [
			'organizations' => $organizations,
			'filters' => [
				'q' => $name,
				'state' => $state,
				'city' => $city,
				'specialty' => $specialty,
			],
			'states' => $states,
			'cities' => $cities,
			'specialties' => $specialties,
		]);
	}

	public function show(Organization $organization)
	{
		$linkedDoctors = Doctor::query()
			->where('organization_name', $organization->name)
			->orderBy('name')
			->limit(12)
			->get();

		return view('organizations.show', [
			'organization' => $organization,
			'linkedDoctors' => $linkedDoctors,
		]);
	}
}


