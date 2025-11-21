@extends('layouts.app')

@section('title', 'Doctors')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Doctors</span>
@endsection

@section('content')
	<div class="grid md:grid-cols-4 gap-6 sm:gap-8 mt-6 sm:mt-8">
		<aside class="md:col-span-1">
		<div class="relative bg-gradient-to-br from-white via-white to-brand-50 sm:from-emerald-950 sm:via-emerald-900 sm:to-emerald-800 rounded-[24px] sm:rounded-[30px] border border-gray-100 sm:border-white/15 p-0 shadow-sm sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] overflow-hidden">
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/15 opacity-30 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-10 -right-6 w-40 h-40 bg-emerald-400/35 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute -bottom-12 left-0 w-48 h-48 bg-teal-300/30 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 rounded-[24px] sm:rounded-[26px] bg-white/98 backdrop-blur-sm border border-white/40 sm:border-white/20 p-4 sm:p-6 shadow-sm sm:shadow-2xl">
				<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
					<div>
						<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold">Refine results</p>
						<h2 class="text-lg font-semibold text-gray-900">Filters</h2>
					</div>
					<a href="{{ route('doctors.index') }}" class="hidden sm:inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-semibold text-brand-900 border border-white/60 bg-white/80 hover:bg-white transition">Reset</a>
				</div>

					<form method="GET" action="{{ route('doctors.index') }}" class="grid gap-3 ajax-filter-form" data-ajax-list="true" data-results="#doctors-results" data-city-select="#doctor-city-select">
						<input
							type="text"
							name="q"
							value="{{ old('q', $filters['q'] ?? '') }}"
							placeholder="Search doctors (name, specialty, org)"
							class="w-full rounded-lg border border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600"
							autocomplete="off"
						/>

						<select name="gender" class="w-full rounded-lg border border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
							<option value="">Any gender</option>
							<option value="M" @selected(($filters['gender'] ?? '') === 'M')>Male</option>
							<option value="F" @selected(($filters['gender'] ?? '') === 'F')>Female</option>
						</select>

						<select name="state" class="w-full rounded-lg border border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
							<option value="">Any state</option>
							@foreach($states as $s)
								<option value="{{ $s }}" @selected(($filters['state'] ?? '') === $s)>{{ $s }}</option>
							@endforeach
						</select>

						<select name="city" id="doctor-city-select" class="w-full rounded-lg border border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
							@include('doctors._city_options', ['cities' => $cities, 'filters' => $filters])
						</select>

						<select name="specialty" class="w-full rounded-lg border border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
							<option value="">Any specialty</option>
							@foreach($specialties as $sp)
								<option value="{{ $sp }}" @selected(($filters['specialty'] ?? '') === $sp)>{{ $sp }}</option>
							@endforeach
						</select>

						<div class="flex flex-col sm:flex-row sm:items-center gap-3">
							<button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/60 transition">Apply filters</button>
							<a href="{{ route('doctors.index') }}" class="sm:hidden inline-flex items-center justify-center px-4 py-2.5 rounded-full border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Reset</a>
						</div>
					</form>
				</div>
			</div>
		</aside>

		<section class="md:col-span-3 relative bg-white sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:rounded-[36px] sm:border sm:border-white/10 sm:p-6 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] sm:overflow-hidden">
			<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/10 opacity-40 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-16 -left-2 w-64 h-64 bg-emerald-400/30 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute -bottom-20 right-0 w-72 h-72 bg-teal-300/25 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 flex flex-col gap-4">
				<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
					<div>
						<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold sm:text-emerald-100">Top-rated care</p>
						<h1 class="text-2xl font-semibold text-gray-900 sm:text-white">Doctors</h1>
					</div>
					<span class="text-sm text-gray-600 sm:text-emerald-50/80">Page {{ $doctors->currentPage() }} of {{ $doctors->lastPage() }}</span>
				</div>

				<div class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 p-4 sm:p-6 shadow-sm sm:shadow-2xl overflow-hidden">
					<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
					<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>

					<div class="relative z-10" id="doctors-results">
						@include('doctors._list', ['doctors' => $doctors])
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection


