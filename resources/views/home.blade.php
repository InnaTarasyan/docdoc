@extends('layouts.app')

@section('title', 'Find Doctors & Clinics')

@section('content')
	<div class="grid gap-8">
		<section class="bg-white rounded-xl shadow-sm p-6 sm:p-8 border">
			<h1 class="text-2xl font-semibold text-gray-900">Find the right doctor or clinic</h1>
			<p class="mt-1 text-gray-600">Search by doctor name, specialty, or city.</p>

			<form action="{{ route('doctors.index') }}" method="get" class="mt-6">
				<div class="flex flex-col sm:flex-row gap-3">
					<input type="text" name="q" value="{{ old('q', $query) }}" placeholder="e.g. cardiology, John Doe, Boston" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600" />
					<button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition">
						Search
					</button>
				</div>
			</form>
		</section>

		<section>
			<h2 class="text-lg font-medium text-gray-900 mb-3">Popular specialties</h2>
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
				@forelse($popularSpecialties as $spec)
					<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" class="block rounded-lg bg-white border shadow-sm px-4 py-3 hover:border-sky-600 hover:shadow transition text-gray-800">
						{{ $spec->description }}
					</a>
				@empty
					<p class="text-gray-600">No specialties yet.</p>
				@endforelse
			</div>
		</section>

		<section class="grid md:grid-cols-2 gap-8">
			<div>
				<div class="flex items-center justify-between mb-3">
					<h2 class="text-lg font-medium text-gray-900">Featured doctors</h2>
					<a href="{{ route('doctors.index') }}" class="text-sky-700 hover:underline text-sm">Browse all</a>
				</div>
				<div class="grid sm:grid-cols-2 gap-4">
					@forelse($featuredDoctors as $doctor)
						<a href="{{ route('doctors.show', $doctor) }}" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
							<div class="font-medium text-gray-900">{{ $doctor->name }}</div>
							<div class="text-sm text-gray-600">{{ $doctor->taxonomy ?: '—' }}</div>
							<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
							@if($doctor->organization_name)
								<div class="text-sm text-gray-700 mt-1">{{ $doctor->organization_name }}</div>
							@endif
						</a>
					@empty
						<p class="text-gray-600">No doctors available.</p>
					@endforelse
				</div>
			</div>
			<div>
				<div class="flex items-center justify-between mb-3">
					<h2 class="text-lg font-medium text-gray-900">Featured organizations</h2>
					<a href="{{ route('organizations.index') }}" class="text-sky-700 hover:underline text-sm">Browse all</a>
				</div>
				<div class="grid sm:grid-cols-2 gap-4">
					@forelse($featuredOrganizations as $org)
						<a href="{{ route('organizations.show', $org) }}" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
							<div class="font-medium text-gray-900">{{ $org->name }}</div>
							<div class="text-sm text-gray-600">{{ $org->city }}, {{ $org->state }}</div>
							@if($org->phone)
								<div class="text-sm text-gray-700 mt-1">{{ $org->phone }}</div>
							@endif
						</a>
					@empty
						<p class="text-gray-600">No organizations available.</p>
					@endforelse
				</div>
			</div>
		</section>
	</div>
@endsection


