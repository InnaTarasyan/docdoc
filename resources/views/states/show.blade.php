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
				@if($doctors->count() > 0)
					<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
						@foreach($doctors as $doctor)
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
								$folder = $isFemale ? 'women' : 'men';
								$avatarUrl = "https://randomuser.me/api/portraits/{$folder}/{$idx}.jpg";
								$taxonomy = $doctor->taxonomy ?? '';
							@endphp
							<a href="{{ route('doctors.show', $doctor) }}" class="doctor-card block rounded-2xl bg-white border border-gray-100 p-4 shadow-sm hover:border-brand-500 hover:shadow-lg hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 transition-all duration-300 group relative overflow-hidden">
								<div class="absolute inset-0 bg-gradient-to-br from-brand-50/80 via-transparent to-brand-100/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<div class="relative z-10 flex items-start gap-4">
									<div class="relative shrink-0">
										<img src="{{ $avatarUrl }}" alt="{{ $doctor->name }}" class="doctor-avatar w-14 h-14 rounded-full ring-2 ring-brand-100 group-hover:ring-brand-400 object-cover bg-white transition-all duration-300" loading="lazy" decoding="async" />
									</div>
									<div class="min-w-0 flex-1">
										<div class="font-semibold text-gray-900 truncate group-hover:text-brand-700 transition-colors">{{ $doctor->name }}</div>
										<div class="text-sm text-gray-600 truncate mt-0.5">{{ $taxonomy ?: 'General practitioner' }}</div>
										@if($doctor->city)
											<div class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M12 21a9 9 0 1 0-9-9c0 5 9 9 9 9z"/>
													<circle cx="12" cy="12" r="3"/>
												</svg>
												<span>{{ $doctor->city }}</span>
											</div>
										@endif
									</div>
								</div>
							</a>
						@endforeach
					</div>
					<div class="mt-6">
						{{ $doctors->links() }}
					</div>
				@else
					<p class="text-gray-600 text-center py-8">No doctors found in {{ $stateName }}.</p>
				@endif
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
				@if($organizations->count() > 0)
					<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
						@foreach($organizations as $org)
							@php
								$seed = abs(crc32(($org->name ?? '') . '|' . (string) $org->id));
								$featuredHospitalImages = [
									'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=256&h=256&fit=crop',
									'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=256&h=256&fit=crop',
									'https://images.unsplash.com/photo-1512678080530-7760d81faba6?w=256&h=256&fit=crop',
									'https://images.unsplash.com/photo-1599043513900-ed6fe01d3833?w=256&h=256&fit=crop',
								];
								$imgIndex = $seed % count($featuredHospitalImages);
								$imgUrl = $featuredHospitalImages[$imgIndex];
							@endphp
							<a href="{{ route('organizations.show', $org) }}" class="organization-card block rounded-2xl bg-white border border-gray-100 p-4 shadow-sm hover:border-brand-500 hover:shadow-lg hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 transition-all duration-300 group relative overflow-hidden">
								<div class="absolute inset-0 bg-gradient-to-br from-brand-50/70 via-transparent to-brand-100/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								<div class="relative z-10 flex items-start gap-4">
									<div class="relative shrink-0">
										<img src="{{ $imgUrl }}" alt="{{ $org->name }}" class="organization-image w-14 h-14 rounded-2xl ring-2 ring-brand-100 group-hover:ring-brand-400 object-cover bg-white transition-all duration-300" loading="lazy" decoding="async" width="56" height="56" />
									</div>
									<div class="min-w-0 flex-1">
										<div class="font-semibold text-gray-900 truncate group-hover:text-brand-700 transition-colors">{{ $org->name }}</div>
										@if($org->city)
											<div class="text-sm text-gray-600 mt-0.5 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M12 21a9 9 0 1 0-9-9c0 5 9 9 9 9z"/>
													<circle cx="12" cy="12" r="3"/>
												</svg>
												<span>{{ $org->city }}</span>
											</div>
										@endif
										@if($org->phone)
											<div class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
												<span>{{ $org->phone }}</span>
											</div>
										@endif
									</div>
								</div>
							</a>
						@endforeach
					</div>
					<div class="mt-6">
						{{ $organizations->links() }}
					</div>
				@else
					<p class="text-gray-600 text-center py-8">No organizations found in {{ $stateName }}.</p>
				@endif
			</div>
		</section>
	</div>
@endsection

