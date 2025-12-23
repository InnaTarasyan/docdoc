<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Doctor;
use App\Models\Organization;
use App\Models\Review;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	private function getStateNameMapping(): array
	{
		return config('states.names', []);
	}

	public function index(Request $request)
	{
		$query = trim((string) $request->get('q', ''));
		$currentState = $this->resolvePreferredState($request);
		$stateMapping = $this->getStateNameMapping();
		$currentStateName = $stateMapping[$currentState] ?? $currentState;
		session(['preferred_state' => $currentState]);

		$doctorsCount = Doctor::query()
			->where('state', $currentState)
			->count();
		$organizationsCount = Organization::query()
			->where('state', $currentState)
			->count();
		$specialtiesCount = Doctor::query()
			->where('state', $currentState)
			->whereNotNull('taxonomy')
			->where('taxonomy', '!=', '')
			->distinct('taxonomy')
			->count('taxonomy');

		$featuredDoctors = Doctor::query()
			->where('state', $currentState)
			->orderBy('id', 'desc')
			->limit(8)
			->get();

		$featuredOrganizations = Organization::query()
			->where('state', $currentState)
			->orderBy('id', 'desc')
			->limit(8)
			->get();

		$popularSpecialties = Doctor::query()
			->select('taxonomy', DB::raw('count(*) as count'))
			->where('state', $currentState)
			->whereNotNull('taxonomy')
			->where('taxonomy', '!=', '')
			->groupBy('taxonomy')
			->orderBy('count', 'desc')
			->orderBy('taxonomy')
			->limit(12)
			->get()
			->map(function ($item) {
				return (object) [
					'description' => $item->taxonomy,
					'count' => $item->count,
				];
			});

		$mobileSpecialties = Doctor::query()
			->select('taxonomy', DB::raw('count(*) as count'))
			->where('state', $currentState)
			->whereNotNull('taxonomy')
			->where('taxonomy', '!=', '')
			->groupBy('taxonomy')
			->orderBy('taxonomy')
			->limit(150)
			->get()
			->map(function ($item) {
				return (object) [
					'description' => $item->taxonomy,
					'count' => $item->count,
				];
			});

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
		$defaultState = strtoupper(config('states.default', 'CA'));
		if (!array_key_exists($defaultState, $statesWithCounts)) {
			$statesWithCounts[$defaultState] = 0;
		}
		// Prepare states array with names and counts
		$excludedStates = ['DC', 'AE', 'AP', 'PR']; // Exclude these states from the list
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

		// Sort by count descending, then by state name
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

		// Limit to top 24 popular states
		$states = array_slice($states, 0, 24);

		// Get 3 latest published blog posts
		$blogPosts = BlogPost::whereNotNull('published_at')
			->where('published_at', '<=', now())
			->orderBy('published_at', 'desc')
			->limit(3)
			->get();

		// Get latest patient stories (general reviews without doctor/org)
		$patientStories = Review::query()
			->whereNull('doctor_id')
			->whereNull('organization_id')
			->latest()
			->limit(3)
			->get();

		return view('home', [
			'query' => $query,
			'doctorsCount' => $doctorsCount,
			'organizationsCount' => $organizationsCount,
			'specialtiesCount' => $specialtiesCount,
			'featuredDoctors' => $featuredDoctors,
			'featuredOrganizations' => $featuredOrganizations,
			'popularSpecialties' => $popularSpecialties,
			'mobileSpecialties' => $mobileSpecialties,
			'states' => $states,
			'blogPosts' => $blogPosts,
			'patientStories' => $patientStories,
			'currentState' => $currentState,
			'currentStateName' => $currentStateName,
			'defaultState' => $defaultState,
		]);
	}

	public function storeStory(Request $request)
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'rating' => ['required', 'integer', 'min:1', 'max:5'],
			'comment' => ['required', 'string', 'max:5000'],
			'city' => ['nullable', 'string', 'max:255'],
			'state' => ['nullable', 'string', 'max:2'],
		]);

		// Create a review without doctor_id or organization_id (general story)
		$review = Review::create([
			'name' => $data['name'],
			'rating' => $data['rating'],
			'comment' => $data['comment'],
			'doctor_id' => null,
			'organization_id' => null,
		]);

		// If this is an AJAX request, return a JSON payload
		if ($request->wantsJson()) {
			// Get the latest stories for display
			$latestStories = Review::query()
				->whereNull('doctor_id')
				->whereNull('organization_id')
				->latest()
				->limit(3)
				->get();

			$storyHtml = '';
			foreach ($latestStories as $story) {
				$initials = strtoupper(substr($story->name, 0, 2));
				$storyHtml .= view('home._story_item', [
					'story' => $story,
					'initials' => $initials,
				])->render();
			}

			return response()->json([
				'status' => 'Thank you for sharing your story! It will help other patients find the care they need.',
				'storyHtml' => $storyHtml,
			]);
		}

		return redirect()
			->route('home')
			->with('status', 'Thank you for sharing your story!');
	}
}


