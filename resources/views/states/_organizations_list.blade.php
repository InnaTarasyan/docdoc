@php /** @var \Illuminate\Pagination\LengthAwarePaginator $organizations */ @endphp
@if($organizations->count() === 0)
	<p class="text-gray-600 text-center py-8">No organizations found in {{ $stateName }}.</p>
@else
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
@endif

