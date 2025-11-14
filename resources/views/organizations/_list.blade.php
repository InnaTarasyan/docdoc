@php /** @var \Illuminate\Pagination\LengthAwarePaginator $organizations */ @endphp
@if($organizations->count() === 0)
	<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No organizations found. Try adjusting filters.</div>
@else
	<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
		@foreach($organizations as $org)
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
						<div class="text-sm text-gray-600 truncate mt-0.5">{{ $org->city }}, {{ $org->state }}</div>
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
		@endforeach
	</div>

	<div class="mt-6">
		{{ $organizations->links() }}
	</div>
@endif


