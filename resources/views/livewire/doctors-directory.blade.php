@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Doctors</span>
@endsection

<div class="grid md:grid-cols-4 gap-6">
	<aside class="md:col-span-1">
		<div class="bg-white rounded-xl border shadow-sm p-4">
			<h2 class="font-medium text-gray-900 mb-3">Filters</h2>
			<div class="grid gap-3">
				<div class="relative">
					<input
						type="text"
						wire:model.live.debounce.300ms="query"
						placeholder="Search doctors (name, specialty, org)"
						class="w-full rounded-lg border-gray-300 focus:border-brand-600 focus:ring-brand-600"
						autocomplete="off"
						x-data
						x-ref="doctorSearch"
						x-on:input.debounce.250ms="
							const term = $el.value.trim();
							if (!term) { document.getElementById('doctor-suggest').classList.add('hidden'); return; }
							fetch('{{ route('api.search.doctors') }}?q=' + encodeURIComponent(term), { headers: { 'Accept': 'application/json' }})
								.then(r => r.json())
								.then(data => {
									const box = document.getElementById('doctor-suggest');
									const list = box.querySelector('[data-list]');
									list.innerHTML = '';
									(data.results || []).forEach(item => {
										const li = document.createElement('button');
										li.type = 'button';
										li.className = 'w-full text-left px-3 py-2 hover:bg-gray-50';
										li.innerHTML = `<div class='font-medium text-gray-900'>${item.text}</div>` + (item.sub ? `<div class='text-xs text-gray-600'>${item.sub}</div>` : '');
										li.addEventListener('click', () => {
											$el.value = item.text;
											$wire.set('query', item.text);
											box.classList.add('hidden');
										});
										list.appendChild(li);
									});
									if ((data.results || []).length > 0) {
										box.classList.remove('hidden');
									} else {
										box.classList.add('hidden');
									}
								})
								.catch(() => {});
						"
						x-on:focus="
							if (document.getElementById('doctor-suggest').querySelector('[data-list]').children.length > 0) {
								document.getElementById('doctor-suggest').classList.remove('hidden');
							}
						"
						x-on:blur="
							setTimeout(() => document.getElementById('doctor-suggest').classList.add('hidden'), 150);
						"
					/>
					<div id="doctor-suggest" class="hidden absolute z-20 mt-1 w-full bg-white border rounded-lg shadow-lg overflow-hidden">
						<div data-list></div>
					</div>
				</div>

				<select wire:model.live="gender" class="w-full rounded-lg border-gray-300 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any gender</option>
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>

				<select wire:model.live="state" class="w-full rounded-lg border-gray-300 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any state</option>
					@foreach($states as $s)
						<option value="{{ $s }}">{{ $s }}</option>
					@endforeach
				</select>

				<select wire:model.live="city" class="w-full rounded-lg border-gray-300 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any city</option>
					@foreach($cities as $c)
						<option value="{{ $c }}">{{ $c }}</option>
					@endforeach
				</select>

				<select wire:model.live="specialty" class="w-full rounded-lg border-gray-300 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any specialty</option>
					@foreach($specialties as $sp)
						<option value="{{ $sp }}">{{ $sp }}</option>
					@endforeach
				</select>

				<button type="button" wire:click="$set('query','');$set('gender','');$set('state','');$set('city','');$set('specialty','')" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Reset</button>
			</div>
		</div>
	</aside>

	<section class="md:col-span-3">
		<div class="flex items-center justify-between mb-3">
			<h1 class="text-xl font-semibold text-gray-900">Doctors</h1>
			<span class="text-sm text-gray-600">Page {{ $doctors->currentPage() }} of {{ $doctors->lastPage() }}</span>
		</div>

		<div wire:loading.flex class="items-center gap-2 text-brand-700 mb-3">
			<svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
				<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
			</svg>
			<span>Loading results…</span>
		</div>

		@if($doctors->count() === 0)
			<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No doctors found. Try adjusting filters.</div>
		@else
			<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
				@foreach($doctors as $doctor)
					<a href="{{ route('doctors.show', $doctor) }}" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-brand-600 hover:shadow transition">
						<div class="font-medium text-gray-900">{{ $doctor->name }}</div>
						<div class="text-sm text-gray-600">{{ $doctor->taxonomy ?: '—' }}</div>
						<div class="text-sm text-gray-600">{{ $doctor->gender ? ($doctor->gender === 'M' ? 'Male' : 'Female') : '' }}</div>
						<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
						@if($doctor->organization_name)
							<div class="text-sm text-gray-700 mt-1">{{ $doctor->organization_name }}</div>
						@endif
					</a>
				@endforeach
			</div>

			<div class="mt-6">
				{{ $doctors->links() }}
			</div>
		@endif
	</section>
</div>




