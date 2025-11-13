@php
	$hasAny = ($doctors && $doctors->count() > 0) || ($organizations && $organizations->count() > 0) || ($specialties && $specialties->count() > 0);
@endphp

@if(!$hasAny)
	<div class="bg-white border rounded-xl p-6 text-center text-gray-600 empty-state-wrapper{{ ($q ?? '') === '' ? ' empty-compact' : '' }}">
		<div class="empty-state-content">
			@if(($q ?? '') !== '')
				No results for "{{ $q }}". Try another term.
			@else
				Start typing to search doctors, organizations, or specialties.
			@endif
		</div>
	</div>
@else
	<div class="grid md:grid-cols-2 gap-6">
		<div class="space-y-6">
			@if($doctors && $doctors->count() > 0)
				<section class="section">
					<div class="section-header">
						<div class="flex items-center justify-between">
							<h2 class="font-medium text-gray-900">Doctors</h2>
							<a href="{{ route('doctors.index', ['q' => $q]) }}" target="_blank" rel="noopener noreferrer" class="text-sm text-brand-700 hover:underline">View all</a>
						</div>
					</div>
					<div class="section-body">
						<div class="grid sm:grid-cols-2 gap-4">
							@foreach($doctors as $doctor)
								<a href="{{ route('doctors.show', $doctor) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition">
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
										<img src="{{ $avatarUrl }}" alt="{{ $doctor->name }}" class="w-12 h-12 rounded-full ring-1 ring-gray-200 object-cover bg-white shrink-0" loading="lazy" />
										<div class="min-w-0">
											<div class="font-medium text-gray-900 truncate">{{ $doctor->name }}</div>
											<div class="text-sm text-gray-600 truncate">{{ $doctor->taxonomy ?: '—' }}</div>
											<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
										</div>
									</div>
								</a>
							@endforeach
						</div>
					</div>
				</section>
			@endif
		</div>
		<div class="space-y-6">
			@if($organizations && $organizations->count() > 0)
				<section class="section">
					<div class="section-header">
						<div class="flex items-center justify-between">
							<h2 class="font-medium text-gray-900">Organizations</h2>
							<a href="{{ route('organizations.index', ['q' => $q]) }}" target="_blank" rel="noopener noreferrer" class="text-sm text-brand-700 hover:underline">View all</a>
						</div>
					</div>
					<div class="section-body">
						<div class="grid sm:grid-cols-2 gap-4">
							@foreach($organizations as $org)
								<a href="{{ route('organizations.show', $org) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition">
									<div class="flex items-start gap-4">
										@php
											$seed = abs(crc32(($org->name ?? '') . '|' . (string) $org->id));
											$imgUrl = "https://loremflickr.com/256/256/hospital?lock={$seed}";
										@endphp
										<img src="{{ $imgUrl }}" alt="{{ $org->name }}" class="w-12 h-12 rounded-lg ring-1 ring-gray-200 object-cover bg-white shrink-0" loading="lazy" width="48" height="48" />
										<div class="min-w-0">
											<div class="font-medium text-gray-900 truncate">{{ $org->name }}</div>
											<div class="text-sm text-gray-600 truncate">{{ $org->city }}, {{ $org->state }}</div>
											@if($org->phone)
												<div class="text-sm text-gray-700 mt-1 truncate">{{ $org->phone }}</div>
											@endif
										</div>
									</div>
								</a>
							@endforeach
						</div>
					</div>
				</section>
			@endif

			@if($specialties && $specialties->count() > 0)
				<section class="section">
					<div class="section-header">
						<div class="flex items-center justify-between">
							<h2 class="font-medium text-gray-900">Specialties</h2>
							<a href="{{ route('specialties.index') }}" target="_blank" rel="noopener noreferrer" class="text-sm text-brand-700 hover:underline">Browse all</a>
						</div>
					</div>
					<div class="section-body">
						<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
							@foreach($specialties as $spec)
								<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" target="_blank" rel="noopener noreferrer" class="block rounded-lg bg-white border shadow-sm px-4 py-3 hover:border-brand-600 hover:shadow transition text-gray-800">
									<div class="flex items-center gap-2">
										@include('components.specialty-icon', ['name' => $spec->description, 'class' => 'mr-1'])
										<div class="min-w-0">
											<div class="font-medium text-sm truncate">{{ $spec->description }}</div>
											<div class="text-xs text-gray-500 mt-0.5">{{ $spec->code }}</div>
										</div>
									</div>
								</a>
							@endforeach
						</div>
					</div>
				</section>
			@endif
		</div>
	</div>
@endif


