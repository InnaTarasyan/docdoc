@extends('layouts.app')

@section('title', 'Organizations')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Organizations</span>
@endsection

@section('content')
	<div class="grid gap-6 lg:grid-cols-[minmax(0,320px)_1fr] items-start">
		<aside class="lg:col-span-1">
			<div class="relative overflow-hidden rounded-[32px] border border-white/10 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 p-5 sm:p-6 text-white shadow-[0_25px_60px_rgba(6,95,70,0.28)] lg:sticky lg:top-28">
				<div class="absolute inset-0 rounded-[32px] border border-white/10 pointer-events-none"></div>
				<div class="absolute -top-16 -right-10 w-48 h-48 bg-emerald-300/40 blur-[120px] rounded-full pointer-events-none"></div>
				<div class="absolute -bottom-20 left-6 w-60 h-60 bg-teal-300/30 blur-[160px] rounded-full pointer-events-none"></div>

				<div class="relative z-10 space-y-5">
					<div class="space-y-2">
						<p class="text-xs uppercase tracking-[0.2em] text-emerald-200/80 font-semibold">Find care faster</p>
						<h2 class="text-2xl font-semibold leading-tight">Smart filters</h2>
						<p class="text-sm text-emerald-50/80">Narrow results by location, specialty, or name. Changes apply instantly on larger screens while staying thumb-friendly on phones.</p>
					</div>

					<form method="GET" action="{{ route('organizations.index') }}" class="grid gap-4 ajax-filter-form" data-ajax-list="true" data-results="#organizations-results" data-city-select="#org-city-select">
						<label class="space-y-1 text-sm font-medium text-emerald-50/90">
							<span>Organization name</span>
							<input type="text" name="q" value="{{ old('q', $filters['q'] ?? '') }}" placeholder="e.g. City Hospital" class="input bg-white/95 text-gray-900 placeholder:text-gray-500 border-white/30 focus:border-white focus:ring-2 focus:ring-white/50" />
						</label>

						<label class="space-y-1 text-sm font-medium text-emerald-50/90">
							<span>State</span>
							<select name="state" class="select bg-white/95 text-gray-900 border-white/30 focus:border-brand-500 focus:ring-2 focus:ring-brand-300/60">
								<option value="">Any state</option>
								@foreach($states as $s)
									<option value="{{ $s }}" @selected(($filters['state'] ?? '') === $s)>{{ $s }}</option>
								@endforeach
							</select>
						</label>

						<label class="space-y-1 text-sm font-medium text-emerald-50/90">
							<span>City</span>
							<select name="city" id="org-city-select" class="select bg-white/95 text-gray-900 border-white/30 focus:border-brand-500 focus:ring-2 focus:ring-brand-300/60">
								@include('organizations._city_options', ['cities' => $cities, 'filters' => $filters])
							</select>
						</label>

						<label class="space-y-1 text-sm font-medium text-emerald-50/90">
							<span>Specialty</span>
							<select name="specialty" class="select bg-white/95 text-gray-900 border-white/30 focus:border-brand-500 focus:ring-2 focus:ring-brand-300/60">
								<option value="">Any specialty</option>
								@foreach($specialties as $sp)
									<option value="{{ $sp }}" @selected(($filters['specialty'] ?? '') === $sp)>{{ $sp }}</option>
								@endforeach
							</select>
						</label>

						<div class="flex flex-col sm:flex-row sm:items-center gap-2 pt-1">
							<button type="submit" class="btn-primary bg-white text-emerald-900 hover:bg-emerald-50 hover:text-emerald-900 border border-white/70 shadow-lg shadow-emerald-900/30">Apply filters</button>
							<a href="{{ route('organizations.index') }}" class="btn-outline border-white/50 text-white hover:bg-white/10">Reset</a>
						</div>
					</form>
				</div>
			</div>
		</aside>

		<section class="relative overflow-hidden rounded-[36px] border border-white/10 bg-white lg:bg-gradient-to-br lg:from-emerald-900 lg:via-emerald-800 lg:to-emerald-900 p-4 sm:p-8 shadow-[0_25px_60px_rgba(6,95,70,0.18)]" id="organizations-results">
			<div class="hidden lg:block absolute inset-0 rounded-[36px] border border-white/15 opacity-70 pointer-events-none"></div>
			<div class="hidden lg:block absolute -top-16 -right-10 w-64 h-64 bg-emerald-300/40 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden lg:block absolute bottom-0 left-8 w-72 h-72 bg-emerald-400/35 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10">
				<div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
					<div>
						<p class="text-xs uppercase tracking-widest text-brand-700 font-semibold lg:text-emerald-100">Verified providers</p>
						<h1 class="text-2xl font-semibold text-gray-900 lg:text-white">Organizations</h1>
						<p class="text-sm text-gray-600 lg:text-emerald-50/80 mt-1 max-w-2xl">Browse hospitals, clinics, and provider groups with real-time filtering.</p>
					</div>
					<span class="text-sm font-medium text-gray-700 lg:text-emerald-50/80">Page {{ $organizations->currentPage() }} of {{ $organizations->lastPage() }}</span>
				</div>

				<div class="mt-6 rounded-[28px] border border-gray-100/70 lg:border-white/15 bg-white shadow-sm lg:shadow-2xl p-4 sm:p-6">
					@include('organizations._list', ['organizations' => $organizations])
				</div>
			</div>
		</section>
	</div>
@endsection


