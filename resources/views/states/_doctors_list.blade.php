@php /** @var \Illuminate\Pagination\LengthAwarePaginator $doctors */ @endphp
@if($doctors->count() === 0)
	<p class="text-gray-600 text-center py-8">No doctors found in {{ $stateName }}.</p>
@else
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
@endif

