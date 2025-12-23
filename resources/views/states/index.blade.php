@extends('layouts.app')

@section('title', 'All States - Find Doctors & Clinics by State')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>All States</span>
@endsection

@section('content')
	<div class="space-y-6 lg:space-y-8">
		<!-- Header -->
		<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 border border-white/10 shadow-[0_25px_70px_rgba(6,95,70,0.35)]">
			<div class="pointer-events-none absolute inset-0">
				<div class="absolute inset-0 rounded-3xl border border-white/15 opacity-40"></div>
				<div class="absolute -top-10 -left-8 h-48 w-48 rounded-full bg-emerald-400/30 blur-[120px]"></div>
				<div class="absolute -bottom-14 right-4 h-60 w-60 rounded-full bg-teal-300/25 blur-[150px]"></div>
				<div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/10 to-transparent"></div>
			</div>

			<div class="relative z-10 p-5 sm:p-7 lg:p-10">
				<div class="space-y-4 text-white">
					<h1 class="text-2xl font-semibold leading-tight sm:text-3xl lg:text-4xl">
						All States
					</h1>
					<p class="text-sm sm:text-base text-emerald-50/90 max-w-2xl">
						Browse doctors and clinics by state. Find healthcare providers across all 50 states.
					</p>
					<div class="flex flex-wrap items-center gap-3 text-sm text-emerald-50">
						<div class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
							<svg class="h-5 w-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
							</svg>
							<div>
								<p class="text-xs uppercase tracking-wide text-emerald-100/80">Total Doctors</p>
								<p class="text-lg font-semibold text-white">{{ number_format($totalDoctors, 0, '.', ' ') }}</p>
							</div>
						</div>
						<div class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
							<svg class="h-5 w-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M4 11V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M3 11h18v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div>
								<p class="text-xs uppercase tracking-wide text-emerald-100/80">Total Clinics</p>
								<p class="text-lg font-semibold text-white">{{ number_format($totalOrganizations, 0, '.', ' ') }}</p>
							</div>
						</div>
						<div class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
							<svg class="h-5 w-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M3 21l9-9 9 9" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M12 3v18" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<div>
								<p class="text-xs uppercase tracking-wide text-emerald-100/80">States</p>
								<p class="text-lg font-semibold text-white">{{ count($states) }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- States Grid -->
		<section class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 shadow-sm sm:shadow-2xl p-4 sm:p-6 overflow-hidden">
			<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>
			<div class="relative z-10">
				<h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6">Browse by State</h2>
				@if(!empty($defaultState))
					<div class="mb-4 flex flex-wrap items-center gap-2 text-sm text-emerald-800 bg-emerald-50 border border-emerald-100 rounded-2xl px-3 py-2">
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7Z" stroke-linecap="round" stroke-linejoin="round"/>
							<circle cx="12" cy="9" r="2.5" />
						</svg>
						<span class="font-semibold">Default: {{ config('states.names')[$defaultState] ?? $defaultState }}</span>
						<span class="text-xs text-emerald-700/80">Tap any state to switch context.</span>
					</div>
				@endif
				<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2.5 sm:gap-3 md:gap-4">
					@foreach($states as $state)
						<a 
							href="{{ route('states.show', strtolower($state['abbreviation'])) }}" 
							class="item marked block rounded-xl sm:rounded-2xl bg-white border border-gray-100/80 shadow-sm px-3 py-2.5 sm:px-4 sm:py-3 md:px-5 md:py-4 hover:border-emerald-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 text-gray-800 group relative overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40 no-underline hover:underline"
						>
							<div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-transparent to-emerald-100 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
							<div class="relative z-10 flex items-center gap-2 sm:gap-2.5">
								<div class="item__counter inline-flex items-center justify-center bg-emerald-600 text-white text-xs font-semibold rounded-sm px-2 sm:px-2.5 py-0.5 w-fit h-5 leading-none flex-shrink-0">{!! number_format($state['count'], 0, '.', '&nbsp;') !!}</div>
								<div class="item__title text-sm sm:text-base font-medium group-hover:text-emerald-700 transition-colors break-words leading-snug">{{ $state['name'] }}</div>
								@if(!empty($defaultState) && $state['abbreviation'] === $defaultState)
									<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold px-2 py-1 border border-emerald-100">Default</span>
								@endif
							</div>
						</a>
					@endforeach
				</div>
			</div>
		</section>
	</div>
@endsection
