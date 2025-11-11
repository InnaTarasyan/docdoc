@php /** @var \Illuminate\Pagination\LengthAwarePaginator $organizations */ @endphp
@if($organizations->count() === 0)
	<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No organizations found. Try adjusting filters.</div>
@else
	<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
		@foreach($organizations as $org)
			<a href="{{ route('organizations.show', $org) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
				<div class="flex items-start gap-4">
					@php
						$seed = abs(crc32(($org->name ?? '') . '|' . (string) $org->id));
						$imgUrl = "https://loremflickr.com/256/256/hospital?lock={$seed}";
					@endphp
					<img src="{{ $imgUrl }}" alt="{{ $org->name }}" class="w-16 h-16 rounded-lg ring-1 ring-gray-200 object-cover bg-white shrink-0" loading="lazy" width="64" height="64" />
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

	<div class="mt-6">
		{{ $organizations->links() }}
	</div>
@endif


