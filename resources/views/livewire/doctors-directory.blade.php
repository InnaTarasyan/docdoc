@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Doctors</span>
@endsection

<div class="grid md:grid-cols-4 gap-6 sm:gap-8 mt-6 sm:mt-8">
	<aside class="md:col-span-1">
		<div class="relative bg-white sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:rounded-[30px] sm:border sm:border-white/10 sm:p-0 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] sm:overflow-hidden">
			<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/15 opacity-40 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-10 -right-6 w-40 h-40 bg-emerald-400/30 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute -bottom-12 left-0 w-48 h-48 bg-teal-300/30 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 rounded-2xl bg-white border border-gray-100 sm:border-white/20 sm:bg-white/95 p-4 sm:p-6 shadow-sm sm:shadow-2xl">
				<div class="flex items-center justify-between gap-3 mb-4">
					<div>
						<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold sm:text-emerald-100">Refine results</p>
						<h2 class="text-lg font-semibold text-gray-900 sm:text-white">Filters</h2>
					</div>
					<button type="button" wire:click="$set('query','');$set('gender','');$set('state','');$set('city','');$set('specialty','')" class="hidden sm:inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-semibold text-white/90 border border-white/30 bg-white/20 hover:bg-white/30 transition">Reset</button>
				</div>
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

				<select wire:model.live="gender" class="w-full rounded-lg border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any gender</option>
					<option value="M">Male</option>
					<option value="F">Female</option>
				</select>

				<select wire:model.live="state" class="w-full rounded-lg border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any state</option>
					@foreach($states as $s)
						<option value="{{ $s }}">{{ $s }}</option>
					@endforeach
				</select>

				<select wire:model.live="city" class="w-full rounded-lg border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any city</option>
					@foreach($cities as $c)
						<option value="{{ $c }}">{{ $c }}</option>
					@endforeach
				</select>

				<select wire:model.live="specialty" class="w-full rounded-lg border-gray-200/70 bg-white/90 text-gray-800 focus:border-brand-600 focus:ring-brand-600">
					<option value="">Any specialty</option>
					@foreach($specialties as $sp)
						<option value="{{ $sp }}">{{ $sp }}</option>
					@endforeach
				</select>

					<button type="button" wire:click="$set('query','');$set('gender','');$set('state','');$set('city','');$set('specialty','')" class="sm:hidden inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Reset</button>
				</div>
			</div>
		</div>
	</aside>

	<section class="md:col-span-3 relative bg-white sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:rounded-[36px] sm:border sm:border-white/10 sm:p-6 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] sm:overflow-hidden">
		<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/10 opacity-40 pointer-events-none"></div>
		<div class="hidden sm:block absolute -top-16 -left-2 w-64 h-64 bg-emerald-400/30 blur-[140px] rounded-full pointer-events-none"></div>
		<div class="hidden sm:block absolute -bottom-20 right-0 w-72 h-72 bg-teal-300/25 blur-[160px] rounded-full pointer-events-none"></div>

		<div class="relative z-10 flex flex-col gap-4">
			<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
				<div>
					<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold sm:text-emerald-100">Top-rated care</p>
					<h1 class="text-2xl font-semibold text-gray-900 sm:text-white">Doctors</h1>
				</div>
				<span class="text-sm text-gray-600 sm:text-emerald-50/80">Page {{ $doctors->currentPage() }} of {{ $doctors->lastPage() }}</span>
			</div>

			<div wire:loading.flex class="items-center gap-2 text-brand-700 sm:text-emerald-50/90">
				<svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
				</svg>
				<span>Loading results…</span>
			</div>

			<div class="relative rounded-2xl sm:rounded-[30px] border border-gray-100 sm:border-white/15 bg-white/95 p-4 sm:p-6 shadow-sm sm:shadow-2xl overflow-hidden">
				<div class="hidden sm:block absolute -top-8 -right-6 w-36 h-36 bg-emerald-200/40 blur-3xl rounded-full pointer-events-none"></div>
				<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/10 pointer-events-none"></div>

				<div class="relative z-10">
					@if($doctors->count() === 0)
						<div class="rounded-2xl border border-dashed border-gray-200 p-6 text-center text-gray-600">No doctors found. Try adjusting filters.</div>
					@else
						<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
							@foreach($doctors as $doctor)
								<a href="{{ route('doctors.show', $doctor) }}" class="doctor-card block rounded-2xl bg-white/95 border border-gray-100 p-4 shadow-sm hover:border-brand-500 hover:shadow-lg hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40 transition-all duration-300 group relative overflow-hidden">
									<div class="absolute inset-0 bg-gradient-to-br from-brand-50/80 via-transparent to-brand-100/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
									<div class="relative z-10">
										<div class="font-semibold text-gray-900 group-hover:text-brand-800 transition-colors">{{ $doctor->name }}</div>
										<div class="text-sm text-gray-600">{{ $doctor->taxonomy ?: '—' }}</div>
										<div class="text-sm text-gray-600">{{ $doctor->gender ? ($doctor->gender === 'M' ? 'Male' : 'Female') : '' }}</div>
										<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
										@if($doctor->organization_name)
											<div class="text-sm text-gray-700 mt-1">{{ $doctor->organization_name }}</div>
										@endif
									</div>
									<div class="absolute top-3 right-3 text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
										<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
								</a>
							@endforeach
						</div>

						<div class="mt-6">
							{{ $doctors->links() }}
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>
</div>




