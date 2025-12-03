@extends('layouts.app')

@section('title', $doctor->name)

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<a href="{{ route('doctors.index') }}" class="hover:underline">Doctors</a>
	<span class="mx-1">/</span>
	<span>{{ $doctor->name }}</span>
@endsection

@section('content')
	<div class="space-y-6 sm:space-y-8">
		{{-- Hero / main profile block --}}
		<section class="relative bg-white sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 rounded-2xl sm:rounded-[32px] border border-gray-100 sm:border-white/10 shadow-sm sm:shadow-[0_25px_60px_rgba(6,95,70,0.35)] overflow-hidden">
			<div class="hidden sm:block absolute inset-0 rounded-[32px] border border-white/15 opacity-40 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-16 -left-4 w-64 h-64 bg-emerald-400/30 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute -bottom-20 right-0 w-72 h-72 bg-teal-300/25 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 p-4 sm:p-8 lg:p-10">
				<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
					<div class="flex items-start gap-4 sm:gap-6">
						<div class="shrink-0">
							<div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl sm:rounded-[26px] bg-gradient-to-br from-brand-500 via-emerald-500 to-teal-400 flex items-center justify-center text-white text-2xl sm:text-3xl font-semibold shadow-lg shadow-emerald-900/30">
								@php
									$initials = collect(explode(' ', $doctor->name))
										->filter()
										->take(2)
										->map(fn($part) => mb_substr($part, 0, 1))
										->implode('');
								@endphp
								{{ $initials }}
							</div>
						</div>

						<div class="space-y-2 sm:space-y-3">
							<div class="flex flex-wrap items-center gap-2 sm:gap-3">
								<h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 sm:text-white">
									{{ $doctor->name }}
								</h1>
								@if($doctor->taxonomy)
									<span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-brand-50 sm:bg-white/15 text-brand-800 sm:text-emerald-50 ring-1 ring-brand-100 sm:ring-white/30">
										{{ $doctor->taxonomy }}
									</span>
								@endif
							</div>

							<div class="flex flex-wrap items-center gap-3 text-xs sm:text-sm">
								@if($doctor->city || $doctor->state)
									<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 sm:bg-emerald-900/40 text-gray-800 sm:text-emerald-50">
										<svg class="w-4 h-4 text-brand-600 sm:text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
											<circle cx="12" cy="9" r="2.5"/>
										</svg>
										<span>{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', '.$doctor->state : '' }}</span>
									</span>
								@endif

								@if($doctor->organization_name)
									<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 sm:bg-emerald-900/40 text-gray-800 sm:text-emerald-50">
										<svg class="w-4 h-4 text-brand-600 sm:text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M4 21V9l8-5 8 5v12H4Z"/>
											<path d="M9 21v-6h6v6"/>
										</svg>
										<span>{{ $doctor->organization_name }}</span>
									</span>
								@endif

								@if($doctor->gender)
									<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 sm:bg-emerald-900/40 text-gray-800 sm:text-emerald-50">
										<svg class="w-4 h-4 text-brand-600 sm:text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<circle cx="12" cy="8" r="3"/>
											<path d="M12 11v9M9 14h6"/>
										</svg>
										<span>{{ $doctor->gender === 'M' ? 'Male' : 'Female' }}</span>
									</span>
								@endif

								@if($doctor->npi)
									<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 sm:bg-emerald-900/40 text-gray-800 sm:text-emerald-50">
										<span class="text-[11px] uppercase tracking-wide font-semibold opacity-70">NPI</span>
										<span class="font-mono text-xs">{{ $doctor->npi }}</span>
									</span>
								@endif
							</div>
						</div>
					</div>

					<div class="w-full lg:w-auto">
						<div class="rounded-2xl sm:rounded-3xl bg-gray-50 sm:bg-white/10 border border-gray-100 sm:border-white/20 px-4 py-3 sm:px-5 sm:py-4 text-sm sm:text-base text-gray-800 sm:text-emerald-50 flex flex-col gap-3 sm:gap-4">
							<div class="flex items-center justify-between gap-4">
								<div>
									<p class="text-xs uppercase tracking-wide text-gray-500 sm:text-emerald-200 font-semibold">Patient rating</p>
									<div class="flex items-center gap-2 mt-1">
										<span class="text-lg sm:text-xl font-semibold">New</span>
										<div class="flex items-center gap-0.5 text-amber-400">
											@for($i = 0; $i < 5; $i++)
												<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
													<path d="m12 3.5 2.47 5 5.53.8-4 3.9.94 5.5L12 16.9 7.06 18.7 8 13.9l-4-3.9 5.53-.8L12 3.5Z"/>
												</svg>
											@endfor
										</div>
									</div>
								</div>
								<div class="hidden sm:flex flex-col items-end text-xs text-emerald-100/80">
									<span>No reviews yet</span>
									<span>Be the first to book</span>
								</div>
							</div>
							<div class="flex flex-col sm:flex-row sm:items-center gap-2">
								<button class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-emerald-900/30 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-400 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900/40">
									<span>Book an appointment</span>
								</button>
								<button class="inline-flex items-center justify-center px-3.5 py-2 rounded-full text-xs sm:text-sm font-semibold text-brand-700 sm:text-emerald-50 bg-white sm:bg-transparent border border-brand-100 sm:border-white/40 hover:bg-brand-50 sm:hover:bg-white/10 transition">
									<span>Ask a question</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="grid lg:grid-cols-3 gap-6">
			<section class="lg:col-span-2 space-y-6">
				<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">
					<h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">About the doctor</h2>
					<p class="text-sm sm:text-base leading-relaxed text-gray-700">
						This profile is based on publicly available registry data. We verify licensing, specialty information, and practice location to help you quickly understand
						{{ $doctor->name }}’s professional background.
					</p>
					<div class="mt-4 grid sm:grid-cols-2 gap-4 text-sm">
						<div class="rounded-xl border border-gray-100 p-3.5 sm:p-4">
							<h3 class="text-sm font-medium text-gray-900 mb-1.5">Primary specialty</h3>
							<p class="text-gray-700">{{ $doctor->taxonomy ?: 'Not specified' }}</p>
						</div>
						<div class="rounded-xl border border-gray-100 p-3.5 sm:p-4">
							<h3 class="text-sm font-medium text-gray-900 mb-1.5">Patient focus</h3>
							<p class="text-gray-700">
								We surface doctors who are active in their specialty and accepting patients in their region.
							</p>
						</div>
					</div>
				</div>

				<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">
					<h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Location & organization</h2>
					<div class="grid sm:grid-cols-2 gap-4 text-sm">
						<div class="space-y-2">
							<h3 class="text-sm font-medium text-gray-900">Practice location</h3>
							<p class="text-gray-700">
								@if($doctor->city || $doctor->state)
									{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', '.$doctor->state : '' }}
								@else
									Location details not available.
								@endif
							</p>
							@if($doctor->city || $doctor->state)
								<p class="text-xs text-gray-500">
									Exact office address is not shown for privacy. Use this city and state when searching for appointments.
								</p>
							@endif
						</div>
						<div class="space-y-2">
							<h3 class="text-sm font-medium text-gray-900">Organization</h3>
							<p class="text-gray-700">
								{{ $doctor->organization_name ?: 'No organization specified in registry data.' }}
							</p>
						</div>
					</div>
				</div>

				@if($related->count() > 0)
					<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">
						<div class="flex items-center justify-between gap-2 mb-3 sm:mb-4">
							<h2 class="text-base sm:text-lg font-semibold text-gray-900">Similar doctors nearby</h2>
							<span class="text-xs text-gray-500">Based on city and specialty</span>
						</div>
						<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
							@foreach($related as $d)
								<a href="{{ route('doctors.show', $d) }}" class="group rounded-xl border border-gray-100 bg-white p-4 shadow-sm hover:border-brand-500 hover:shadow-md transition overflow-hidden">
									<div class="flex flex-col gap-1.5">
										<div class="flex items-center justify-between gap-2">
											<div class="font-medium text-gray-900 group-hover:text-brand-700 line-clamp-2">
												{{ $d->name }}
											</div>
										</div>
										<div class="text-xs text-gray-600 line-clamp-2">
											{{ $d->taxonomy ?: 'Specialty not specified' }}
										</div>
										@if($d->city || $d->state)
											<div class="mt-1 text-xs font-medium text-gray-700 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
													<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
													<circle cx="12" cy="9" r="2.5"/>
												</svg>
												<span>{{ $d->city ?: '—' }}{{ $d->state ? ', '.$d->state : '' }}</span>
											</div>
										@endif
									</div>
								</a>
							@endforeach
						</div>
					</div>
				@endif
			</section>

			<aside class="lg:col-span-1">
				<div class="lg:sticky lg:top-24 space-y-4">
					<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
						<h2 class="text-sm sm:text-base font-semibold text-gray-900 mb-3">Quick facts</h2>
						<dl class="space-y-2 text-sm">
							<div class="flex items-start justify-between gap-3">
								<div>
									<dt class="font-medium text-gray-700">Specialty</dt>
									<dd class="text-gray-900">{{ $doctor->taxonomy ?: 'Not specified' }}</dd>
								</div>
							</div>
							<div class="flex items-start justify-between gap-3">
								<div>
									<dt class="font-medium text-gray-700">Location</dt>
									<dd class="text-gray-900">
										@if($doctor->city || $doctor->state)
											{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', '.$doctor->state : '' }}
										@else
											Not available
										@endif
									</dd>
								</div>
							</div>
							@if($doctor->organization_name)
								<div class="flex items-start justify-between gap-3">
									<div>
										<dt class="font-medium text-gray-700">Organization</dt>
										<dd class="text-gray-900">{{ $doctor->organization_name }}</dd>
									</div>
								</div>
							@endif
							@if($doctor->npi)
								<div class="flex items-start justify-between gap-3">
									<div>
										<dt class="font-medium text-gray-700">NPI number</dt>
										<dd class="text-gray-900 font-mono text-xs break-all">{{ $doctor->npi }}</dd>
									</div>
								</div>
							@endif
						</dl>
					</div>

					<div class="bg-gradient-to-br from-brand-600 via-emerald-600 to-teal-500 rounded-2xl shadow-lg text-white p-4 sm:p-5">
						<h3 class="text-sm sm:text-base font-semibold mb-2">Need help choosing a doctor?</h3>
						<p class="text-xs sm:text-sm text-emerald-50/90 mb-3">
							Use search filters or browse similar doctors to find the right specialist for your needs.
						</p>
						<a href="{{ route('doctors.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-full bg-white text-sm font-semibold text-brand-800 hover:bg-brand-50 transition">
							<span>Back to search</span>
						</a>
					</div>
				</div>
			</aside>
		</div>
	</div>
@endsection


