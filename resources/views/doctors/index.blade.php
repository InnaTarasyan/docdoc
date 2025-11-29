@extends('layouts.app')

@section('title', 'Doctors')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Doctors</span>
@endsection

@section('content')
	<div class="grid md:grid-cols-4 gap-6 sm:gap-8 mt-6 sm:mt-8">
		<aside class="md:col-span-1 min-w-0">
		<div class="relative bg-gradient-to-br from-white via-white to-brand-50 sm:from-emerald-950 sm:via-emerald-900 sm:to-emerald-800 rounded-[24px] sm:rounded-[30px] border border-gray-100 sm:border-white/15 p-0 shadow-sm sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] overflow-hidden">
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/15 opacity-30 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-10 -right-6 w-40 h-40 bg-emerald-400/35 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute -bottom-12 left-0 w-48 h-48 bg-teal-300/30 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 rounded-[24px] sm:rounded-[26px] bg-white/98 backdrop-blur-sm border border-white/40 sm:border-white/20 p-4 sm:p-6 shadow-sm sm:shadow-2xl max-w-full overflow-hidden doctors-filter-container">
				<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
					<div>
						<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold">Refine results</p>
						<h2 class="text-lg font-semibold text-gray-900">Filters</h2>
					</div>
					<a href="{{ route('doctors.index') }}" class="hidden sm:inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-semibold text-brand-900 border border-white/60 bg-white/80 hover:bg-white transition">Reset</a>
				</div>

					<form method="GET" action="{{ route('doctors.index') }}" class="grid gap-4 ajax-filter-form mobile-filter-form max-w-full" data-ajax-list="true" data-results="#doctors-results" data-city-select="#doctor-city-select">
						<label class="flex flex-col gap-1 text-sm font-medium text-gray-700">
							<span class="flex items-center gap-2 text-gray-700">
								<svg class="w-4 h-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-linejoin="round"/>
									<circle cx="11" cy="11" r="7"/>
								</svg>
								Search doctors
								<span class="text-xs font-normal text-gray-500">(name, specialty, org)</span>
							</span>
							<input
								type="text"
								name="q"
								value="{{ old('q', $filters['q'] ?? '') }}"
								placeholder="E.g. Cardiology, Anna Lee, Austin"
								class="w-full rounded-2xl border border-white/40 bg-white/95 text-gray-900 placeholder:text-gray-500 shadow-sm px-4 py-3 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-2 focus:ring-offset-white/70 transition mobile-input"
								autocomplete="off"
							/>
						</label>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-full">
							<label class="flex flex-col gap-1 text-sm font-medium text-gray-700 min-w-0">
								<span class="flex items-center gap-2">
									<svg class="w-4 h-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 4v16m8-8H4" stroke-linecap="round"/>
									</svg>
									Gender
								</span>
								<select name="gender" class="w-full rounded-2xl border border-white/40 bg-white/90 text-gray-900 shadow-sm px-4 py-3 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-2 focus:ring-offset-white/70 transition mobile-select max-w-full box-border">
									<option value="">Any gender</option>
									<option value="M" @selected(($filters['gender'] ?? '') === 'M')>Male</option>
									<option value="F" @selected(($filters['gender'] ?? '') === 'F')>Female</option>
								</select>
							</label>

							<label class="flex flex-col gap-1 text-sm font-medium text-gray-700 min-w-0">
								<span class="flex items-center gap-2">
									<svg class="w-4 h-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M3 3h18v13H3z"/>
										<path d="M8 21h8" stroke-linecap="round"/>
									</svg>
									State
								</span>
								<select name="state" class="w-full rounded-2xl border border-white/40 bg-white/90 text-gray-900 shadow-sm px-4 py-3 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-2 focus:ring-offset-white/70 transition mobile-select max-w-full box-border">
									<option value="">Any state</option>
									@foreach($states as $s)
										<option value="{{ $s }}" @selected(($filters['state'] ?? '') === $s)>{{ $s }}</option>
									@endforeach
								</select>
							</label>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-full">
							<label class="flex flex-col gap-1 text-sm font-medium text-gray-700 min-w-0">
								<span class="flex items-center gap-2">
									<svg class="w-4 h-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
									</svg>
									City
								</span>
								<select name="city" id="doctor-city-select" class="w-full rounded-2xl border border-white/40 bg-white/90 text-gray-900 shadow-sm px-4 py-3 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-2 focus:ring-offset-white/70 transition mobile-select max-w-full box-border">
									@include('doctors._city_options', ['cities' => $cities, 'filters' => $filters])
								</select>
							</label>

							<label class="flex flex-col gap-1 text-sm font-medium text-gray-700 min-w-0">
								<span class="flex items-center gap-2">
									<svg class="w-4 h-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M7 20v-8m10 8V4" stroke-linecap="round"/>
										<path d="M3 20h18" stroke-linecap="round"/>
									</svg>
									Specialty
								</span>
								<select name="specialty" class="w-full rounded-2xl border border-white/40 bg-white/90 text-gray-900 shadow-sm px-4 py-3 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-2 focus:ring-offset-white/70 transition mobile-select max-w-full box-border">
									<option value="">Any specialty</option>
									@foreach($specialties as $sp)
										<option value="{{ $sp }}" @selected(($filters['specialty'] ?? '') === $sp)>{{ $sp }}</option>
									@endforeach
								</select>
							</label>
						</div>

						<div class="flex flex-wrap gap-2">
							@foreach(['Cardiology','Dermatology','Pediatrics','Telehealth'] as $chip)
								<button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-brand-700 bg-brand-50 border border-brand-100 hover:bg-brand-100 transition" data-quick-filter="{{ $chip }}">
									{{ $chip }}
									<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="m9 12 2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</button>
							@endforeach
						</div>

						<div class="flex flex-col sm:flex-row sm:items-center gap-3">
							<button type="submit" class="inline-flex items-center justify-center px-5 py-3 rounded-full text-sm font-semibold text-brand-900 bg-white shadow-lg shadow-brand-900/10 border border-white/70 hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/60 focus-visible:ring-offset-2 focus-visible:ring-offset-white/80 transition">
								<svg class="w-4 h-4 mr-2 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M5 12h14" stroke-linecap="round"/>
									<path d="m12 5 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								Apply filters
							</button>
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

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			document.querySelectorAll('form.ajax-filter-form [data-quick-filter]').forEach(function (chip) {
				chip.addEventListener('click', function () {
					const form = chip.closest('form');
					if (!form) return;
					const specialtySelect = form.querySelector('select[name="specialty"]');
					if (specialtySelect) {
						specialtySelect.value = chip.dataset.quickFilter || '';
						specialtySelect.dispatchEvent(new Event('change', { bubbles: true }));
					}
				});
			});
		});
	</script>
@endpush


