@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Organizations</span>
@endsection

<div class="grid md:grid-cols-4 gap-6">
	<aside class="md:col-span-1">
		<div class="bg-white rounded-xl border shadow-sm p-4">
			<h2 class="font-medium text-gray-900 mb-3">Filters</h2>
			<div class="grid gap-3">
				<input type="text" wire:model.live.debounce.400ms="query" placeholder="Organization name" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600" />

				<select wire:model.live="state" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
					<option value="">Any state</option>
					@foreach($states as $s)
						<option value="{{ $s }}">{{ $s }}</option>
					@endforeach
				</select>

				<select wire:model.live="city" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
					<option value="">Any city</option>
					@foreach($cities as $c)
						<option value="{{ $c }}">{{ $c }}</option>
					@endforeach
				</select>

				<select wire:model.live="specialty" class="w-full rounded-lg border-gray-300 focus:border-sky-600 focus:ring-sky-600">
					<option value="">Any specialty</option>
					@foreach($specialties as $sp)
						<option value="{{ $sp }}">{{ $sp }}</option>
					@endforeach
				</select>

				<button type="button" wire:click="$set('query','');$set('state','');$set('city','');$set('specialty','')" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Reset</button>
			</div>
		</div>
	</aside>

	<section class="md:col-span-3">
		<div class="flex items-center justify-between mb-3">
			<h1 class="text-xl font-semibold text-gray-900">Organizations</h1>
			<span class="text-sm text-gray-600">Page {{ $organizations->currentPage() }} of {{ $organizations->lastPage() }}</span>
		</div>

		<div wire:loading.flex class="items-center gap-2 text-sky-700 mb-3">
			<svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
				<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
			</svg>
			<span>Loading results…</span>
		</div>

		@if($organizations->count() === 0)
			<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No organizations found. Try adjusting filters.</div>
		@else
			<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
				@foreach($organizations as $org)
					<a href="{{ route('organizations.show', $org) }}" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
						<div class="font-medium text-gray-900">{{ $org->name }}</div>
						<div class="text-sm text-gray-600">{{ $org->city }}, {{ $org->state }}</div>
						@if($org->phone)
							<div class="text-sm text-gray-700 mt-1">{{ $org->phone }}</div>
						@endif
					</a>
				@endforeach
			</div>

			<div class="mt-6">
				{{ $organizations->links() }}
			</div>
		@endif
	</section>
</div>




