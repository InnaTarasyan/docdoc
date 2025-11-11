@extends('layouts.app')

@section('title', 'Find Doctors & Clinics')

@section('content')
	<div class="grid gap-8">
		<section class="hero">
			<h1 class="hero-title">Find the right doctor or clinic</h1>
			<p class="hero-subtitle">Search by doctor name, specialty, or city. Quick filters, responsive design, and intuitive navigation.</p>

			<form action="{{ route('doctors.index') }}" method="get" class="mt-6 ajax-filter-form" data-ajax-list="true" data-results="#home-doctors-results">
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
					</div>
					<button type="submit" class="btn-primary h-12 sm:h-12 px-6">
						Search
					</button>
				</div>
				<div class="mt-3 flex flex-wrap gap-2 text-sm">
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Therapist'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Therapist</button>
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Pediatrician'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Pediatrician</button>
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Dentist'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Dentist</button>
					<button type="button" class="badge-sky" onclick="this.closest('form').q.value='Cardiologist'; this.closest('form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))">Cardiologist</button>
				</div>
			</form>
			<section id="home-doctors-results" class="mt-6 md:mt-8"></section>
		</section>

		<section>
			<h2 class="text-lg font-medium text-gray-900 mb-3">Popular specialties</h2>
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
				@forelse($popularSpecialties as $spec)
					<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" target="_blank" rel="noopener noreferrer" class="block rounded-lg bg-white border shadow-sm px-4 py-3 hover:border-sky-600 hover:shadow transition text-gray-800">
						<div class="flex items-center gap-2">
							@include('components.specialty-icon', ['name' => $spec->description, 'class' => 'mr-1'])
							<span class="truncate">{{ $spec->description }}</span>
						</div>
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
					<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="text-sky-700 hover:underline text-sm">Browse all</a>
				</div>
				<div class="grid sm:grid-cols-2 gap-4">
					@forelse($featuredDoctors as $doctor)
						<a href="{{ route('doctors.show', $doctor) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
							<div class="flex items-start gap-4">
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
								@endphp
								<img src="{{ $avatarUrl }}" alt="{{ $doctor->name }}" class="w-14 h-14 rounded-full ring-1 ring-gray-200 object-cover bg-white shrink-0" loading="lazy" />
								<div class="min-w-0">
									<div class="font-medium text-gray-900 truncate">{{ $doctor->name }}</div>
									<div class="text-sm text-gray-600 truncate">{{ $doctor->taxonomy ?: '—' }}</div>
									<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
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
					<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="text-sky-700 hover:underline text-sm">Browse all</a>
				</div>
				<div class="grid sm:grid-cols-2 gap-4">
					@forelse($featuredOrganizations as $org)
						<a href="{{ route('organizations.show', $org) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
							<div class="flex items-start gap-4">
								@php
									$seed = abs(crc32(($org->name ?? '') . '|' . (string) $org->id));
									$imgUrl = "https://loremflickr.com/256/256/hospital?lock={$seed}";
								@endphp
								<img src="{{ $imgUrl }}" alt="{{ $org->name }}" class="w-16 h-16 rounded-lg ring-1 ring-gray-200 object-cover bg-white shrink-0" loading="lazy" width="64" height="64" />
								<div class="min-w-0">
									<div class="font-medium text-gray-900 truncate">{{ $org->name }}</div>
									<div class="text-sm text-gray-600">{{ $org->city }}, {{ $org->state }}</div>
									@if($org->phone)
										<div class="text-sm text-gray-700 mt-1 truncate">{{ $org->phone }}</div>
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


