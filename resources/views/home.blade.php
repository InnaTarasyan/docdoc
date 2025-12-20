@extends('layouts.app')

@section('title', 'Find Doctors & Clinics')

@section('content')
	<div class="grid gap-6 sm:gap-8">
	<section
		class="hero hero--desktop-photo bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950 text-center relative w-full sm:w-full rounded-xl sm:rounded-2xl overflow-hidden mx-0 sm:mx-0 px-0 sm:px-0"
		style="
			background-image:
				linear-gradient(125deg, rgba(16, 185, 129, 0.35), rgba(5, 150, 105, 0.65)),
				url('{{ asset('img/hero-bg.webp') }}');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;"
	>
		<!-- Dark overlay for better text contrast -->
		<div class="hero-overlay absolute inset-0 bg-gradient-to-br from-emerald-900/70 via-emerald-900/40 to-emerald-950/70 mix-blend-multiply z-0"></div>
		<div class="absolute inset-0 hidden sm:block pointer-events-none">
			<div class="absolute w-64 h-64 bg-emerald-400/35 blur-3xl rounded-full" style="top: -120px; left: -60px;"></div>
			<div class="absolute w-72 h-72 bg-teal-300/30 blur-3xl rounded-full" style="bottom: -180px; right: -40px;"></div>
			<div class="absolute w-48 h-48 bg-emerald-500/25 blur-3xl rounded-full" style="top: 30%; left: 10%;"></div>
			<div class="absolute inset-0" style="background: radial-gradient(circle at top, rgba(16,185,129,0.12), transparent 55%);"></div>
		</div>
		
		<div class="hero-decorations">
			<svg class="hero-icon hero-icon-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
				<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
			</svg>
			<svg class="hero-icon hero-icon-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
				<path d="M6 3v5a4 4 0 1 0 8 0V3m-8 0H4m10 0h2M6 8a6 6 0 1 0 12 0m0 0v6a3 3 0 1 1-3 3" stroke-linecap="round"/>
			</svg>
			<svg class="hero-icon hero-icon-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
				<path d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25a4.5 4.5 0 0 1 8.25-2.602A4.5 4.5 0 0 1 21 8.25Z" stroke-linecap="round"/>
			</svg>
			<svg class="hero-icon hero-icon-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
				<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="3"/>
			</svg>
			<svg class="hero-icon hero-icon-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
				<path d="M12 5a4 4 0 1 1 0 8c-2 0-5-4-5-4s3-4 5-4Zm0 0c1.5 0 5 8 5 8l-3 6-2-4-2 4-3-6s3.5-8 5-8Z" stroke-linejoin="round"/>
			</svg>
		</div>
		<div class="relative z-10 px-4 py-8 sm:px-10 sm:py-12">
			<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl" style="box-shadow: 0 25px 60px rgba(6, 95, 70, 0.35);"></div>
			<div class="relative">
			<h1 class="hero-title text-white relative z-10 flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-3 mb-4 sm:mb-5 md:mb-6">
				<svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 text-white drop-shadow-lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
					<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
				</svg>
				<span class="drop-shadow-lg text-2xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl leading-tight">Find the care that fits you</span>
				<svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 text-white drop-shadow-lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
					<path d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25a4.5 4.5 0 0 1 8.25-2.602A4.5 4.5 0 0 1 21 8.25Z" stroke-linecap="round"/>
				</svg>
			</h1>
			<p class="hero-subtitle text-white text-center mx-auto max-w-2xl text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed drop-shadow-md mb-6 sm:mb-6 md:mb-8 px-2">Search by doctor, clinic, specialty, or city — quick filters and a gentle, mobile‑friendly experience.</p>

				<div class="sm:hidden flex flex-col gap-3 mt-4" id="mobile-search-trigger-wrapper">
					<button
						type="button"
						id="mobile-search-trigger"
						class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-white/95 text-brand-800 font-semibold text-base px-5 py-4 shadow-lg shadow-black/10 border border-white/20 touch-manipulation focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80"
					>
						<svg class="w-5 h-5 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="11" cy="11" r="7"></circle>
							<path d="m20 20-3.5-3.5" stroke-linecap="round"></path>
						</svg>
						<span>Search doctors & clinics</span>
					</button>
					<p class="text-sm text-white/80">Tap to pick a specialty, doctor, or city from the full-screen list.</p>
				</div>

				<form action="{{ route('search.index') }}" method="get" class="mt-4 sm:mt-5 md:mt-6 mx-auto w-full hidden sm:block" id="home-search-form">
					<div class="flex flex-col sm:flex-row gap-3 sm:gap-3">
						<div class="relative flex-1 w-full">
							<select
								name="q"
								id="home-search-select"
								class="w-full"
								style="width: 100%;"
								data-placeholder="Search doctors, specialties, or cities"
							>
								@if($query)
									<option value="{{ $query }}" selected>{{ $query }}</option>
								@endif
							</select>
						</div>
						<button
							type="submit"
							class="btn-primary h-14 sm:h-14 md:h-12 px-6 sm:px-8 text-base sm:text-base md:text-sm touch-manipulation whitespace-nowrap"
						>
							<span class="hidden sm:inline">Search</span>
							<span class="sm:hidden">🔍</span>
						</button>
					</div>
					<div class="mt-4 sm:mt-3 md:mt-3 flex flex-wrap gap-2.5 sm:gap-2.5">
						<button type="button" class="badge-sky min-h-[44px] px-4 py-2.5 text-sm sm:text-sm touch-manipulation" onclick="setSearchAndSubmit('Therapist')">Therapist</button>
						<button type="button" class="badge-sky min-h-[44px] px-4 py-2.5 text-sm sm:text-sm touch-manipulation" onclick="setSearchAndSubmit('Pediatrician')">Pediatrician</button>
						<button type="button" class="badge-sky min-h-[44px] px-4 py-2.5 text-sm sm:text-sm touch-manipulation" onclick="setSearchAndSubmit('Dentist')">Dentist</button>
						<button type="button" class="badge-sky min-h-[44px] px-4 py-2.5 text-sm sm:text-sm touch-manipulation" onclick="setSearchAndSubmit('Cardiologist')">Cardiologist</button>
					</div>
				</form>

				@php
					$mobileSpecialtiesList = isset($mobileSpecialties) ? $mobileSpecialties : collect();
				@endphp

				<div
					id="mobile-search-popup"
					class="popup mpopup mpopup_fullscreen mpopup-speciality"
					aria-hidden="true"
					role="dialog"
					aria-modal="true"
				>
					<div class="popup__wrap mpopup__wrap">
						<button type="button" class="popup__close mpopup__close" data-mobile-search-close aria-label="Close search popup"></button>
						<div class="popup__title mpopup__title">Find a specialty</div>
						<div class="popup__scroller mpopup__scroller">
							<div class="popup__content mpopup__content bottom-open">
								<div class="field field-text">
									<div class="field-text__wrap">
										<input
											type="text"
											id="mobile-search-input"
											placeholder="Search doctors, clinics, or specialties"
											class="field-text__input"
											autocomplete="off"
										>
										<button type="button" class="field-text__wrap_clear" data-mobile-search-clear aria-label="Clear search">
											<svg class="field-text__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M6 6l12 12M6 18L18 6" stroke-linecap="round"></path>
											</svg>
										</button>
										<div class="field-text__wrap_search">
											<svg class="field-text__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<circle cx="11" cy="11" r="7"></circle>
												<path d="m20 20-3.5-3.5" stroke-linecap="round"></path>
											</svg>
										</div>
									</div>
								</div>

								<div class="mpopup__chips" id="mobile-search-quick-filters">
									<button type="button" class="mpopup-chip" data-mobile-search-chip="Therapist">Therapist</button>
									<button type="button" class="mpopup-chip" data-mobile-search-chip="Pediatrician">Pediatrician</button>
									<button type="button" class="mpopup-chip" data-mobile-search-chip="Dentist">Dentist</button>
									<button type="button" class="mpopup-chip" data-mobile-search-chip="Cardiologist">Cardiologist</button>
								</div>

								<div class="mpopup__results" data-mobile-search-results hidden>
									<div class="mpopup__results-head">
										<div>
											<div class="mpopup__results-title">Doctors & clinics</div>
											<div class="mpopup__results-hint">Live suggestions from our directory</div>
										</div>
										<div class="mpopup__results-status" data-mobile-search-results-status>Start typing…</div>
									</div>
									<div class="mpopup__results-list" data-mobile-search-results-list></div>
									<div class="mpopup__results-empty" data-mobile-search-results-empty>
										Start typing at least 2 letters to find specialists or organizations.
									</div>
								</div>

								<div class="mpopup__list" data-mobile-search-list>
									@foreach($mobileSpecialtiesList as $spec)
										<div class="item" data-mobile-search-item data-value="{{ $spec->description }}">
											<div class="item__value">{{ $spec->description }}</div>
											<div class="item__chevron">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
													<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
											</div>
										</div>
									@endforeach
								</div>

								<div class="mpopup__empty" data-mobile-search-empty>
									No specialties match that search. Try another term.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mt-5 sm:mt-6 md:mt-7 hero-stats">
					<div class="hero-stats-shell bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 px-4 py-4 sm:px-6 sm:py-4 md:px-8 md:py-5 inline-flex w-full max-w-3xl mx-auto">
						<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 w-full text-left sm:text-center">
							<div class="hero-stat-item flex items-center sm:block gap-3">
								<div class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-500/20 text-white border border-white/40">
									<svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 4v16M4 12h16" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="sm:mt-2">
									<div class="text-lg sm:text-xl md:text-2xl font-semibold tracking-tight text-white">
										{{ number_format($specialtiesCount ?? 0, 0, '.', ' ') }}
									</div>
									<div class="text-xs sm:text-sm text-white/80 leading-snug">
										specialties to find the right doctor
									</div>
								</div>
							</div>
							<div class="hero-stat-item flex items-center sm:block gap-3">
								<div class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-500/20 text-white border border-white/40">
									<svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"/>
										<path d="M4 20a8 8 0 0 1 16 0" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="sm:mt-2">
									<div class="text-lg sm:text-xl md:text-2xl font-semibold tracking-tight text-white">
										{{ number_format($doctorsCount ?? 0, 0, '.', ' ') }}
									</div>
									<div class="text-xs sm:text-sm text-white/80 leading-snug">
										doctors ready to help you
									</div>
								</div>
							</div>
							<div class="hero-stat-item flex items-center sm:block gap-3">
								<div class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-500/20 text-white border border-white/40">
									<svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M4 11V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v4" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M3 11h18v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M9 11V9h6v2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="sm:mt-2">
									<div class="text-lg sm:text-xl md:text-2xl font-semibold tracking-tight text-white">
										{{ number_format($organizationsCount ?? 0, 0, '.', ' ') }}
									</div>
									<div class="text-xs sm:text-sm text-white/80 leading-snug">
										clinics and medical centers
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@if($query)
					<section id="home-doctors-results" class="mt-6 sm:mt-6 md:mt-8">
						@php
							$doctors = \App\Models\Doctor::query()
								->select(['id','name','taxonomy','city','state','organization_name','gender'])
								->where(function ($sub) use ($query) {
									$sub->where('name', 'like', '%' . $query . '%')
										->orWhere('taxonomy', 'like', '%' . $query . '%')
										->orWhere('organization_name', 'like', '%' . $query . '%')
										->orWhere('city', 'like', $query . '%')
										->orWhere('state', 'like', $query . '%');
								})
								->limit(9)
								->get();
							$organizations = \App\Models\Organization::query()
								->select(['id','name','city','state','phone'])
								->where(function ($sub) use ($query) {
									$sub->where('name', 'like', '%' . $query . '%')
										->orWhere('city', 'like', $query . '%')
										->orWhere('state', 'like', $query . '%');
								})
								->limit(9)
								->get();
							$specialties = \App\Models\Specialty::query()
								->select(['id','code','description'])
								->where('description', 'like', '%' . $query . '%')
								->limit(12)
								->get();
						@endphp
						@include('search._results', [
							'q' => $query,
							'doctors' => $doctors,
							'organizations' => $organizations,
							'specialties' => $specialties,
						])
					</section>
				@endif
			</div>
		</div>
		</section>

		<!-- Popular States Section -->
		@if(isset($states) && count($states) > 0)
			<section class="home-citys mt-6 sm:mt-8 relative px-0 py-6 sm:rounded-[36px] sm:overflow-hidden sm:border sm:border-white/10 sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:p-8 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] mx-0 sm:mx-0 sm:px-8">
				<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/15 bg-white/10 backdrop-blur-2xl"></div>
				<div class="hidden sm:block absolute -top-16 -right-10 w-64 h-64 bg-emerald-300/35 blur-[140px] rounded-full pointer-events-none"></div>
				<div class="hidden sm:block absolute bottom-0 left-10 w-72 h-72 bg-emerald-400/30 blur-[160px] rounded-full pointer-events-none"></div>

				<div class="relative z-10">
					<div class="home-citys__title text-xl sm:text-2xl font-semibold text-gray-900 sm:text-white mb-4 sm:mb-6 text-center sm:text-left">States</div>
					<div class="home-citys__list grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
						@foreach($states as $state)
							<a href="{{ route('states.show', strtolower($state['abbreviation'])) }}" class="item marked block rounded-2xl bg-white border border-gray-100/80 shadow-sm px-4 py-3 sm:px-5 sm:py-4 hover:border-brand-600 hover:shadow-lg transition text-gray-800 group relative overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40">
								<div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-transparent to-brand-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<div class="relative z-10 flex flex-col gap-2.5">
									<div class="item__counter inline-flex items-center justify-center bg-[#13a546] text-white text-xs font-semibold rounded-sm px-2.5 py-0.5 w-fit h-5 leading-none">{!! number_format($state['count'], 0, '.', '&nbsp;') !!}</div>
									<div class="item__title text-sm sm:text-base font-medium group-hover:text-brand-800 transition-colors break-words leading-snug">{{ $state['name'] }}</div>
								</div>
							</a>
						@endforeach
					</div>
				</div>
			</section>
		@endif

		<section class="mt-6 sm:mt-8 relative px-0 py-6 sm:rounded-[36px] sm:overflow-hidden sm:border sm:border-white/10 sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:p-8 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] mx-0 sm:mx-0 sm:px-8">
			<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/15 bg-white/10 backdrop-blur-2xl"></div>
			<div class="hidden sm:block absolute -top-16 -right-10 w-64 h-64 bg-emerald-300/35 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute bottom-0 left-10 w-72 h-72 bg-emerald-400/30 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10">
				<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-4 sm:mb-6">
					<div>
						<p class="text-sm uppercase tracking-wide text-brand-700 font-semibold sm:text-emerald-100">Browse faster</p>
						<h2 class="text-xl sm:text-2xl font-semibold text-gray-900 sm:text-white">Popular specialties</h2>
						<p class="text-sm sm:text-base text-gray-600 sm:text-emerald-50/80 mt-1 max-w-2xl">Tap a specialty to jump straight into doctors that match. The cards resize smoothly from narrow phones through large desktops.</p>
					</div>
					<a href="{{ route('doctors.index') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-brand-700 hover:text-brand-800 sm:text-white sm:hover:text-emerald-50 sm:bg-white/10 sm:border sm:border-white/20 sm:px-5 sm:py-2.5 sm:rounded-full sm:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 transition">
						View all doctors
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="relative rounded-2xl sm:rounded-[36px] border border-gray-200/80 sm:border-white/15 bg-gradient-to-br from-white via-white to-brand-50/40 sm:bg-white/10 p-4 sm:p-8 shadow-sm sm:shadow-2xl sm:overflow-hidden">
					<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/10 bg-emerald-300/10 backdrop-blur-xl"></div>
					<div class="absolute inset-y-0 left-0 w-28 bg-gradient-to-r from-emerald-400/35 via-emerald-300/10 to-transparent pointer-events-none rounded-l-[36px] opacity-70 hidden sm:block z-0"></div>
					<div class="absolute inset-y-4 right-6 w-32 bg-emerald-300/35 blur-3xl rounded-full opacity-80 pointer-events-none hidden sm:block z-0"></div>
					<div class="relative z-10 mx-0 sm:mx-0 overflow-hidden sm:overflow-visible pb-2 sm:pb-0">
						<div class="grid w-full grid-cols-1 gap-3 sm:min-w-0 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 sm:gap-4">
				@forelse($popularSpecialties as $spec)
						<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" class="specialty-card block rounded-2xl bg-white border border-gray-100/80 shadow-sm px-4 py-3 sm:px-5 sm:py-4 hover:border-brand-600 hover:shadow-lg transition text-gray-800 group relative overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40">
							<div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-transparent to-brand-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
							<div class="flex items-center gap-3 relative z-10">
								<div class="specialty-icon-wrapper flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-brand-50 text-brand-700 ring-1 ring-brand-100 group-hover:scale-110 transition-all duration-300">
									@include('components.specialty-icon', ['name' => $spec->description, 'class' => 'w-5 h-5'])
								</div>
								<div class="min-w-0 flex-1">
									<span class="block font-medium group-hover:text-brand-800 transition-colors break-words sm:truncate">{{ $spec->description }}</span>
									<span class="mt-0.5 block text-xs uppercase tracking-wide text-gray-500">Tap to explore</span>
								</div>
							</div>
							<div class="absolute top-2 right-2 text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
								<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
						</a>
				@empty
						<p class="text-gray-600">No specialties yet.</p>
				@endforelse
					</div>
				</div>
			</div>
		</section>


		<section class="grid md:grid-cols-2 gap-6 sm:gap-8 mt-6 sm:mt-8 relative bg-white sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] sm:rounded-[36px] sm:border sm:border-white/10 p-4 sm:p-8 sm:overflow-hidden mx-0 sm:mx-0 sm:px-8">
			<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/10 opacity-40 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-12 -left-6 w-56 h-56 bg-emerald-400/30 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute -bottom-10 right-0 w-72 h-72 bg-teal-300/25 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 flex flex-col gap-4 sm:gap-5">
				<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
					<div>
						<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold sm:text-emerald-100">Top-rated care</p>
						<h2 class="text-xl sm:text-2xl font-semibold text-gray-900 sm:text-white">Featured doctors</h2>
						<p class="text-sm text-gray-600 sm:text-emerald-50/80 mt-1 max-w-xl">Hand-picked specialists with excellent patient feedback, responsive chat times, and in-network coverage.</p>
					</div>
					<a href="{{ route('doctors.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold text-brand-700 hover:text-brand-800 bg-brand-50 border border-brand-100 shadow-sm hover:shadow md:self-end sm:bg-white/10 sm:text-white sm:border-white/30 sm:hover:bg-white/20 sm:hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-0 focus-visible:ring-white/70 transition min-h-[42px]">Browse all
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 shadow-sm sm:shadow-2xl p-4 sm:p-6 overflow-hidden">
					<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
					<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>
					@php
						$featuredDoctorAvatarUsage = $featuredDoctorAvatarUsage ?? ['F' => [], 'M' => []];
					@endphp
					<div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 gap-4">
						@forelse($featuredDoctors as $doctor)
							<a href="{{ route('doctors.show', $doctor) }}" class="doctor-card block rounded-2xl bg-white/95 border border-gray-100 p-4 shadow-sm hover:border-brand-500 hover:shadow-lg hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 transition-all duration-300 group relative overflow-hidden">
								<div class="absolute inset-0 bg-gradient-to-br from-brand-50/80 via-transparent to-brand-100/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								@php
									$seed = abs(crc32($doctor->name ?? (string) $doctor->id));
									$maxPortraits = 100;
									$idx = $seed % $maxPortraits;
									$gender = $doctor->gender ?? '';
									$isFemale = $gender === 'F';
									if ($gender !== 'F' && $gender !== 'M') {
										$first = trim(explode(' ', (string) $doctor->name)[0] ?? '');
										$lower = function_exists('mb_strtolower') ? mb_strtolower($first, 'UTF-8') : strtolower($first);
										$femaleNames = [
											'anna','maria','elena','olga','victoria','sofia','sofiya','anastasia','natalia','tatiana','irina','daria','polina',
											'yulia','julia','lyudmila','svetlana','valentina','veronika','alisa','alina','oksana','ekaterina','katerina','mariya'
										];
										$isFemale = in_array($lower, $femaleNames, true);
										if (!$isFemale) {
											$isFemale = (bool) preg_match('/(a|ia|ya|na|ra|la|ta|sa|ina|eva|ova|iya|aya)$/u', $lower);
										}
										if (!$isFemale && !in_array($lower, $femaleNames, true)) {
											$isFemale = ($idx % 2) === 1;
										}
									}
									$genderKey = $isFemale ? 'F' : 'M';
									$folder = $isFemale ? 'women' : 'men';
									$tracked = $featuredDoctorAvatarUsage[$genderKey] ?? [];
									$attempts = 0;
									while ($attempts < $maxPortraits && in_array($idx, $tracked, true)) {
										$idx = ($idx + 1) % $maxPortraits;
										$attempts++;
									}
									$featuredDoctorAvatarUsage[$genderKey][] = $idx;
									$avatarUrl = "https://randomuser.me/api/portraits/{$folder}/{$idx}.jpg";
									$taxonomy = $doctor->taxonomy ?? '';
								@endphp
								<div class="relative z-10 flex flex-col gap-4">
									<div class="flex items-start gap-4">
										<div class="relative shrink-0">
											<img src="{{ $avatarUrl }}" alt="{{ $doctor->name }}" class="doctor-avatar w-16 h-16 rounded-full ring-2 ring-brand-100 group-hover:ring-brand-400 object-cover bg-white transition-all duration-300" loading="lazy" decoding="async" />
											<div class="doctor-icon-wrapper absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100">
												@include('components.specialty-icon', ['name' => $taxonomy, 'class' => 'w-4 h-4'])
											</div>
										</div>
										<div class="min-w-0 flex-1">
											<div class="flex items-start justify-between gap-2">
												<div class="font-semibold text-gray-900 truncate group-hover:text-brand-700 transition-colors">{{ $doctor->name }}</div>
												<div class="inline-flex items-center gap-1 text-xs font-semibold text-brand-700 bg-brand-50 px-2 py-0.5 rounded-full">
													<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
														<path d="m12 17 5 3-1.5-5.727L20 9.5l-5.8-.5L12 3 9.8 9 4 9.5l4.5 4.773L7 20z" stroke-linejoin="round" stroke-linecap="round"/>
													</svg>
													<span>4.8</span>
												</div>
											</div>
											<div class="text-sm text-gray-600 truncate mt-0.5">{{ $doctor->taxonomy ?: 'General practitioner' }}</div>
											<div class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M12 21a9 9 0 1 0-9-9c0 5 9 9 9 9z"/>
													<circle cx="12" cy="12" r="3"/>
												</svg>
												<span>{{ $doctor->city }}, {{ $doctor->state }}</span>
											</div>
										</div>
									</div>
									@if($doctor->organization_name)
										<div class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Affiliated with</div>
										<div class="text-sm text-gray-800 truncate">{{ $doctor->organization_name }}</div>
									@endif
									<div class="flex flex-wrap gap-2 text-xs text-gray-600">
										<span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-50 border border-gray-200">
											<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M4 6h16M4 12h10M4 18h7" stroke-linecap="round"/>
											</svg>
											{{ $taxonomy ?: 'Flexible practice' }}
										</span>
										<span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-700">
											<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											In-network
										</span>
									</div>
									<div class="flex items-center justify-between pt-2 border-t border-gray-100">
										<div class="flex items-center gap-1 text-sm font-medium text-brand-700">
											<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M8 17l4 4 4-4M12 3v18" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											<span>Next-day slots</span>
										</div>
										<div class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 group-hover:gap-2 transition-all">
											<span>View profile</span>
											<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
									</div>
								</div>
							</a>
						@empty
							<p class="text-gray-600">No doctors available.</p>
						@endforelse
					</div>
				</div>
			</div>

			<div class="relative z-10 flex flex-col gap-4 sm:gap-5 mt-6 md:mt-0">
				<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
					<div>
						<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold sm:text-emerald-100">Trusted clinics</p>
						<h2 class="text-xl sm:text-2xl font-semibold text-gray-900 sm:text-white">Featured organizations</h2>
						<p class="text-sm text-gray-600 sm:text-emerald-50/80 mt-1 max-w-xl">Clinics and medical centers with great patient flow, transparent pricing, and modern facilities.</p>
					</div>
					<a href="{{ route('organizations.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold text-brand-700 hover:text-brand-800 bg-brand-50 border border-brand-100 shadow-sm hover:shadow md:self-end sm:bg-white/10 sm:text-white sm:border-white/30 sm:hover:bg-white/20 sm:hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-0 focus-visible:ring-white/70 transition min-h-[42px]">Browse all
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 shadow-sm sm:shadow-2xl p-4 sm:p-6 overflow-hidden">
					<div class="hidden sm:block absolute -bottom-8 -left-2 w-40 h-40 bg-emerald-300/30 blur-3xl rounded-full pointer-events-none"></div>
					<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>
					@php
						$featuredHospitalImages = [
							'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1512678080530-7760d81faba6?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1599043513900-ed6fe01d3833?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1497366216548-37526070297c?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1450272713119-b1d86efc16c4?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1504814532849-cff240bbc503?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1506015391300-4802dc74de2e?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1527137342181-19aab11a8ee8?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1505577058444-a3dab90d4253?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1526403220535-28e4e8508710?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1460672985063-6764ac8b9c74?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1464817739973-0128fe77aaa1?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?w=256&h=256&fit=crop',
							'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=256&h=256&fit=crop',
						];
						$featuredHospitalImageUsage = [];
						$featuredHospitalImageCount = count($featuredHospitalImages);
					@endphp
					<div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 gap-4">
						@forelse($featuredOrganizations as $org)
							<a href="{{ route('organizations.show', $org) }}" class="organization-card block rounded-2xl bg-white/95 border border-gray-100 p-4 shadow-sm hover:border-brand-500 hover:shadow-lg hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 transition-all duration-300 group relative overflow-hidden">
								<div class="absolute inset-0 bg-gradient-to-br from-brand-50/70 via-transparent to-brand-100/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								@php
									$seed = abs(crc32(($org->name ?? '') . '|' . (string) $org->id));
									$imgIndex = $featuredHospitalImageCount > 0 ? ($seed % $featuredHospitalImageCount) : 0;
									while (
										$featuredHospitalImageCount > 0 &&
										in_array($imgIndex, $featuredHospitalImageUsage, true) &&
										count($featuredHospitalImageUsage) < $featuredHospitalImageCount
									) {
										$imgIndex = ($imgIndex + 1) % $featuredHospitalImageCount;
									}
									$featuredHospitalImageUsage[] = $imgIndex;
									$imgUrl = $featuredHospitalImages[$imgIndex] ?? $featuredHospitalImages[0];
								@endphp
								<div class="relative z-10 flex flex-col gap-4">
									<div class="flex items-start gap-4">
										<div class="relative shrink-0">
											<img src="{{ $imgUrl }}" alt="{{ $org->name }}" class="organization-image w-16 h-16 rounded-2xl ring-2 ring-brand-100 group-hover:ring-brand-400 object-cover bg-white transition-all duration-300" loading="lazy" decoding="async" width="64" height="64" />
											<div class="absolute -bottom-1 -right-1 bg-brand-600 text-white rounded-full p-1.5 shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100">
												<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
													<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M17 21v-8H7v8M7 3v5h8" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</div>
										</div>
										<div class="min-w-0 flex-1">
											<div class="flex items-start justify-between gap-2">
												<div class="font-semibold text-gray-900 truncate group-hover:text-brand-700 transition-colors">{{ $org->name }}</div>
												<span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
													<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
														<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
													JCI
												</span>
											</div>
											<div class="text-sm text-gray-600 mt-0.5 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M4 11V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v4" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M3 11h18v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
												<span>{{ $org->city }}, {{ $org->state }}</span>
											</div>
											@if($org->phone)
												<div class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
													<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
														<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
													{{ $org->phone }}
												</div>
											@endif
										</div>
									</div>
									<div class="flex flex-wrap gap-2 text-xs text-gray-600">
										<span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-50 border border-gray-200">
											<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M9 5h11l-1.5 6.5h-8zM16.5 11.5 19 21H8l-2.5-9.5" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											Outpatient & inpatient
										</span>
										<span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-700">
											<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M9 12h6m-6 4h6M8 21h8a2 2 0 0 0 2-2V7l-4-4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											Digital paperwork
										</span>
									</div>
									<div class="flex items-center justify-between pt-2 border-t border-emerald-900/10">
										<div class="flex items-center gap-1 text-sm font-medium text-brand-700">
											<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M3 7h18M6 12h12M10 17h4" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											<span>Same-week visits</span>
										</div>
										<div class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 group-hover:gap-2 transition-all">
											<span>View profile</span>
											<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
									</div>
								</div>
							</a>
						@empty
							<p class="text-gray-600">No organizations available.</p>
						@endforelse
					</div>
				</div>
			</div>
		</section>

		<!-- User Reviews/Testimonials Section -->
		<section class="relative mt-8 sm:mt-12 px-0 sm:px-0 mx-0 sm:mx-0">
			<div class="relative mx-auto max-w-7xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 shadow-[0_25px_60px_rgba(6,95,70,0.28)] rounded-[28px] sm:rounded-[36px] border border-white/10 p-6 sm:p-8 md:p-10 overflow-hidden">
				<div class="absolute inset-0 pointer-events-none">
					<div class="absolute -right-24 -top-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
					<div class="absolute -left-16 bottom-0 w-60 h-60 bg-emerald-600/25 rounded-full blur-3xl"></div>
				</div>
				<div class="relative grid gap-8 lg:gap-12 lg:grid-cols-[1.05fr,0.95fr] items-start">
					<div class="space-y-7 text-white">
							<div class="space-y-3">
							<p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-emerald-900 bg-emerald-50/90 rounded-full px-4 py-1 border border-emerald-100 shadow-sm">Testimonials</p>
							<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-emerald-50 leading-tight">What Our Patients Say</h2>
							<p class="text-base md:text-lg text-emerald-100 leading-relaxed">Real healthcare journeys from people who discovered trusted doctors and clinics with PrimeDoctors.</p>
							</div>
							<div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
							<div class="rounded-2xl border border-white/25 bg-white/10 backdrop-blur-sm p-4 shadow-lg shadow-emerald-900/10">
								<div class="text-3xl font-semibold text-white">4.9/5</div>
								<p class="text-emerald-100 mt-1 text-sm">Average satisfaction</p>
								</div>
							<div class="rounded-2xl border border-white/25 bg-white/10 backdrop-blur-sm p-4 shadow-lg shadow-emerald-900/10">
								<div class="text-3xl font-semibold text-white">2K+</div>
								<p class="text-emerald-100 mt-1 text-sm">Verified stories</p>
								</div>
							<div class="rounded-2xl border border-white/25 bg-white/10 backdrop-blur-sm p-4 shadow-lg shadow-emerald-900/10 col-span-2 sm:col-span-1">
								<div class="text-3xl font-semibold text-white">50+</div>
								<p class="text-emerald-100 mt-1 text-sm">Specialties covered</p>
								</div>
							</div>
							<div class="flex flex-col gap-4 sm:flex-row sm:items-center">
							<button class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white/90 px-6 py-3.5 text-base font-semibold text-emerald-900 shadow-lg shadow-emerald-900/20 ring-offset-2 transition hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 min-h-[48px]">
									<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 5v14m-7-7h14" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									Share your story
								</button>
							<div class="text-sm text-emerald-100 leading-relaxed">Your experience helps other patients feel confident about their care.</div>
							</div>
						<div class="flex flex-wrap items-center gap-4 rounded-2xl border border-white/25 bg-white/10 px-4 py-3 shadow-lg backdrop-blur-md">
								<div class="flex -space-x-3">
								<div class="w-10 h-10 rounded-full bg-white/80 text-emerald-900 font-semibold flex items-center justify-center border-2 border-emerald-900/20">SM</div>
								<div class="w-10 h-10 rounded-full bg-white/60 text-emerald-900 font-semibold flex items-center justify-center border-2 border-emerald-900/20">JD</div>
								<div class="w-10 h-10 rounded-full bg-white/80 text-emerald-900 font-semibold flex items-center justify-center border-2 border-emerald-900/20">EW</div>
								</div>
								<div>
								<p class="text-xs uppercase tracking-wide text-emerald-200">Trusted by patients nationwide</p>
								<p class="text-sm font-semibold text-white">Tap a card to read more</p>
								</div>
							</div>
						</div>
						<div class="space-y-4" role="list" aria-label="Patient testimonials">
							<article id="testimonial-sarah" class="h-full rounded-3xl border border-white/30 bg-white/95 p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl" role="listitem">
								<div class="flex items-center gap-3">
									<div class="w-12 h-12 rounded-full bg-brand-200 text-brand-700 font-semibold flex items-center justify-center">SM</div>
									<div>
										<p class="text-base font-semibold text-gray-900">Sarah Mitchell</p>
										<p class="text-xs text-gray-500">Cardiology visit · Austin, TX</p>
									</div>
									<span class="ml-auto inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
										<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										Verified
									</span>
								</div>
								<p class="mt-5 text-base leading-relaxed text-gray-700 border-l-2 border-brand-100 pl-4">
									“Found an excellent cardiologist in my area. The search was easy and the doctor was professional and caring. Highly recommend!”
								</p>
								<div class="mt-6 flex items-center justify-between text-sm font-semibold">
									<div class="inline-flex items-center gap-1 text-yellow-500">
										@for($i = 0; $i < 5; $i++)
											<svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
												<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
											</svg>
										@endfor
									</div>
									<a href="#testimonial-sarah" class="inline-flex items-center gap-1 text-brand-700 hover:gap-1.5 transition-all">
										Read story
										<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
								</div>
							</article>
							<article id="testimonial-james" class="h-full rounded-3xl border border-white/30 bg-white/95 p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl" role="listitem">
								<div class="flex items-center gap-3">
									<div class="w-12 h-12 rounded-full bg-brand-100 text-brand-700 font-semibold flex items-center justify-center">JD</div>
									<div>
										<p class="text-base font-semibold text-gray-900">James Davis</p>
										<p class="text-xs text-gray-500">Primary care · Seattle, WA</p>
									</div>
									<span class="ml-auto inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">
										Family care
									</span>
								</div>
								<p class="mt-5 text-base leading-relaxed text-gray-700 border-l-2 border-brand-100 pl-4">
									“The platform made it simple to compare different clinics and read about their services. Found exactly what I needed for my family.”
								</p>
								<div class="mt-6 flex items-center justify-between text-sm font-semibold">
									<div class="inline-flex items-center gap-1 text-yellow-500">
										@for($i = 0; $i < 5; $i++)
											<svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
												<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
											</svg>
										@endfor
									</div>
									<a href="#testimonial-james" class="inline-flex items-center gap-1 text-brand-700 hover:gap-1.5 transition-all">
										Read story
										<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
								</div>
							</article>
							<article id="testimonial-emily" class="h-full rounded-3xl border border-white/30 bg-white/95 p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl" role="listitem">
								<div class="flex items-center gap-3">
									<div class="w-12 h-12 rounded-full bg-brand-200 text-brand-700 font-semibold flex items-center justify-center">EW</div>
									<div>
										<p class="text-base font-semibold text-gray-900">Emily Wilson</p>
										<p class="text-xs text-gray-500">Pediatric visit · Denver, CO</p>
									</div>
									<span class="ml-auto inline-flex items-center gap-1 rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
										Pediatrics
									</span>
								</div>
								<p class="mt-5 text-base leading-relaxed text-gray-700 border-l-2 border-brand-100 pl-4">
									“Great experience! I was able to find a pediatrician for my daughter quickly. The information provided was comprehensive and helpful.”
								</p>
								<div class="mt-6 flex items-center justify-between text-sm font-semibold">
									<div class="inline-flex items-center gap-1 text-yellow-500">
										@for($i = 0; $i < 5; $i++)
											<svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
												<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"/>
											</svg>
										@endfor
									</div>
									<a href="#testimonial-emily" class="inline-flex items-center gap-1 text-brand-700 hover:gap-1.5 transition-all">
										Read story
										<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
								</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Health Articles/Tips Section -->
		<section class="relative mt-8 sm:mt-12 px-0 sm:px-0 mx-0 sm:mx-0">
			<div class="relative mx-auto max-w-7xl overflow-hidden rounded-[28px] sm:rounded-[36px] border border-white/10 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 shadow-[0_25px_60px_rgba(4,78,25,0.35)]">
				<div class="absolute inset-0 pointer-events-none">
					<div class="absolute -top-24 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
					<div class="absolute -bottom-28 -left-16 w-72 h-72 bg-emerald-600/30 rounded-full blur-3xl"></div>
					<div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_55%)]"></div>
				</div>

				<div class="relative z-10 px-4 sm:px-6 lg:px-12 py-8 sm:py-10">
					<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
						<div class="flex-1 space-y-4 text-white">
							<p class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50/90 backdrop-blur">
								<span class="inline-block h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span>
								Health insights
							</p>
							<div class="space-y-3">
								<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight text-white">Health Tips & Articles</h2>
								<p class="text-sm sm:text-base md:text-lg text-emerald-100 max-w-2xl">Stay informed with expert health advice, proactive care playbooks, and wellness perspectives from medical professionals.</p>
							</div>
						</div>
						<div class="w-full lg:max-w-sm flex flex-col gap-4 text-emerald-100">
							<div class="flex flex-wrap items-center gap-4 rounded-2xl border border-white/15 bg-white/5 px-4 py-3 backdrop-blur">
								<div class="flex -space-x-3">
									<span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/40 bg-white/90 text-emerald-900 font-semibold text-sm">MD</span>
									<span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/40 bg-emerald-50/80 text-emerald-900 font-semibold text-sm">RN</span>
									<span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/40 bg-cyan-50/80 text-emerald-900 font-semibold text-sm">PT</span>
								</div>
								<div class="flex-1 min-w-[160px]">
									<p class="text-xs uppercase tracking-wide text-emerald-200">Editorial board</p>
									<p class="text-sm font-semibold text-white">Updated every Monday</p>
								</div>
							</div>
							<a href="{{ route('blog.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-2xl bg-white/90 px-5 py-3 text-base font-semibold text-emerald-900 shadow-lg shadow-emerald-900/30 transition hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900">
								<span>View all articles</span>
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
								</svg>
							</a>
						</div>
					</div>

					<div class="mt-8 grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6 xl:gap-8 sm:grid-cols-2 lg:grid-cols-3">
						<a href="#" class="article-card group flex h-full flex-col overflow-hidden rounded-2xl border border-white/20 bg-white text-left shadow-lg shadow-emerald-900/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2">
							<div class="relative h-44 sm:h-52 lg:h-56 bg-gradient-to-br from-emerald-100 via-white to-emerald-200">
								<div class="absolute inset-0 bg-gradient-to-t from-black/15 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<svg class="w-20 h-20 sm:w-24 sm:h-24 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-emerald-400/70 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
								</svg>
								<div class="absolute top-4 right-4 inline-flex items-center gap-2 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700 shadow">Wellness</div>
							</div>
							<div class="flex flex-1 flex-col p-5 sm:p-6">
								<h3 class="font-semibold text-lg sm:text-xl text-gray-900 mb-3 leading-snug group-hover:text-emerald-800 transition-colors">Preventive Care: Your First Line of Defense</h3>
								<p class="text-sm sm:text-base text-gray-600 mb-5 line-clamp-3 leading-relaxed">Learn how regular check-ups and preventive measures can help maintain your health and catch issues early.</p>
								<div class="mt-auto space-y-4">
									<div class="flex items-center gap-3 text-xs sm:text-sm text-gray-500">
										<span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 font-semibold">AR</span>
										<div>
											<p class="font-medium text-gray-900">Dr. Avery Ross</p>
											<p>4 min read</p>
										</div>
									</div>
									<div class="flex items-center gap-2 font-semibold text-emerald-700 group-hover:text-emerald-800">
										<span>Read more</span>
										<svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
										</svg>
									</div>
								</div>
							</div>
						</a>
						<a href="#" class="article-card group flex h-full flex-col overflow-hidden rounded-2xl border border-white/20 bg-white text-left shadow-lg shadow-emerald-900/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2">
							<div class="relative h-44 sm:h-52 lg:h-56 bg-gradient-to-br from-blue-100 via-white to-blue-200">
								<div class="absolute inset-0 bg-gradient-to-t from-black/15 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<svg class="w-20 h-20 sm:w-24 sm:h-24 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-blue-400/70 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
								</svg>
								<div class="absolute top-4 right-4 inline-flex items-center gap-2 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-blue-700 shadow">Education</div>
							</div>
							<div class="flex flex-1 flex-col p-5 sm:p-6">
								<h3 class="font-semibold text-lg sm:text-xl text-gray-900 mb-3 leading-snug group-hover:text-emerald-800 transition-colors">Understanding Your Health Insurance</h3>
								<p class="text-sm sm:text-base text-gray-600 mb-5 line-clamp-3 leading-relaxed">A comprehensive guide to navigating health insurance coverage and making the most of your benefits.</p>
								<div class="mt-auto space-y-4">
									<div class="flex items-center gap-3 text-xs sm:text-sm text-gray-500">
										<span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-blue-700 font-semibold">LB</span>
										<div>
											<p class="font-medium text-gray-900">Lauren Brooks, RN</p>
											<p>6 min read</p>
										</div>
									</div>
									<div class="flex items-center gap-2 font-semibold text-emerald-700 group-hover:text-emerald-800">
										<span>Read more</span>
										<svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
										</svg>
									</div>
								</div>
							</div>
						</a>
						<a href="#" class="article-card group flex h-full flex-col overflow-hidden rounded-2xl border border-white/20 bg-white text-left shadow-lg shadow-emerald-900/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2">
							<div class="relative h-44 sm:h-52 lg:h-56 bg-gradient-to-br from-purple-100 via-white to-purple-200">
								<div class="absolute inset-0 bg-gradient-to-t from-black/15 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<svg class="w-20 h-20 sm:w-24 sm:h-24 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-purple-400/70 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
								</svg>
								<div class="absolute top-4 right-4 inline-flex items-center gap-2 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-purple-700 shadow">Lifestyle</div>
							</div>
							<div class="flex flex-1 flex-col p-5 sm:p-6">
								<h3 class="font-semibold text-lg sm:text-xl text-gray-900 mb-3 leading-snug group-hover:text-emerald-800 transition-colors">Mental Health Matters</h3>
								<p class="text-sm sm:text-base text-gray-600 mb-5 line-clamp-3 leading-relaxed">Discover strategies for maintaining good mental health and when to seek professional help.</p>
								<div class="mt-auto space-y-4">
									<div class="flex items-center gap-3 text-xs sm:text-sm text-gray-500">
										<span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-purple-50 text-purple-700 font-semibold">SK</span>
										<div>
											<p class="font-medium text-gray-900">Dr. Sophia Khan</p>
											<p>5 min read</p>
										</div>
									</div>
									<div class="flex items-center gap-2 font-semibold text-emerald-700 group-hover:text-emerald-800">
										<span>Read more</span>
										<svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
										</svg>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- Special Offers/Promotions Section -->
		<section class="relative mt-8 sm:mt-12 px-0 sm:px-0 mx-0 sm:mx-0">
			<div class="relative mx-auto max-w-7xl overflow-hidden rounded-[28px] sm:rounded-[36px] border border-white/10 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 shadow-[0_25px_60px_rgba(4,78,25,0.35)]">
				<div class="absolute inset-0 pointer-events-none">
					<div class="absolute -top-24 -right-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
					<div class="absolute -bottom-28 -left-16 w-72 h-72 bg-emerald-600/30 rounded-full blur-3xl"></div>
					<div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_55%)]"></div>
				</div>
				<div class="relative z-10 px-4 sm:px-6 lg:px-12 py-8 sm:py-10 lg:py-12">
					<div class="mx-auto max-w-3xl text-center text-white space-y-4">
						<p class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50/90 backdrop-blur">
							<span class="inline-block h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span>
							Special offer
						</p>
						<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight">Special Health Checkup Offer</h2>
						<p class="text-sm sm:text-base md:text-lg text-emerald-50/90">
							Get 20% off on comprehensive health checkups at participating clinics. Limited time offer!
						</p>
					</div>
					<div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
						<a href="{{ route('organizations.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-2xl bg-white/95 px-6 sm:px-8 py-3 text-base font-semibold text-emerald-900 shadow-lg shadow-emerald-900/30 transition hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900 touch-manipulation">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
							</svg>
							<span>Find Participating Clinics</span>
						</a>
						<a href="#" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-2xl border border-white/60 bg-white/5 px-6 sm:px-8 py-3 text-base font-semibold text-white transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900 touch-manipulation">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
							</svg>
							<span>Learn More</span>
						</a>
					</div>
					<div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 text-white">
						<div class="flex items-center gap-3 rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm sm:text-base backdrop-blur">
							<svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
							</svg>
							<div class="text-left">
								<p class="font-semibold">Valid until month end</p>
								<p class="text-emerald-100/80 text-xs sm:text-sm">Schedule anytime this month</p>
							</div>
						</div>
						<div class="flex items-center gap-3 rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm sm:text-base backdrop-blur">
							<svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
							</svg>
							<div class="text-left">
								<p class="font-semibold">Transparent pricing</p>
								<p class="text-emerald-100/80 text-xs sm:text-sm">No hidden fees or extras</p>
							</div>
						</div>
						<div class="flex items-center gap-3 rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm sm:text-base backdrop-blur">
							<svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
							</svg>
							<div class="text-left">
								<p class="font-semibold">Easy booking</p>
								<p class="text-emerald-100/80 text-xs sm:text-sm">Reserve online in minutes</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Mobile App Promotion Section -->
		<section class="relative mt-8 sm:mt-12 px-0 sm:px-0 mx-0 sm:mx-0">
			<div class="relative mx-auto max-w-7xl overflow-hidden rounded-[28px] sm:rounded-[36px] border border-white/10 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 shadow-[0_25px_60px_rgba(4,78,25,0.35)]">
				<div class="absolute inset-0 pointer-events-none">
					<div class="absolute -top-16 -left-10 w-60 h-60 bg-emerald-500/30 rounded-full blur-3xl"></div>
					<div class="absolute -bottom-20 -right-12 w-72 h-72 bg-white/15 rounded-full blur-3xl"></div>
					<div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom,_rgba(255,255,255,0.08),_transparent_55%)]"></div>
				</div>
				<div class="relative z-10 px-4 sm:px-6 lg:px-12 py-8 sm:py-10 lg:py-12">
					<div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
						<div class="text-white space-y-6">
							<p class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50/90 backdrop-blur">
								<span class="inline-block h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span>
								Mobile app
							</p>
							<div class="space-y-4">
								<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight">Take Your Health Care On The Go</h2>
								<p class="text-sm sm:text-base md:text-lg text-emerald-50/90">
									Download our mobile app for instant access to doctors, clinics, and health resources. Book appointments, read reviews, and manage your health all in one place.
								</p>
							</div>
							<div class="flex flex-col sm:flex-row gap-4">
								<a href="#" class="inline-flex items-center justify-center gap-3 rounded-2xl bg-white/95 px-6 py-3 text-base font-semibold text-emerald-900 shadow-lg shadow-emerald-900/30 transition hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900 touch-manipulation">
									<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
										<path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
									</svg>
									<div class="text-left">
										<p class="text-xs uppercase tracking-wide text-emerald-900/80">Download on the</p>
										<p class="text-lg font-semibold leading-tight">App Store</p>
									</div>
								</a>
								<a href="#" class="inline-flex items-center justify-center gap-3 rounded-2xl border border-white/50 bg-white/10 px-6 py-3 text-base font-semibold text-white transition hover:bg-white/15 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900 touch-manipulation">
									<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
										<path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
									</svg>
									<div class="text-left">
										<p class="text-xs uppercase tracking-wide text-white/80">Get it on</p>
										<p class="text-lg font-semibold leading-tight">Google Play</p>
									</div>
								</a>
							</div>
							<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-white">
								<div class="rounded-2xl border border-white/20 bg-white/10 p-4 backdrop-blur">
									<div class="flex items-center gap-2 text-emerald-200">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
										</svg>
										<span class="font-semibold">Easy booking</span>
									</div>
									<p class="mt-2 text-emerald-50/80 text-xs sm:text-sm">Reserve visits in seconds</p>
								</div>
								<div class="rounded-2xl border border-white/20 bg-white/10 p-4 backdrop-blur">
									<div class="flex items-center gap-2 text-emerald-200">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
										</svg>
										<span class="font-semibold">Health records</span>
									</div>
									<p class="mt-2 text-emerald-50/80 text-xs sm:text-sm">Keep labs & notes close</p>
								</div>
								<div class="rounded-2xl border border-white/20 bg-white/10 p-4 backdrop-blur">
									<div class="flex items-center gap-2 text-emerald-200">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
										</svg>
										<span class="font-semibold">Smart reminders</span>
									</div>
									<p class="mt-2 text-emerald-50/80 text-xs sm:text-sm">Never miss follow-ups</p>
								</div>
							</div>
						</div>
						<div class="relative">
							<div class="relative rounded-[30px] border border-white/15 bg-white/10 p-1 shadow-[0_20px_40px_rgba(0,0,0,0.25)] backdrop-blur">
								<div class="relative rounded-[26px] bg-white p-6 sm:p-8">
									<div class="flex items-center justify-between">
										<div>
											<p class="text-sm font-semibold text-gray-500">Appointments</p>
											<p class="text-2xl font-bold text-gray-900">Upcoming</p>
										</div>
										<div class="rounded-full border border-gray-200 p-2 text-brand-600">
											<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
											</svg>
										</div>
									</div>
									<div class="mt-6 space-y-4">
										<div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
											<p class="text-xs uppercase tracking-wide text-gray-500">Tomorrow · 9:30 AM</p>
											<p class="text-lg font-semibold text-gray-900">Dr. Elena Costa</p>
											<p class="text-sm text-gray-600">Cardiology · Downtown Clinic</p>
										</div>
										<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
											<p class="text-xs uppercase tracking-wide text-gray-500">Friday · 11:00 AM</p>
											<p class="text-lg font-semibold text-gray-900">Physio Check</p>
											<p class="text-sm text-gray-600">Motion Recovery Center</p>
										</div>
										<div class="rounded-2xl border border-gray-100 bg-white/70 p-4">
											<p class="text-xs uppercase tracking-wide text-gray-500">Next week</p>
											<p class="text-lg font-semibold text-gray-900">Lab results</p>
											<p class="text-sm text-gray-600">Results ready · Download PDF</p>
										</div>
									</div>
									<div class="mt-6 flex items-center justify-between rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3">
										<div>
											<p class="text-xs uppercase tracking-wide text-gray-500">Goals</p>
											<p class="text-base font-semibold text-gray-900">Daily hydration target</p>
										</div>
										<div class="inline-flex items-center gap-2 text-emerald-600">
											<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
											</svg>
											<span class="text-sm font-semibold">Completed</span>
										</div>
									</div>
								</div>
							</div>
							<div class="absolute -bottom-6 -right-4 hidden sm:block">
								<div class="rounded-2xl border border-white/30 bg-white/20 px-4 py-3 text-white shadow-lg backdrop-blur">
									<p class="text-xs uppercase tracking-wide text-white/70">Insights</p>
									<p class="text-sm font-semibold">New recommendations available</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Partnerships Section -->
		<section class="relative mt-8 sm:mt-12 px-0 sm:px-0 mx-0 sm:mx-0">
			<div class="relative mx-auto max-w-7xl overflow-hidden rounded-[28px] sm:rounded-[36px] border border-white/10 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 shadow-[0_25px_60px_rgba(4,78,25,0.35)]">
				<div class="absolute inset-0 pointer-events-none">
					<div class="absolute -top-20 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
					<div class="absolute -bottom-24 -left-16 w-72 h-72 bg-emerald-600/30 rounded-full blur-3xl"></div>
					<div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_55%)]"></div>
				</div>
				<div class="relative z-10 px-4 sm:px-6 lg:px-12 py-8 sm:py-10 lg:py-12 text-white">
					<div class="text-center mb-8 sm:mb-10 lg:mb-12 space-y-4">
						<p class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50/90 backdrop-blur">Trusted partners</p>
						<div class="space-y-3">
							<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight">Healthcare collaborations that power PrimeDoctors</h2>
							<p class="text-sm sm:text-base md:text-lg text-emerald-100 max-w-3xl mx-auto">We work with top-tier networks to deliver better coverage, clinical expertise, and faster patient outcomes across every specialty.</p>
						</div>
					</div>
					<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-6">
						@php
							$partners = [
								['label' => 'Health Insurance', 'color' => 'emerald', 'icon' => 'file-text'],
								['label' => 'Medical Centers', 'color' => 'cyan', 'icon' => 'office'],
								['label' => 'Pharmacy Networks', 'color' => 'purple', 'icon' => 'capsule'],
								['label' => 'Research Labs', 'color' => 'green', 'icon' => 'labs'],
								['label' => 'Healthcare Groups', 'color' => 'amber', 'icon' => 'people'],
							];

							$iconPaths = [
								'file-text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
								'office' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
								'capsule' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
								'labs' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
								'people' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
							];
						@endphp
						@foreach($partners as $partner)
							<div class="partner-card group relative flex flex-col items-center justify-center rounded-2xl border border-white/15 bg-white/5 p-5 sm:p-6 backdrop-blur hover:bg-white/10 transition-all duration-300 cursor-pointer text-center">
								<div class="absolute inset-px rounded-2xl bg-gradient-to-br from-white/5 via-transparent to-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<div class="relative z-10 flex flex-col items-center gap-4">
									<div class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center rounded-2xl bg-white/90 text-emerald-900 shadow-lg shadow-emerald-950/20 group-hover:-translate-y-1 transition-transform">
										<svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
											<path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$partner['icon']] }}"/>
										</svg>
									</div>
									<div class="space-y-2">
										<p class="text-sm sm:text-base font-semibold">{{ $partner['label'] }}</p>
										<p class="text-xs text-emerald-100">Verified network</p>
									</div>
								</div>
								<div class="absolute top-3 right-3 w-2 h-2 bg-white/70 rounded-full animate-pulse"></div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection


