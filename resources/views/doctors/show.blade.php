@extends('layouts.app')

@section('title', $doctor->name)

@section('breadcrumbs')
	<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Doctors</a>
	<span class="mx-1">/</span>
	<span>{{ $doctor->name }}</span>
@endsection

@section('content')
	<div class="grid lg:grid-cols-3 gap-6">
		<section class="lg:col-span-2">
			<div class="bg-white rounded-xl border shadow-sm p-6">
				<h1 class="text-2xl font-semibold text-gray-900">{{ $doctor->name }}</h1>
				<div class="mt-2 text-gray-700">
					<div class="flex flex-wrap gap-3 text-sm">
						@if($doctor->npi)
							<span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-700">NPI: {{ $doctor->npi }}</span>
						@endif
						@if($doctor->gender)
							<span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-700">Gender: {{ $doctor->gender === 'M' ? 'Male' : 'Female' }}</span>
						@endif
						@if($doctor->taxonomy)
							<span class="inline-flex items-center px-2 py-1 rounded bg-brand-100 text-brand-800">{{ $doctor->taxonomy }}</span>
						@endif
					</div>
				</div>

				<div class="mt-4 grid sm:grid-cols-2 gap-4">
					<div class="rounded-lg border p-4">
						<h2 class="font-medium text-gray-900 mb-1">Practice location</h2>
						<div class="text-gray-700 text-sm">
							<div>{{ $doctor->city ?: '—' }}, {{ $doctor->state ?: '' }}</div>
						</div>
					</div>
					<div class="rounded-lg border p-4">
						<h2 class="font-medium text-gray-900 mb-1">Organization</h2>
						<div class="text-gray-700 text-sm">
							@if($doctor->organization_name)
								{{ $doctor->organization_name }}
							@else
								—
							@endif
						</div>
					</div>
				</div>
			</div>

			@if($related->count() > 0)
				<div class="mt-6">
					<h2 class="text-lg font-medium text-gray-900 mb-3">Nearby or related doctors</h2>
					<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
						@foreach($related as $d)
							<a href="{{ route('doctors.show', $d) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition">
								<div class="font-medium text-gray-900">{{ $d->name }}</div>
								<div class="text-sm text-gray-600">{{ $d->taxonomy ?: '—' }}</div>
								<div class="text-sm text-gray-600">{{ $d->city }}, {{ $d->state }}</div>
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
					<dt class="font-medium text-gray-700">Primary specialty</dt>
					<dd class="text-gray-900">{{ $doctor->taxonomy ?: '—' }}</dd>

					<dt class="font-medium text-gray-700">City / State</dt>
					<dd class="text-gray-900">{{ $doctor->city ?: '—' }} {{ $doctor->state ? ", $doctor->state" : '' }}</dd>
				</dl>
			</div>
		</aside>
	</div>
@endsection


