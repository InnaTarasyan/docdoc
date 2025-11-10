@extends('layouts.app')

@section('title', 'Doctors')

@section('breadcrumbs')
	<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Doctors</span>
@endsection

@section('content')
	<div class="grid md:grid-cols-4 gap-6">
		<aside class="md:col-span-1">
			<div class="bg-white rounded-xl border shadow-sm p-4">
				<h2 class="font-medium text-gray-900 mb-3">Filters</h2>
				<form method="GET" action="{{ route('doctors.index') }}" class="grid gap-3 ajax-filter-form" data-ajax-list="true" data-results="#doctors-results" data-city-select="#doctor-city-select">
					<input
						type="text"
						name="q"
						value="{{ old('q', $filters['q'] ?? '') }}"
						placeholder="Search doctors (name, specialty, org)"
						class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600"
						autocomplete="off"
					/>

					<select name="gender" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any gender</option>
						<option value="M" @selected(($filters['gender'] ?? '') === 'M')>Male</option>
						<option value="F" @selected(($filters['gender'] ?? '') === 'F')>Female</option>
					</select>

					<select name="state" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any state</option>
						@foreach($states as $s)
							<option value="{{ $s }}" @selected(($filters['state'] ?? '') === $s)>{{ $s }}</option>
						@endforeach
					</select>

					<select name="city" id="doctor-city-select" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						@include('doctors._city_options', ['cities' => $cities, 'filters' => $filters])
					</select>

					<select name="specialty" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any specialty</option>
						@foreach($specialties as $sp)
							<option value="{{ $sp }}" @selected(($filters['specialty'] ?? '') === $sp)>{{ $sp }}</option>
						@endforeach
					</select>

					<div class="flex items-center gap-2">
						<button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-sky-600 bg-sky-600 text-white hover:bg-sky-700 transition">Apply</button>
						<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Reset</a>
					</div>
				</form>
			</div>
		</aside>

		<section class="md:col-span-3" id="doctors-results">
			<div class="flex items-center justify-between mb-3">
				<h1 class="text-xl font-semibold text-gray-900">Doctors</h1>
				<span class="text-sm text-gray-600">Page {{ $doctors->currentPage() }} of {{ $doctors->lastPage() }}</span>
			</div>

			@include('doctors._list', ['doctors' => $doctors])
		</section>
	</div>
@endsection


