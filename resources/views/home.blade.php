@extends('layouts.app')

@section('title', 'Find Doctors & Clinics')

@section('content')
	<div class="grid gap-6 sm:gap-8">
	<section
		class="hero hero--desktop-photo bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950 text-center relative w-full rounded-xl sm:rounded-2xl overflow-hidden"
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

		<section class="mt-6 sm:mt-8">
			<h2 class="text-lg sm:text-xl font-medium text-gray-900 mb-4 sm:mb-3">Popular specialties</h2>
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-3">
				@forelse($popularSpecialties as $spec)
					<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" class="specialty-card block rounded-lg bg-white border shadow-sm px-4 py-3 hover:border-brand-600 hover:shadow transition text-gray-800 group relative overflow-hidden">
						<div class="absolute inset-0 bg-gradient-to-br from-brand-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
						<div class="flex items-center gap-2 relative z-10">
							<div class="specialty-icon-wrapper group-hover:scale-110 transition-transform">
								@include('components.specialty-icon', ['name' => $spec->description, 'class' => 'mr-1'])
							</div>
							<span class="truncate font-medium group-hover:text-brand-700 transition-colors">{{ $spec->description }}</span>
						</div>
						<div class="absolute top-0 right-0 w-16 h-16 bg-brand-100 rounded-full -mr-8 -mt-8 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
					</a>
				@empty
					<p class="text-gray-600">No specialties yet.</p>
				@endforelse
			</div>
		</section>

		<section class="grid md:grid-cols-2 gap-6 sm:gap-8 mt-6 sm:mt-8">
			<div>
				<div class="flex items-center justify-between mb-4 sm:mb-3">
					<h2 class="text-lg sm:text-xl font-medium text-gray-900">Featured doctors</h2>
					<a href="{{ route('doctors.index') }}" class="text-brand-700 hover:underline text-sm sm:text-sm min-h-[44px] flex items-center touch-manipulation">Browse all</a>
				</div>
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-4">
					@forelse($featuredDoctors as $doctor)
						<a href="{{ route('doctors.show', $doctor) }}" class="doctor-card block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition group relative overflow-hidden">
							<div class="absolute inset-0 bg-gradient-to-br from-brand-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
							<div class="flex items-start gap-4 relative z-10">
								@php
									$seed = abs(crc32($doctor->name ?? (string) $doctor->id));
									$idx = $seed % 80;
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
									$folder = $isFemale ? 'women' : 'men';
									$avatarUrl = "https://randomuser.me/api/portraits/{$folder}/{$idx}.jpg";
									$taxonomy = $doctor->taxonomy ?? '';
								@endphp
								<div class="relative shrink-0">
									<img src="{{ $avatarUrl }}" alt="{{ $doctor->name }}" class="doctor-avatar w-14 h-14 rounded-full ring-2 ring-gray-200 group-hover:ring-brand-400 object-cover bg-white transition-all duration-300" loading="lazy" />
									<div class="doctor-icon-wrapper absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100">
										@include('components.specialty-icon', ['name' => $taxonomy, 'class' => 'w-4 h-4'])
									</div>
								</div>
								<div class="min-w-0 flex-1">
									<div class="font-medium text-gray-900 truncate group-hover:text-brand-700 transition-colors flex items-center gap-2">
										<span>{{ $doctor->name }}</span>
										<svg class="w-4 h-4 text-brand-600 opacity-0 group-hover:opacity-100 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
										</svg>
									</div>
									<div class="text-sm text-gray-600 truncate mt-0.5">{{ $doctor->taxonomy ?: '—' }}</div>
									<div class="text-sm text-gray-600 mt-1">{{ $doctor->city }}, {{ $doctor->state }}</div>
									@if($doctor->organization_name)
										<div class="text-sm text-gray-700 mt-1 truncate">{{ $doctor->organization_name }}</div>
									@endif
								</div>
							</div>
						</a>
					@empty
						<p class="text-gray-600">No doctors available.</p>
					@endforelse
				</div>
			</div>
			<div class="mt-6 md:mt-0">
				<div class="flex items-center justify-between mb-4 sm:mb-3">
					<h2 class="text-lg sm:text-xl font-medium text-gray-900">Featured organizations</h2>
					<a href="{{ route('organizations.index') }}" class="text-brand-700 hover:underline text-sm sm:text-sm min-h-[44px] flex items-center touch-manipulation">Browse all</a>
				</div>
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-4">
					@forelse($featuredOrganizations as $org)
						<a href="{{ route('organizations.show', $org) }}" class="organization-card block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition group relative overflow-hidden">
							<div class="absolute inset-0 bg-gradient-to-br from-brand-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
							<div class="flex items-start gap-4 relative z-10">
								@php
									$seed = abs(crc32(($org->name ?? '') . '|' . (string) $org->id));
									$hospitalImages = [
										'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1512678080530-7760d81faba6?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1599043513900-ed6fe01d3833?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1497366216548-37526070297c?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=256&h=256&fit=crop',
										'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=256&h=256&fit=crop'
									];
									$imgUrl = $hospitalImages[$seed % count($hospitalImages)];
								@endphp
								<div class="relative shrink-0">
									<img src="{{ $imgUrl }}" alt="{{ $org->name }}" class="organization-image w-16 h-16 rounded-lg ring-2 ring-gray-200 group-hover:ring-brand-400 object-cover bg-white transition-all duration-300" loading="lazy" width="64" height="64" />
									<div class="absolute -bottom-1 -right-1 bg-brand-600 text-white rounded-full p-1.5 shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100">
										<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
											<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M17 21v-8H7v8M7 3v5h8" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
								</div>
								<div class="min-w-0 flex-1">
									<div class="font-medium text-gray-900 truncate group-hover:text-brand-700 transition-colors flex items-center gap-2">
										<span>{{ $org->name }}</span>
										<svg class="w-4 h-4 text-brand-600 opacity-0 group-hover:opacity-100 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
										</svg>
									</div>
									<div class="text-sm text-gray-600 mt-0.5">{{ $org->city }}, {{ $org->state }}</div>
									@if($org->phone)
										<div class="text-sm text-gray-700 mt-1 truncate flex items-center gap-1">
											<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											{{ $org->phone }}
										</div>
									@endif
								</div>
							</div>
						</a>
					@empty
						<p class="text-gray-600">No organizations available.</p>
					@endforelse
				</div>
			</div>
		</section>

		<!-- User Reviews/Testimonials Section -->
		<section class="bg-white rounded-xl sm:rounded-2xl border shadow-sm p-5 sm:p-8 md:p-10 mt-6 sm:mt-8">
			<div class="text-center mb-6 sm:mb-8">
				<h2 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-900 mb-3 sm:mb-3">What Our Patients Say</h2>
				<p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto px-2">Real experiences from patients who found their perfect healthcare provider through our platform.</p>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
				<div class="testimonial-card bg-gradient-to-br from-brand-50 to-white rounded-xl border border-brand-100 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
					<div class="flex items-center gap-1 mb-4">
						@for($i = 0; $i < 5; $i++)
							<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
								<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
							</svg>
						@endfor
					</div>
					<p class="text-gray-700 mb-4 leading-relaxed">"Found an excellent cardiologist in my area. The search was easy and the doctor was professional and caring. Highly recommend!"</p>
					<div class="flex items-center gap-3">
						<div class="w-10 h-10 rounded-full bg-brand-200 flex items-center justify-center text-brand-700 font-semibold">SM</div>
						<div>
							<div class="font-medium text-gray-900">Sarah Mitchell</div>
							<div class="text-sm text-gray-500">Patient</div>
						</div>
					</div>
				</div>
				<div class="testimonial-card bg-gradient-to-br from-brand-50 to-white rounded-xl border border-brand-100 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
					<div class="flex items-center gap-1 mb-4">
						@for($i = 0; $i < 5; $i++)
							<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
								<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
							</svg>
						@endfor
					</div>
					<p class="text-gray-700 mb-4 leading-relaxed">"The platform made it simple to compare different clinics and read about their services. Found exactly what I needed for my family."</p>
					<div class="flex items-center gap-3">
						<div class="w-10 h-10 rounded-full bg-brand-200 flex items-center justify-center text-brand-700 font-semibold">JD</div>
						<div>
							<div class="font-medium text-gray-900">James Davis</div>
							<div class="text-sm text-gray-500">Patient</div>
						</div>
					</div>
				</div>
				<div class="testimonial-card bg-gradient-to-br from-brand-50 to-white rounded-xl border border-brand-100 p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
					<div class="flex items-center gap-1 mb-4">
						@for($i = 0; $i < 5; $i++)
							<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
								<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
							</svg>
						@endfor
					</div>
					<p class="text-gray-700 mb-4 leading-relaxed">"Great experience! I was able to find a pediatrician for my daughter quickly. The information provided was comprehensive and helpful."</p>
					<div class="flex items-center gap-3">
						<div class="w-10 h-10 rounded-full bg-brand-200 flex items-center justify-center text-brand-700 font-semibold">EW</div>
						<div>
							<div class="font-medium text-gray-900">Emily Wilson</div>
							<div class="text-sm text-gray-500">Patient</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Health Articles/Tips Section -->
		<section class="mb-6 sm:mb-12 mt-6 sm:mt-8">
			<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-6 sm:mb-8 gap-4 sm:gap-3">
				<div class="flex-1">
					<h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-2 sm:mb-3">Health Tips & Articles</h2>
					<p class="text-gray-600 text-sm sm:text-base max-w-2xl">Stay informed with expert health advice and wellness tips from medical professionals</p>
				</div>
				<a href="#" class="text-brand-700 hover:text-brand-800 font-medium text-sm sm:text-base flex items-center gap-1.5 sm:self-end transition-colors min-h-[44px] touch-manipulation">
					<span>View all articles</span>
					<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
					</svg>
				</a>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 xl:gap-8">
				<a href="#" class="article-card group block rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden hover:border-brand-400 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 active:scale-[0.98]">
					<div class="relative h-44 sm:h-52 lg:h-56 bg-gradient-to-br from-brand-100 via-brand-50 to-brand-200 overflow-hidden">
						<div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
						<svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-brand-400 opacity-25 group-hover:opacity-35 group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
						</svg>
						<div class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold text-brand-700 shadow-md group-hover:shadow-lg transition-shadow">Wellness</div>
					</div>
					<div class="p-5 sm:p-6 lg:p-7">
						<h3 class="font-bold text-lg sm:text-xl text-gray-900 mb-3 group-hover:text-brand-700 transition-colors leading-snug line-clamp-2">Preventive Care: Your First Line of Defense</h3>
						<p class="text-sm sm:text-base text-gray-600 mb-5 sm:mb-6 line-clamp-2 leading-relaxed">Learn how regular check-ups and preventive measures can help maintain your health and catch issues early.</p>
						<div class="flex items-center gap-2 text-sm sm:text-base text-brand-700 font-semibold group-hover:text-brand-800 group-hover:gap-3 transition-all">
							<span>Read more</span>
							<svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
							</svg>
						</div>
					</div>
				</a>
				<a href="#" class="article-card group block rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden hover:border-brand-400 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 active:scale-[0.98]">
					<div class="relative h-44 sm:h-52 lg:h-56 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 overflow-hidden">
						<div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
						<svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-blue-400 opacity-25 group-hover:opacity-35 group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
						</svg>
						<div class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold text-blue-700 shadow-md group-hover:shadow-lg transition-shadow">Education</div>
					</div>
					<div class="p-5 sm:p-6 lg:p-7">
						<h3 class="font-bold text-lg sm:text-xl text-gray-900 mb-3 group-hover:text-brand-700 transition-colors leading-snug line-clamp-2">Understanding Your Health Insurance</h3>
						<p class="text-sm sm:text-base text-gray-600 mb-5 sm:mb-6 line-clamp-2 leading-relaxed">A comprehensive guide to navigating health insurance coverage and making the most of your benefits.</p>
						<div class="flex items-center gap-2 text-sm sm:text-base text-brand-700 font-semibold group-hover:text-brand-800 group-hover:gap-3 transition-all">
							<span>Read more</span>
							<svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
							</svg>
						</div>
					</div>
				</a>
				<a href="#" class="article-card group block rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden hover:border-brand-400 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 active:scale-[0.98]">
					<div class="relative h-44 sm:h-52 lg:h-56 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-200 overflow-hidden">
						<div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
						<svg class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-purple-400 opacity-25 group-hover:opacity-35 group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
						</svg>
						<div class="absolute top-3 right-3 sm:top-4 sm:right-4 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold text-purple-700 shadow-md group-hover:shadow-lg transition-shadow">Lifestyle</div>
					</div>
					<div class="p-5 sm:p-6 lg:p-7">
						<h3 class="font-bold text-lg sm:text-xl text-gray-900 mb-3 group-hover:text-brand-700 transition-colors leading-snug line-clamp-2">Mental Health Matters</h3>
						<p class="text-sm sm:text-base text-gray-600 mb-5 sm:mb-6 line-clamp-2 leading-relaxed">Discover strategies for maintaining good mental health and when to seek professional help.</p>
						<div class="flex items-center gap-2 text-sm sm:text-base text-brand-700 font-semibold group-hover:text-brand-800 group-hover:gap-3 transition-all">
							<span>Read more</span>
							<svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
							</svg>
						</div>
					</div>
				</a>
			</div>
		</section>

		<!-- Special Offers/Promotions Section -->
		<section class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-xl sm:rounded-2xl p-6 sm:p-10 md:p-12 relative overflow-hidden mt-6 sm:mt-8" style="background: linear-gradient(135deg, rgb(5, 78, 25) 0%, rgb(4, 60, 19) 100%);">
			<div class="absolute inset-0 opacity-10">
				<svg class="absolute top-0 right-0 w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24">
					<path d="M12 4v16M4 12h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
				<svg class="absolute bottom-0 left-0 w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24">
					<path d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25a4.5 4.5 0 0 1 8.25-2.602A4.5 4.5 0 0 1 21 8.25Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
			</div>
			<div class="relative z-10 max-w-4xl mx-auto text-center">
				<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 sm:mb-4 text-white px-2">Special Health Checkup Offer</h2>
				<p class="text-base sm:text-lg md:text-xl mb-6 max-w-2xl mx-auto text-white opacity-95 px-2">Get 20% off on comprehensive health checkups at participating clinics. Limited time offer!</p>
				<div class="flex flex-col sm:flex-row gap-4 justify-center items-center px-2">
					<a href="{{ route('organizations.index') }}" class="bg-white text-brand-700 px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-brand-50 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full sm:w-auto min-h-[44px] flex items-center justify-center touch-manipulation">
						Find Participating Clinics
					</a>
					<a href="#" class="border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-colors w-full sm:w-auto min-h-[44px] flex items-center justify-center touch-manipulation">
						Learn More
					</a>
				</div>
				<div class="mt-6 sm:mt-8 flex flex-wrap justify-center gap-4 sm:gap-6 text-xs sm:text-sm text-white px-2">
					<div class="flex items-center gap-2">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
						</svg>
						<span class="text-white">Valid until end of month</span>
					</div>
					<div class="flex items-center gap-2">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
						</svg>
						<span class="text-white">No hidden fees</span>
					</div>
					<div class="flex items-center gap-2">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
						</svg>
						<span class="text-white">Easy booking</span>
					</div>
				</div>
			</div>
		</section>

		<!-- Mobile App Promotion Section -->
		<section class="bg-white rounded-xl sm:rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 p-5 sm:p-6 md:p-8 lg:p-10 xl:p-12 mx-auto max-w-7xl mt-6 sm:mt-8">
			<div class="grid md:grid-cols-2 gap-6 sm:gap-8 items-center">
				<div>
					<h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4">Take Your Health Care On The Go</h2>
					<p class="text-base sm:text-lg text-gray-600 mb-6">Download our mobile app for instant access to doctors, clinics, and health resources. Book appointments, read reviews, and manage your health all in one place.</p>
					<div class="flex flex-col sm:flex-row gap-4 mb-6">
						<a href="#" class="inline-flex items-center justify-center gap-3 bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors shadow-lg hover:shadow-xl min-h-[44px] touch-manipulation w-full sm:w-auto">
							<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
								<path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
							</svg>
							<div class="text-left">
								<div class="text-xs opacity-90">Download on the</div>
								<div class="text-lg font-semibold">App Store</div>
							</div>
						</a>
						<a href="#" class="inline-flex items-center justify-center gap-3 bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors shadow-lg hover:shadow-xl min-h-[44px] touch-manipulation w-full sm:w-auto">
							<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
								<path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
							</svg>
							<div class="text-left">
								<div class="text-xs opacity-90">Get it on</div>
								<div class="text-lg font-semibold">Google Play</div>
							</div>
						</a>
					</div>
					<div class="flex flex-wrap gap-4 text-sm text-gray-600">
						<div class="flex items-center gap-2">
							<svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
							</svg>
							<span>Easy booking</span>
						</div>
						<div class="flex items-center gap-2">
							<svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
							</svg>
							<span>Health records</span>
						</div>
						<div class="flex items-center gap-2">
							<svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
							</svg>
							<span>Reminders</span>
						</div>
					</div>
				</div>
				<div class="relative">
					<div class="relative bg-gradient-to-br from-brand-100 to-brand-200 rounded-2xl p-8 shadow-2xl">
						<div class="bg-white rounded-xl shadow-lg p-6 mb-4">
							<div class="flex items-center gap-3 mb-4">
								<div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center">
									<svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M4 12h16"/>
									</svg>
								</div>
								<div>
									<div class="font-semibold text-gray-900">Dr. Sarah Johnson</div>
									<div class="text-sm text-gray-600">Cardiologist</div>
								</div>
							</div>
							<div class="flex items-center gap-2 mb-3">
								@for($i = 0; $i < 5; $i++)
									<svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
										<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
									</svg>
								@endfor
							</div>
							<button class="w-full bg-brand-600 text-white py-2 rounded-lg font-medium hover:bg-brand-700 transition-colors">Book Appointment</button>
						</div>
						<div class="text-center text-sm text-gray-600">📱 Mobile App Preview</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Partnerships Section -->
		<section class="bg-gradient-to-br from-gray-50 via-white to-brand-50/30 rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-8 md:p-10 lg:p-12 mt-6 sm:mt-8">
			<div class="text-center mb-6 sm:mb-8 md:mb-12">
				<h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4 tracking-tight px-2">Trusted Partners</h2>
				<p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed px-2">We collaborate with leading healthcare providers, insurance companies, and medical institutions to bring you the best care.</p>
			</div>
			<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
				<div class="partner-card group relative flex flex-col items-center justify-center p-5 sm:p-6 md:p-7 bg-white border-2 border-gray-200 rounded-2xl hover:border-brand-500 hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer">
					<div class="absolute inset-0 bg-gradient-to-br from-brand-50/0 to-brand-100/0 group-hover:from-brand-50 group-hover:to-brand-100/50 transition-all duration-300 rounded-2xl"></div>
					<div class="relative z-10 text-center w-full">
						<div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto mb-4 sm:mb-5 bg-gradient-to-br from-brand-100 via-brand-50 to-brand-200 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-md group-hover:shadow-lg">
							<svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-brand-600 group-hover:text-brand-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
							</svg>
						</div>
						<div class="text-sm sm:text-base font-semibold text-gray-800 group-hover:text-brand-700 transition-colors">Health Insurance</div>
					</div>
					<div class="absolute top-2 right-2 w-2 h-2 bg-brand-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
				</div>
				<div class="partner-card group relative flex flex-col items-center justify-center p-5 sm:p-6 md:p-7 bg-white border-2 border-gray-200 rounded-2xl hover:border-blue-500 hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer">
					<div class="absolute inset-0 bg-gradient-to-br from-blue-50/0 to-blue-100/0 group-hover:from-blue-50 group-hover:to-blue-100/50 transition-all duration-300 rounded-2xl"></div>
					<div class="relative z-10 text-center w-full">
						<div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto mb-4 sm:mb-5 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-200 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-md group-hover:shadow-lg">
							<svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-blue-600 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
							</svg>
						</div>
						<div class="text-sm sm:text-base font-semibold text-gray-800 group-hover:text-blue-700 transition-colors">Medical Centers</div>
					</div>
					<div class="absolute top-2 right-2 w-2 h-2 bg-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
				</div>
				<div class="partner-card group relative flex flex-col items-center justify-center p-5 sm:p-6 md:p-7 bg-white border-2 border-gray-200 rounded-2xl hover:border-purple-500 hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer">
					<div class="absolute inset-0 bg-gradient-to-br from-purple-50/0 to-purple-100/0 group-hover:from-purple-50 group-hover:to-purple-100/50 transition-all duration-300 rounded-2xl"></div>
					<div class="relative z-10 text-center w-full">
						<div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto mb-4 sm:mb-5 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-200 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-md group-hover:shadow-lg">
							<svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-purple-600 group-hover:text-purple-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
							</svg>
						</div>
						<div class="text-sm sm:text-base font-semibold text-gray-800 group-hover:text-purple-700 transition-colors">Pharmacy Networks</div>
					</div>
					<div class="absolute top-2 right-2 w-2 h-2 bg-purple-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
				</div>
				<div class="partner-card group relative flex flex-col items-center justify-center p-5 sm:p-6 md:p-7 bg-white border-2 border-gray-200 rounded-2xl hover:border-green-500 hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer">
					<div class="absolute inset-0 bg-gradient-to-br from-green-50/0 to-green-100/0 group-hover:from-green-50 group-hover:to-green-100/50 transition-all duration-300 rounded-2xl"></div>
					<div class="relative z-10 text-center w-full">
						<div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto mb-4 sm:mb-5 bg-gradient-to-br from-green-100 via-green-50 to-green-200 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-md group-hover:shadow-lg">
							<svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-green-600 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
							</svg>
						</div>
						<div class="text-sm sm:text-base font-semibold text-gray-800 group-hover:text-green-700 transition-colors">Research Labs</div>
					</div>
					<div class="absolute top-2 right-2 w-2 h-2 bg-green-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
				</div>
				<div class="partner-card group relative flex flex-col items-center justify-center p-5 sm:p-6 md:p-7 bg-white border-2 border-gray-200 rounded-2xl hover:border-orange-500 hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer">
					<div class="absolute inset-0 bg-gradient-to-br from-orange-50/0 to-orange-100/0 group-hover:from-orange-50 group-hover:to-orange-100/50 transition-all duration-300 rounded-2xl"></div>
					<div class="relative z-10 text-center w-full">
						<div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 mx-auto mb-4 sm:mb-5 bg-gradient-to-br from-orange-100 via-orange-50 to-orange-200 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-md group-hover:shadow-lg">
							<svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-orange-600 group-hover:text-orange-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
							</svg>
						</div>
						<div class="text-sm sm:text-base font-semibold text-gray-800 group-hover:text-orange-700 transition-colors">Healthcare Groups</div>
					</div>
					<div class="absolute top-2 right-2 w-2 h-2 bg-orange-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
				</div>
			</div>
		</section>
	</div>
@endsection


