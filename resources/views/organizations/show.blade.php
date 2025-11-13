@extends('layouts.app')

@section('title', $organization->name)

@section('breadcrumbs')
	<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Organizations</a>
	<span class="mx-1">/</span>
	<span>{{ $organization->name }}</span>
@endsection

@section('content')
	<div class="grid lg:grid-cols-3 gap-6">
		<section class="lg:col-span-2">
			<div class="bg-white rounded-xl border shadow-sm p-6">
				<h1 class="text-2xl font-semibold text-gray-900">{{ $organization->name }}</h1>
				<dl class="mt-4 grid sm:grid-cols-2 gap-4 text-sm">
					<div class="rounded-lg border p-4">
						<dt class="font-medium text-gray-700">Location</dt>
						<dd class="text-gray-900 mt-1">{{ $organization->city ?: '—' }}, {{ $organization->state ?: '' }}</dd>
					</div>
					<div class="rounded-lg border p-4">
						<dt class="font-medium text-gray-700">Phone</dt>
						<dd class="text-gray-900 mt-1">{{ $organization->phone ?: '—' }}</dd>
					</div>
				</dl>
			</div>

			@if($linkedDoctors->count() > 0)
				<div class="mt-6">
					<h2 class="text-lg font-medium text-gray-900 mb-3">Doctors at this organization</h2>
					<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
						@foreach($linkedDoctors as $doctor)
							<a href="{{ route('doctors.show', $doctor) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition">
								<div class="font-medium text-gray-900">{{ $doctor->name }}</div>
								<div class="text-sm text-gray-600">{{ $doctor->taxonomy ?: '—' }}</div>
								<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
							</a>
						@endforeach
					</div>
				</div>
			@endif
		</section>

		<aside class="lg:col-span-1">
			<div class="bg-white rounded-xl border shadow-sm p-6">
				<h2 class="font-medium text-gray-900">Quick info</h2>
				<dl class="mt-3 space-y-2 text-sm">
					<dt class="font-medium text-gray-700">City / State</dt>
					<dd class="text-gray-900">{{ $organization->city ?: '—' }} {{ $organization->state ? ", $organization->state" : '' }}</dd>
					<dt class="font-medium text-gray-700">Phone</dt>
					<dd class="text-gray-900">{{ $organization->phone ?: '—' }}</dd>
				</dl>
			</div>
		</aside>
	</div>
@endsection


