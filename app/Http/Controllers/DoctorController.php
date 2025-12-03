<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

			if ($request->wantsJson()) {
				$html = view('doctors._list', [
					'doctors' => $doctors,
				])->render();
				$citiesHtml = view('doctors._city_options', [
					'cities' => $cities,
					'filters' => [
						'city' => $city,
					] + $request->only(['q','state','specialty','gender']),
				])->render();
				return response()->json([
					'html' => $html,
					'citiesHtml' => $citiesHtml,
					'url' => url()->full(),
					'pagination' => [
						'current' => $doctors->currentPage(),
						'last' => $doctors->lastPage(),
					],
				]);
			}

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

	public function search(Request $request)
	{
		$q = trim((string) $request->get('q', ''));

		if ($q === '') {
			return response()->json([
				'results' => [],
			]);
		}

		$prefix = $q . '%';
		$contains = '%' . $q . '%';

		// Basic relevance ranking without external deps:
		// - exact prefix match on name gets higher score
		// - then taxonomy prefix
		// - then contains matches across name/taxonomy/org/city/state
		$query = Doctor::query()
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
			->limit(10)
			->get();

		$results = $query->map(function (Doctor $d) {
			$subtitleParts = array_filter([
				$d->taxonomy ?: null,
				$d->organization_name ?: null,
				trim(($d->city ?: '') . (isset($d->state) && $d->state !== '' ? ', ' . $d->state : '')) ?: null,
			]);
			return [
				'id' => $d->id,
				'text' => $d->name,
				'sub' => implode(' • ', $subtitleParts),
				'url' => route('doctors.show', $d),
			];
		});

		return response()->json([
			'results' => $results,
		]);
	}

	public function show(Doctor $doctor)
	{
		$doctor->load(['reviews' => function ($q) {
			$q->latest();
		}]);

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

	public function storeReview(Request $request, Doctor $doctor)
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'rating' => ['required', 'integer', 'min:1', 'max:5'],
			'comment' => ['nullable', 'string', 'max:5000'],
		]);

		$data['doctor_id'] = $doctor->id;

		$review = Review::create($data);

		// If this is an AJAX request, return a JSON payload with fresh reviews HTML
		if ($request->wantsJson()) {
			// Reload reviews in latest-first order
			$doctor->load(['reviews' => function ($q) {
				$q->latest();
			}]);

			$html = view('doctors._reviews_list', [
				'doctor' => $doctor,
			])->render();

			return response()->json([
				'status' => 'Thank you for sharing your experience.',
				'html' => $html,
			]);
		}

		return redirect()
			->route('doctors.show', $doctor)
			->with('status', 'Thank you for sharing your experience.');
	}
}


