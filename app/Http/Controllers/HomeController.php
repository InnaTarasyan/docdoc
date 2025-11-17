<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Organization;
use App\Models\Specialty;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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

		return view('home', [
			'query' => $query,
			'doctorsCount' => $doctorsCount,
			'organizationsCount' => $organizationsCount,
			'specialtiesCount' => $specialtiesCount,
			'featuredDoctors' => $featuredDoctors,
			'featuredOrganizations' => $featuredOrganizations,
			'popularSpecialties' => $popularSpecialties,
		]);
	}
}


