<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
	public function index(Request $request)
	{
		$name = (string) $request->get('q', '');
		$state = (string) $request->get('state', '');
		$city = (string) $request->get('city', '');
		$specialty = (string) $request->get('specialty', '');
		$gender = (string) $request->get('gender', '');

		$doctors = Doctor::query()
			->when($name !== '', function ($q) use ($name) {
				$q->where(function ($sub) use ($name) {
					$sub->where('name', 'like', '%' . $name . '%')
						->orWhere('taxonomy', 'like', '%' . $name . '%');
				});
			})
			->when($state !== '', fn ($q) => $q->where('state', $state))
			->when($city !== '', fn ($q) => $q->where('city', $city))
			->when($specialty !== '', fn ($q) => $q->where('taxonomy', 'like', '%' . $specialty . '%'))
			->when($gender !== '', fn ($q) => $q->where('gender', $gender))
			->orderBy('name')
			->paginate(20)
			->withQueryString();

		$states = Doctor::query()->select('state')->whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
		$cities = Doctor::query()
			->when($state !== '', fn ($q) => $q->where('state', $state))
			->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
		$specialties = Specialty::query()->orderBy('description')->pluck('description');

		return view('doctors.index', [
			'doctors' => $doctors,
			'filters' => [
				'q' => $name,
				'state' => $state,
				'city' => $city,
				'specialty' => $specialty,
				'gender' => $gender,
			],
			'states' => $states,
			'cities' => $cities,
			'specialties' => $specialties,
		]);
	}

	public function show(Doctor $doctor)
	{
		$related = Doctor::query()
			->where('id', '!=', $doctor->id)
			->where('city', $doctor->city)
			->where('taxonomy', $doctor->taxonomy)
			->orderBy('name')
			->limit(6)
			->get();

		return view('doctors.show', [
			'doctor' => $doctor,
			'related' => $related,
		]);
	}
}


