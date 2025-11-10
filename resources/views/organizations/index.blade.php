@extends('layouts.app')

@section('title', 'Organizations')

@section('breadcrumbs')
	<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Organizations</span>
@endsection

@section('content')
	<div class="grid md:grid-cols-4 gap-6">
		<aside class="md:col-span-1">
			<div class="bg-white rounded-xl border shadow-sm p-4">
				<h2 class="font-medium text-gray-900 mb-3">Filters</h2>
				<form method="GET" action="{{ route('organizations.index') }}" class="grid gap-3 ajax-filter-form" data-ajax-list="true" data-results="#organizations-results" data-city-select="#org-city-select">
					<input type="text" name="q" value="{{ old('q', $filters['q'] ?? '') }}" placeholder="Organization name" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600" />

					<select name="state" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any state</option>
						@foreach($states as $s)
							<option value="{{ $s }}" @selected(($filters['state'] ?? '') === $s)>{{ $s }}</option>
						@endforeach
					</select>

					<select name="city" id="org-city-select" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						@include('organizations._city_options', ['cities' => $cities, 'filters' => $filters])
					</select>

					<select name="specialty" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any specialty</option>
						@foreach($specialties as $sp)
							<option value="{{ $sp }}" @selected(($filters['specialty'] ?? '') === $sp)>{{ $sp }}</option>
						@endforeach
					</select>

					<div class="flex items-center gap-2">
						<button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-sky-600 bg-sky-600 text-white hover:bg-sky-700 transition">Apply</button>
						<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Reset</a>
					</div>
				</form>
			</div>
		</aside>

		<section class="md:col-span-3" id="organizations-results">
			<div class="flex items-center justify-between mb-3">
				<h1 class="text-xl font-semibold text-gray-900">Organizations</h1>
				<span class="text-sm text-gray-600">Page {{ $organizations->currentPage() }} of {{ $organizations->lastPage() }}</span>
			</div>

			@include('organizations._list', ['organizations' => $organizations])
		</section>
	</div>
@endsection


