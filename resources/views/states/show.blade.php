@extends('layouts.app')

@section('title', "Doctors and Clinics in {$stateName}")

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>{{ $stateName }}</span>
@endsection

@section('content')
	<div class="space-y-6 lg:space-y-8">
		<!-- State Header -->
		<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 border border-white/10 shadow-[0_25px_70px_rgba(6,95,70,0.35)]">
			<div class="pointer-events-none absolute inset-0">
				<div class="absolute inset-0 rounded-3xl border border-white/15 opacity-40"></div>
				<div class="absolute -top-10 -left-8 h-48 w-48 rounded-full bg-emerald-400/30 blur-[120px]"></div>
				<div class="absolute -bottom-14 right-4 h-60 w-60 rounded-full bg-teal-300/25 blur-[150px]"></div>
				<div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/10 to-transparent"></div>
			</div>

			<div class="relative z-10 p-5 sm:p-7 lg:p-10">
				<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
					<div class="space-y-4 text-white">
						<div class="flex flex-wrap items-center gap-2">
							<h1 class="text-2xl font-semibold leading-tight sm:text-3xl lg:text-4xl">
								Doctors & Clinics in {{ $stateName }}
							</h1>
							<span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-medium uppercase tracking-wide text-white ring-1 ring-white/30">
								{{ $stateAbbr }}
							</span>
						</div>
						<div class="flex flex-wrap items-center gap-3 text-sm text-emerald-50">
							<div class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
								<svg class="h-5 w-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
								</svg>
								<div>
									<p class="text-xs uppercase tracking-wide text-emerald-100/80">Doctors</p>
									<p class="text-lg font-semibold text-white">{{ number_format($doctorsCount, 0, '.', ' ') }}</p>
								</div>
							</div>
							<div class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
								<svg class="h-5 w-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M4 11V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v4" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M3 11h18v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<div>
									<p class="text-xs uppercase tracking-wide text-emerald-100/80">Clinics</p>
									<p class="text-lg font-semibold text-white">{{ number_format($organizationsCount, 0, '.', ' ') }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Popular Specialties -->
		@if($specialties->count() > 0)
		<section class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 shadow-sm sm:shadow-2xl p-4 sm:p-6 overflow-hidden">
			<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>
			<div class="relative z-10">
				<h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Popular Specialties in {{ $stateName }}</h2>
				<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
					@foreach($specialties as $specialty)
						<a href="{{ route('doctors.index', ['state' => $stateAbbr, 'specialty' => $specialty['name']]) }}" class="block rounded-xl border border-gray-100 bg-white p-3 hover:border-brand-500 hover:shadow-md transition-all duration-300 group">
							<div class="text-sm font-semibold text-gray-900 group-hover:text-brand-700 transition-colors line-clamp-2">{{ $specialty['name'] }}</div>
							<div class="text-xs text-gray-600 mt-1">{{ number_format($specialty['count'], 0, '.', ' ') }} doctors</div>
						</a>
					@endforeach
				</div>
			</div>
		</section>
		@endif

		<!-- Doctors Section -->
		<section class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 shadow-sm sm:shadow-2xl p-4 sm:p-6 overflow-hidden">
			<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>
			<div class="relative z-10">
				<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
					<h2 class="text-lg sm:text-xl font-semibold text-gray-900">Doctors in {{ $stateName }}</h2>
					<a href="{{ route('doctors.index', ['state' => $stateAbbr]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800">
						View all doctors
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div id="doctors-list-container" data-state="{{ $stateAbbr }}">
					@include('states._doctors_list', ['doctors' => $doctors, 'stateName' => $stateName])
				</div>
			</div>
		</section>

		<!-- Organizations Section -->
		<section class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 shadow-sm sm:shadow-2xl p-4 sm:p-6 overflow-hidden">
			<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>
			<div class="relative z-10">
				<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
					<h2 class="text-lg sm:text-xl font-semibold text-gray-900">Clinics & Organizations in {{ $stateName }}</h2>
					<a href="{{ route('organizations.index', ['state' => $stateAbbr]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800">
						View all clinics
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div id="organizations-list-container" data-state="{{ $stateAbbr }}">
					@include('states._organizations_list', ['organizations' => $organizations, 'stateName' => $stateName])
				</div>
			</div>
		</section>
	</div>
@endsection

