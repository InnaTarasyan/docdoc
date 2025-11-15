<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Organization;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	public function autocomplete(Request $request)
	{
		$q = trim((string) $request->get('q', ''));

		if ($q === '') {
			return response()->json([
				'results' => [],
			]);
		}

		$prefix = $q . '%';
		$contains = '%' . $q . '%';
		$results = collect();

		// Search doctors
		$doctors = Doctor::query()
			->select([
				'id',
				'name',
				'taxonomy',
				'city',
				'state',
				'organization_name',
			])
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
			->where(function ($sub) use ($q) {
				$sub->where('name', 'like', '%' . $q . '%')
					->orWhere('taxonomy', 'like', '%' . $q . '%')
					->orWhere('organization_name', 'like', '%' . $q . '%')
					->orWhere('city', 'like', $q . '%')
					->orWhere('state', 'like', $q . '%');
			})
			->orderByDesc('relevance_score')
			->orderBy('name')
			->limit(5)
			->get()
			->map(function (Doctor $d) {
				$subtitleParts = array_filter([
					$d->taxonomy ?: null,
					trim(($d->city ?: '') . (isset($d->state) && $d->state !== '' ? ', ' . $d->state : '')) ?: null,
				]);
				return [
					'id' => 'doctor_' . $d->id,
					'text' => $d->name,
					'subtitle' => implode(' • ', $subtitleParts),
					'type' => 'doctor',
					'url' => route('doctors.show', $d),
				];
			});

		// Search organizations
		$organizations = Organization::query()
			->select(['id', 'name', 'city', 'state'])
			->where(function ($sub) use ($q) {
				$sub->where('name', 'like', '%' . $q . '%')
					->orWhere('city', 'like', $q . '%')
					->orWhere('state', 'like', $q . '%');
			})
			->orderBy('name')
			->limit(5)
			->get()
			->map(function (Organization $org) {
				$location = trim(($org->city ?: '') . (isset($org->state) && $org->state !== '' ? ', ' . $org->state : ''));
				return [
					'id' => 'org_' . $org->id,
					'text' => $org->name,
					'subtitle' => $location ?: null,
					'type' => 'organization',
					'url' => route('organizations.show', $org),
				];
			});

		// Search specialties
		$specialties = Specialty::query()
			->select(['id', 'code', 'description'])
			->where('description', 'like', '%' . $q . '%')
			->orderBy('description')
			->limit(5)
			->get()
			->map(function (Specialty $spec) {
				return [
					'id' => 'spec_' . $spec->id,
					'text' => $spec->description,
					'subtitle' => $spec->code,
					'type' => 'specialty',
					'url' => route('doctors.index', ['specialty' => $spec->description]),
				];
			});

		// Combine and sort by relevance (doctors first, then orgs, then specialties)
		$allResults = $doctors->concat($organizations)->concat($specialties);

		return response()->json([
			'results' => $allResults->values()->all(),
		]);
	}

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

			// If search query is empty, redirect to home page
			if ($q === '') {
				$url = route('home');
			} else {
				// Build URL with 'q' parameter
				$url = url()->current();
				$queryParams = $request->except('q');
				$queryParams['q'] = $q;
				if (!empty($queryParams)) {
					$url .= '?' . http_build_query($queryParams);
				}
			}

			return response()->json([
				'html' => $html,
				'url' => $url,
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


