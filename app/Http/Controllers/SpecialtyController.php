<?php

namespace App\Http\Controllers;

use App\Models\Specialty;

class SpecialtyController extends Controller
{
	public function index()
	{
		$specialties = Specialty::query()
			->orderBy('description')
			->paginate(36)
			->withQueryString();

		return view('specialties.index', [
			'specialties' => $specialties,
		]);
	}
}


