@extends('layouts.app')

@section('title', 'Organizations')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Organizations</span>
@endsection

@section('content')
	<div class="grid md:grid-cols-4 gap-6">
		<aside class="md:col-span-1">
			<div class="bg-white rounded-xl border shadow-sm p-4">
				<h2 class="font-medium text-gray-900 mb-3">Filters</h2>
				<form method="get" action="{{ route('organizations.index') }}" class="grid gap-3">
					<input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Organization name" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600" />

					<select name="state" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any state</option>
						@foreach($states as $s)
							<option value="{{ $s }}" @selected($filters['state']===$s)>{{ $s }}</option>
						@endforeach
					</select>

					<select name="city" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any city</option>
						@foreach($cities as $c)
							<option value="{{ $c }}" @selected($filters['city']===$c)>{{ $c }}</option>
						@endforeach
					</select>

					<select name="specialty" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
						<option value="">Any specialty</option>
						@foreach($specialties as $sp)
							<option value="{{ $sp }}" @selected($filters['specialty']===$sp)>{{ $sp }}</option>
						@endforeach
					</select>

					<div class="flex gap-2">
						<button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700 transition w-full">Apply</button>
						<a href="{{ route('organizations.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Reset</a>
					</div>
				</form>
			</div>
		</aside>

		<section class="md:col-span-3">
			<div class="flex items-center justify-between mb-3">
				<h1 class="text-xl font-semibold text-gray-900">Organizations</h1>
				<span class="text-sm text-gray-600">Page {{ $organizations->currentPage() }} of {{ $organizations->lastPage() }}</span>
			</div>

			@if($organizations->count() === 0)
				<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No organizations found. Try adjusting filters.</div>
			@else
				<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
					@foreach($organizations as $org)
						<a href="{{ route('organizations.show', $org) }}" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
							<div class="font-medium text-gray-900">{{ $org->name }}</div>
							<div class="text-sm text-gray-600">{{ $org->city }}, {{ $org->state }}</div>
							@if($org->phone)
								<div class="text-sm text-gray-700 mt-1">{{ $org->phone }}</div>
							@endif
						</a>
					@endforeach
				</div>

				<div class="mt-6">
					{{ $organizations->links() }}
				</div>
			@endif
		</section>
	</div>
@endsection


