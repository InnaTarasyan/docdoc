<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Organization;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	public function index(Request $request)
	{
		$q = trim((string) $request->get('q', ''));

		$doctors = collect();
		$organizations = collect();
		$specialties = collect();

		if ($q !== '') {
			$contains = '%' . $q . '%';
			$prefix = $q . '%';

			$doctors = Doctor::query()
				->select(['id','name','taxonomy','city','state','organization_name','gender'])
				->where(function ($sub) use ($q) {
					$sub->where('name', 'like', '%' . $q . '%')
						->orWhere('taxonomy', 'like', '%' . $q . '%')
						->orWhere('organization_name', 'like', '%' . $q . '%')
						->orWhere('city', 'like', $q . '%')
						->orWhere('state', 'like', $q . '%');
				})
				->selectRaw("
					CASE
						WHEN name LIKE ? THEN 100
						WHEN taxonomy LIKE ? THEN 90
						WHEN name LIKE ? THEN 75
						WHEN taxonomy LIKE ? THEN 60
						WHEN organization_name LIKE ? THEN 50
						WHEN city LIKE ? THEN 40
						WHEN state LIKE ? THEN 35
						ELSE 0
					END as relevance_score
				", [$prefix, $prefix, $contains, $contains, $contains, $prefix, $prefix])
				->orderByDesc('relevance_score')
				->orderBy('name')
				->limit(9)
				->get();

			$organizations = Organization::query()
				->select(['id','name','city','state','phone'])
				->where(function ($sub) use ($q) {
					$sub->where('name', 'like', '%' . $q . '%')
						->orWhere('city', 'like', $q . '%')
						->orWhere('state', 'like', $q . '%');
				})
				->orderBy('name')
				->limit(9)
				->get();

			$specialties = Specialty::query()
				->select(['id','code','description'])
				->where('description', 'like', '%' . $q . '%')
				->orderBy('description')
				->limit(12)
				->get();
		}

		if ($request->wantsJson()) {
			$html = view('search._results', [
				'q' => $q,
				'doctors' => $doctors,
				'organizations' => $organizations,
				'specialties' => $specialties,
			])->render();

			return response()->json([
				'html' => $html,
				'url' => url()->full(),
			]);
		}

		return view('search.index', [
			'q' => $q,
			'doctors' => $doctors,
			'organizations' => $organizations,
			'specialties' => $specialties,
		]);
	}
}


