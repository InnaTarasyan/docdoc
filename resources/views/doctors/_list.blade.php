@php /** @var \Illuminate\Pagination\LengthAwarePaginator $doctors */ @endphp
@if($doctors->count() === 0)
	<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No doctors found. Try adjusting filters.</div>
@else
	<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
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
								// Heuristic by common feminine endings
								$isFemale = (bool) preg_match('/(a|ia|ya|na|ra|la|ta|sa|ina|eva|ova|iya|aya)$/u', $lower);
							}
							// Fallback parity if still undetermined
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
						<div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-600">
							@if($doctor->gender)
								<span>{{ $doctor->gender === 'M' ? 'Male' : 'Female' }}</span>
							@endif
							<span>{{ $doctor->city }}, {{ $doctor->state }}</span>
						</div>
						@if($doctor->organization_name)
							<div class="text-sm text-gray-700 mt-1 truncate">{{ $doctor->organization_name }}</div>
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


