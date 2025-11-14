@extends('layouts.app')

@section('title', 'Find Doctors & Clinics')

@section('content')
	<div class="grid gap-8">
		<section class="hero bg-subtle text-center relative">
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
			<h1 class="hero-title relative z-10 flex items-center justify-center gap-3">
				<svg class="w-8 h-8 sm:w-10 sm:h-10 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M12 4v16M4 12h16" stroke-linecap="round"/>
				</svg>
				<span>Find the care that fits you</span>
				<svg class="w-8 h-8 sm:w-10 sm:h-10 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25a4.5 4.5 0 0 1 8.25-2.602A4.5 4.5 0 0 1 21 8.25Z" stroke-linecap="round"/>
				</svg>
			</h1>
			<p class="hero-subtitle text-center mx-auto max-w-2xl">Search by doctor, clinic, specialty, or city — quick filters and a gentle, mobile‑friendly experience.</p>

			<form action="{{ route('search.index') }}" method="get" class="mt-6 ajax-filter-form mx-auto" data-ajax-list="true" data-results="#home-doctors-results">
				<div class="flex flex-col sm:flex-row gap-3">
					<div class="relative flex-1">
						<span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
								<path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.8l3.613 3.614a.75.75 0 1 0 1.06-1.06l-3.614-3.614A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
							</svg>
						</span>
						<input
							type="text"
							name="q"
							value="{{ old('q', $query) }}"
							placeholder="Search doctors, specialties, or cities"
							class="input pl-10 h-12 sm:h-12"
							autocomplete="off"
						/>
						<button
							type="button"
							class="clear-input absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
							aria-label="Clear"
							onclick="const i=this.closest('div').querySelector('input[name=q]'); i.value=''; i.focus(); i.dispatchEvent(new Event('input',{bubbles:true}));"
						>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
								<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 0 1 1.414 0L10 8.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
							</svg>
						</button>
					</div>
				</div>
				<div class="mt-3 flex flex-wrap gap-2 text-sm">
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Therapist'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Therapist</button>
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Pediatrician'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Pediatrician</button>
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Dentist'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Dentist</button>
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Cardiologist'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Cardiologist</button>
				</div>
			</form>
			<section id="home-doctors-results" class="mt-6 md:mt-8">
				@include('search._results', [
					'q' => $query ?? '',
					'doctors' => collect(),
					'organizations' => collect(),
					'specialties' => collect(),
				])
			</section>
		</section>

		<section>
			<h2 class="text-lg font-medium text-gray-900 mb-3">Popular specialties</h2>
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
				@forelse($popularSpecialties as $spec)
					<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" target="_blank" rel="noopener noreferrer" class="specialty-card block rounded-lg bg-white border shadow-sm px-4 py-3 hover:border-brand-600 hover:shadow transition text-gray-800 group relative overflow-hidden">
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

		<section class="grid md:grid-cols-2 gap-8">
			<div>
				<div class="flex items-center justify-between mb-3">
					<h2 class="text-lg font-medium text-gray-900">Featured doctors</h2>
					<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="text-brand-700 hover:underline text-sm">Browse all</a>
				</div>
				<div class="grid sm:grid-cols-2 gap-4">
					@forelse($featuredDoctors as $doctor)
						<a href="{{ route('doctors.show', $doctor) }}" target="_blank" rel="noopener noreferrer" class="doctor-card block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition group relative overflow-hidden">
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
			<div>
				<div class="flex items-center justify-between mb-3">
					<h2 class="text-lg font-medium text-gray-900">Featured organizations</h2>
					<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="text-brand-700 hover:underline text-sm">Browse all</a>
				</div>
				<div class="grid sm:grid-cols-2 gap-4">
					@forelse($featuredOrganizations as $org)
						<a href="{{ route('organizations.show', $org) }}" target="_blank" rel="noopener noreferrer" class="organization-card block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition group relative overflow-hidden">
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
	</div>
@endsection


