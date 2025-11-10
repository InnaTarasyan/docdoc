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
		$query = (string) $request->get('q', '');

		$featuredDoctors = Doctor::query()
			->when($query !== '', function ($q) use ($query) {
				$q->where(function ($sub) use ($query) {
					$sub->where('name', 'like', '%' . $query . '%')
						->orWhere('taxonomy', 'like', '%' . $query . '%')
						->orWhere('city', 'like', '%' . $query . '%');
				});
			})
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
			'featuredDoctors' => $featuredDoctors,
			'featuredOrganizations' => $featuredOrganizations,
			'popularSpecialties' => $popularSpecialties,
		]);
	}
}


