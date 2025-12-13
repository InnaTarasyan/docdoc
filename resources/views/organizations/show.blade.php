@extends('layouts.app')

@section('title', $organization->name)

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<a href="{{ route('organizations.index') }}" class="hover:underline">Organizations</a>
	<span class="mx-1">/</span>
	<span>{{ $organization->name }}</span>
@endsection

@section('content')
	@php
		$initials = collect(explode(' ', $organization->name))
			->filter()
			->take(3)
			->map(fn($part) => mb_substr($part, 0, 1))
			->implode('');
		$phoneDigits = $organization->phone ? preg_replace('/\D+/', '', $organization->phone) : null;
		$specialties = $linkedDoctors->pluck('taxonomy')->filter()->unique()->take(12);
	@endphp

	<div
		class="space-y-6 lg:space-y-8"
		x-data="{
			showBookModal: false,
			showQuestionModal: false,
			toastVisible: false,
			toastMessage: '',
			bookForm: {
				name: '',
				email: ''
			},
			questionForm: {
				email: '',
				question: ''
			},
			get isBookFormValid() {
				return this.bookForm.name.trim() !== '' && this.bookForm.email.trim() !== '' && this.bookForm.email.includes('@');
			},
			get isQuestionFormValid() {
				return this.questionForm.email.trim() !== '' && this.questionForm.email.includes('@') && this.questionForm.question.trim() !== '';
			},
			openBook() {
				this.showQuestionModal = false;
				this.showBookModal = true;
				this.bookForm = { name: '', email: '' };
			},
			openQuestion() {
				this.showBookModal = false;
				this.showQuestionModal = true;
				this.questionForm = { email: '', question: '' };
			},
			closeModals() {
				this.showBookModal = false;
				this.showQuestionModal = false;
			},
			showToast(message) {
				this.toastMessage = message;
				this.toastVisible = true;
				setTimeout(() => {
					this.toastVisible = false;
				}, 4000);
			}
		}"
		x-cloak
	>
		<div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 border border-white/10 shadow-[0_25px_70px_rgba(6,95,70,0.35)]">
			<div class="pointer-events-none absolute inset-0">
				<div class="absolute inset-0 rounded-3xl border border-white/15 opacity-40"></div>
				<div class="absolute -top-10 -left-8 h-48 w-48 rounded-full bg-emerald-400/30 blur-[120px]"></div>
				<div class="absolute -bottom-14 right-4 h-60 w-60 rounded-full bg-teal-300/25 blur-[150px]"></div>
				<div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/10 to-transparent"></div>
			</div>

			<div class="relative z-10 p-5 sm:p-7 lg:p-10">
				<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
					<div class="flex gap-4 sm:gap-6">
						<div class="shrink-0">
							<div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-400 text-2xl font-semibold text-white shadow-lg shadow-emerald-900/30 sm:h-24 sm:w-24 sm:rounded-3xl sm:text-3xl">
								{{ $initials }}
							</div>
						</div>
						<div class="space-y-3 text-white">
							<div class="flex flex-wrap items-center gap-2">
								<h1 class="text-2xl font-semibold leading-tight sm:text-3xl lg:text-4xl">
									{{ $organization->name }}
								</h1>
								<span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-medium uppercase tracking-wide text-white ring-1 ring-white/30">
									Healthcare organization
								</span>
							</div>
							<div class="flex flex-wrap items-center gap-2 text-sm text-emerald-50">
								@if($organization->city || $organization->state)
									<span class="inline-flex items-center gap-2 rounded-full bg-black/10 px-3 py-1">
										<svg class="h-4 w-4 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
											<circle cx="12" cy="9" r="2.5"/>
										</svg>
										<span>{{ $organization->city ?: '—' }}{{ $organization->state ? ', '.$organization->state : '' }}</span>
									</span>
								@endif
								@if($organization->phone)
									<span class="inline-flex items-center gap-2 rounded-full bg-black/10 px-3 py-1">
										<svg class="h-4 w-4 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.5 1.22l-2.26 1.13a11.05 11.05 0 0 0 5.52 5.52l1.13-2.26a1 1 0 0 1 1.22-.5l4.5 1.5a1 1 0 0 1 .68.95V19a2 2 0 0 1-2 2h-1C9.72 21 3 14.28 3 6V5Z" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										@if($phoneDigits)
											<a href="tel:{{ $phoneDigits }}" class="hover:underline">{{ $organization->phone }}</a>
										@else
											<span>{{ $organization->phone }}</span>
										@endif
									</span>
								@endif
							</div>

							<div class="grid gap-3 sm:grid-cols-2">
								<div class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
									<div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/30 ring-1 ring-white/20">
										<svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
									<div>
										<p class="text-xs uppercase tracking-wide text-emerald-100/80">Patient focus</p>
										<p class="text-sm font-semibold text-white">Responsive care coordination</p>
									</div>
								</div>
								<div class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/20 backdrop-blur">
									<div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/30 ring-1 ring-white/20">
										<svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 1v4m0 14v4m7-8h4M1 12h4m2.93 5.07-2.83 2.83m12.72-12.72 2.83-2.83m0 15.56-2.83-2.83M3.1 5.1l2.83 2.83" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
									<div>
										<p class="text-xs uppercase tracking-wide text-emerald-100/80">For busy people</p>
										<p class="text-sm font-semibold text-white">Same-week appointment targets</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="w-full lg:w-96">
						<div class="rounded-2xl bg-white/10 px-5 py-4 text-white shadow-lg ring-1 ring-white/15 backdrop-blur">
							<div class="flex items-center justify-between gap-3">
								<div>
									<p class="text-xs uppercase tracking-wide text-emerald-100/80 font-semibold">Plan your visit</p>
									<p class="mt-1 text-sm font-medium text-white/90">Pick a slot or ask a question</p>
								</div>
								<a
									href="{{ route('organizations.index') }}"
									class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-emerald-50 ring-1 ring-white/20 hover:bg-white/20"
								>
									<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<span>Back</span>
								</a>
							</div>
							<div class="mt-3 flex flex-col gap-2.5 sm:flex-row sm:items-center">
								<button
									type="button"
									@click="openBook()"
									class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-black shadow-md shadow-emerald-900/20 transition hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-800"
								>
									<svg class="mr-2 h-4 w-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 5v14m-7-7h14" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									Book a visit
								</button>
								<button
									type="button"
									@click="openQuestion()"
									class="inline-flex items-center justify-center rounded-full border border-white/40 px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-white/10"
								>
									<svg class="mr-1.5 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M12 18h.01M8 9a4 4 0 0 1 7.06-2.53A3.5 3.5 0 0 1 14 13.5h-1v1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7L5 7v12a2 2 0 0 0 2 2Z" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									Ask a question
								</button>
							</div>
							<p class="mt-2 text-[11px] text-emerald-100/80">
								Response typically within one business day. We'll use your contact details to confirm.
							</p>
						</div>
					</div>

					<div class="w-full lg:w-auto">
						<div
							class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg ring-1 ring-white/15 backdrop-blur"
							x-data="{
								galleryIndex: 0,
							images: [
									'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=900&q=80',
									'https://images.unsplash.com/photo-1550831107-1553da8c8464?auto=format&fit=crop&w=900&q=80',
									'https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?auto=format&fit=crop&w=900&q=80',
									'https://images.unsplash.com/photo-1504439468489-c8920d796a29?auto=format&fit=crop&w=900&q=80'
								],
								next() { this.galleryIndex = (this.galleryIndex + 1) % this.images.length },
								prev() { this.galleryIndex = (this.galleryIndex - 1 + this.images.length) % this.images.length }
							}"
						>
							<div class="flex items-center justify-between gap-2 mb-3">
								<div>
									<h3 class="text-sm font-semibold text-white">Clinic gallery</h3>
									<p class="text-xs text-emerald-100/80">Swipe through the space</p>
								</div>
								<div class="hidden sm:flex items-center gap-1.5">
									<button type="button" class="rounded-full p-1.5 ring-1 ring-white/30 hover:bg-white/10 text-white" @click="prev()">
										<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m15 6-6 6 6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
									<button type="button" class="rounded-full p-1.5 ring-1 ring-white/30 hover:bg-white/10 text-white" @click="next()">
										<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
								</div>
							</div>

							<div class="relative overflow-hidden rounded-xl aspect-[4/3] bg-gray-100/20 ring-1 ring-white/20">
								<template x-for="(image, idx) in images" :key="image">
									<img
										x-show="galleryIndex === idx"
										x-transition.opacity
										:src="image"
										alt="Clinic photo"
										class="absolute inset-0 h-full w-full object-cover"
										loading="lazy"
									>
								</template>
								<div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex items-center gap-1.5">
									<template x-for="(image, idx) in images" :key="idx">
										<button
											type="button"
											class="h-2 w-2 rounded-full"
											:class="galleryIndex === idx ? 'bg-white ring-1 ring-white/50' : 'bg-white/40'"
											@click="galleryIndex = idx"
										></button>
									</template>
								</div>
								<div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
									<button type="button" class="m-2 rounded-full bg-white/80 p-1.5 shadow" @click="prev()">
										<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m15 6-6 6 6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
								</div>
								<div class="absolute inset-y-0 right-0 flex items-center sm:hidden">
									<button type="button" class="m-2 rounded-full bg-white/80 p-1.5 shadow" @click="next()">
										<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="grid gap-6 lg:grid-cols-3">
			<section class="space-y-6 lg:col-span-2">
				<div class="grid gap-4 sm:grid-cols-2">
					<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
						<div class="flex items-start justify-between gap-3">
							<div>
								<h2 class="text-lg font-semibold text-gray-900">Location</h2>
								<p class="mt-1 text-sm text-gray-600">
									{{ $organization->city ?: '—' }}{{ $organization->state ? ', '.$organization->state : '' }}
								</p>
							</div>
							<div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 text-brand-700 ring-1 ring-brand-100">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
									<circle cx="12" cy="9" r="2.5"/>
								</svg>
							</div>
						</div>
						@if($organization->city || $organization->state)
							<p class="mt-3 text-xs text-gray-500">
								Exact address is not provided in the registry data. Use the city and state when planning your visit or call ahead for directions.
							</p>
						@else
							<p class="mt-3 text-xs text-gray-500">Location will appear when the organization adds full address data.</p>
						@endif
					</div>

					<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
						<div class="flex items-start justify-between gap-3">
							<div>
								<h2 class="text-lg font-semibold text-gray-900">Contact</h2>
								<p class="mt-1 text-sm text-gray-700">
									{{ $organization->phone ?: 'Phone not listed in registry data.' }}
								</p>
							</div>
							<div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 text-brand-700 ring-1 ring-brand-100">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.5 1.22l-2.26 1.13a11.05 11.05 0 0 0 5.52 5.52l1.13-2.26a1 1 0 0 1 1.22-.5l4.5 1.5a1 1 0 0 1 .68.95V19a2 2 0 0 1-2 2h-1C9.72 21 3 14.28 3 6V5Z" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
						</div>
						<p class="mt-3 text-xs text-gray-500">Add your number to booking to confirm appointments and receive reminders.</p>
					</div>
				</div>

				<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
					<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
						<div>
							<h2 class="text-lg font-semibold text-gray-900">At a glance</h2>
							<p class="text-sm text-gray-600">Snapshot of availability and focus areas.</p>
						</div>
						<div class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-sm font-semibold text-brand-700 ring-1 ring-brand-100">
							<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span>Patient-first workflows</span>
						</div>
					</div>

					<div class="mt-4 grid gap-3 sm:grid-cols-2">
						<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
							<div class="mt-1 flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-700 ring-1 ring-brand-100">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M8 7v10M16 7v10M4 11h16M4 15h16" stroke-linecap="round"/>
								</svg>
							</div>
							<div>
								<p class="text-sm font-semibold text-gray-900">Visit planning</p>
								<p class="text-xs text-gray-600">Schedule requests, follow-up reminders, and prep guidance are part of booking.</p>
							</div>
						</div>
						<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
							<div class="mt-1 flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-700 ring-1 ring-brand-100">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M12 6v6l4 2" stroke-linecap="round" stroke-linejoin="round"/>
									<circle cx="12" cy="12" r="9"/>
								</svg>
							</div>
							<div>
								<p class="text-sm font-semibold text-gray-900">Quick response window</p>
								<p class="text-xs text-gray-600">We aim to respond within a business day after your request.</p>
							</div>
						</div>
						<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
							<div class="mt-1 flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-700 ring-1 ring-brand-100">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M4 7h16M4 12h10m-10 5h16" stroke-linecap="round"/>
								</svg>
							</div>
							<div>
								<p class="text-sm font-semibold text-gray-900">Care coordination</p>
								<p class="text-xs text-gray-600">One place to align doctors, tests, and follow-up visits.</p>
							</div>
						</div>
						<div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
							<div class="mt-1 flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-700 ring-1 ring-brand-100">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<circle cx="12" cy="12" r="9"/>
									<path d="M8 12c0-2 1.5-4 4-4s4 2 4 4-1.5 4-4 4-4-2-4-4Z" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div>
								<p class="text-sm font-semibold text-gray-900">Comfort-first spaces</p>
								<p class="text-xs text-gray-600">Modern reception, calm waiting areas, and mobile-friendly check-in.</p>
							</div>
						</div>
					</div>
				</div>

				<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
					<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
						<div>
							<h2 class="text-lg font-semibold text-gray-900">Services & specialties</h2>
							<p class="text-sm text-gray-600">Explore what the clinic is known for.</p>
						</div>
						@if($linkedDoctors->count() > 0)
							<span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-700 ring-1 ring-brand-100">
								<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M12 6v6l4 2" stroke-linecap="round" stroke-linejoin="round"/>
									<circle cx="12" cy="12" r="9"/>
								</svg>
								{{ $linkedDoctors->count() }} doctors linked
							</span>
						@endif
					</div>
					@if($specialties->isNotEmpty())
						<div class="mt-4 flex flex-wrap gap-2">
							@foreach($specialties as $specialty)
								<span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800 ring-1 ring-gray-200">
									<svg class="h-4 w-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									{{ $specialty }}
								</span>
							@endforeach
						</div>
					@else
						<p class="mt-3 text-sm text-gray-600">Specialties will appear as soon as providers publish them.</p>
					@endif
				</div>

				@if($linkedDoctors->count() > 0)
					<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
						<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
							<h2 class="text-lg font-semibold text-gray-900">Doctors at this organization</h2>
							<a
								href="{{ route('organizations.index') }}"
								class="inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800"
							>
								<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<span>Browse other clinics</span>
							</a>
						</div>
						<div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
							@foreach($linkedDoctors as $doctor)
								<a href="{{ route('doctors.show', $doctor) }}" class="group relative block rounded-xl border border-gray-100 bg-gradient-to-b from-white to-gray-50 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-600 hover:shadow-md">
									<div class="flex items-start justify-between gap-3">
										<div class="space-y-1.5">
											<div class="text-base font-semibold text-gray-900 group-hover:text-brand-700 line-clamp-2">
												{{ $doctor->name }}
											</div>
											<div class="text-sm text-gray-600 line-clamp-2">
												{{ $doctor->taxonomy ?: 'Specialty not specified' }}
											</div>
											@if($doctor->city || $doctor->state)
												<div class="text-xs font-medium text-gray-700 flex items-center gap-1.5">
													<svg class="h-3.5 w-3.5 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
														<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
														<circle cx="12" cy="9" r="2.5"/>
													</svg>
													<span>{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', '.$doctor->state : '' }}</span>
												</div>
											@endif
										</div>
										<div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700 ring-1 ring-brand-100">
											<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
									</div>
									<div class="mt-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-brand-700">
										<span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-2.5 py-1 ring-1 ring-brand-100">
											View profile
											<svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</span>
									</div>
								</a>
							@endforeach
						</div>
					</div>
				@endif

				<div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6 space-y-4">
					<div id="organization-reviews-list">
						@include('organizations._reviews_list', ['organization' => $organization])
					</div>

					@if(session('status'))
						<div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-2 text-sm text-emerald-800 mb-2">
							{{ session('status') }}
						</div>
					@endif

					<div
						data-review-success
						class="hidden rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-2 text-sm text-emerald-800"
					></div>

					<div
						data-review-errors
						class="hidden rounded-xl bg-red-50 border border-red-200 px-4 py-2 text-sm text-red-800"
					></div>

					<form
						action="{{ route('organizations.reviews.store', $organization) }}"
						method="post"
						class="space-y-3"
						data-ajax-review="true"
					>
						@csrf
						<div class="grid sm:grid-cols-2 gap-3">
							<label class="block text-sm font-medium text-gray-700">
								<span>Your name</span>
								<input
									type="text"
									name="name"
									value="{{ old('name') }}"
									class="mt-1 input h-10"
									placeholder="Jane Doe"
									required
								>
								@error('name')
									<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</label>
							<label class="block text-sm font-medium text-gray-700">
								<span>Rating</span>
								<select
									name="rating"
									class="mt-1 select h-10"
									required
								>
									<option value="">Choose</option>
									@for($i = 5; $i >= 1; $i--)
										<option value="{{ $i }}" @selected((int) old('rating') === $i)>{{ $i }} / 5</option>
									@endfor
								</select>
								@error('rating')
									<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</label>
						</div>
						<label class="block text-sm font-medium text-gray-700">
							<span>Your review</span>
							<textarea
								name="comment"
								class="mt-1 input min-h-[80px] resize-y"
								placeholder="Share what went well, and what could be improved."
							>{{ old('comment') }}</textarea>
							@error('comment')
								<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
							@enderror
						</label>
						<div class="flex flex-col sm:flex-row sm:items-center gap-3">
							<button type="submit" class="btn-primary w-full sm:w-auto justify-center">
								Submit review
							</button>
							<p class="text-[11px] sm:text-xs text-gray-500">
								Reviews help other patients understand what to expect from this clinic.
							</p>
						</div>
					</form>
				</div>
			</section>

			<aside class="lg:col-span-1">
				<div class="lg:sticky lg:top-24 space-y-4">
					<div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
						<h2 class="text-base font-semibold text-gray-900">Quick info</h2>
						<dl class="mt-3 space-y-2 text-sm text-gray-800">
							<div class="flex items-center justify-between gap-3 rounded-lg bg-gray-50 px-3 py-2">
								<dt class="font-medium text-gray-700">City / State</dt>
								<dd class="text-right">{{ $organization->city ?: '—' }} {{ $organization->state ? ", $organization->state" : '' }}</dd>
							</div>
							<div class="flex items-center justify-between gap-3 rounded-lg bg-gray-50 px-3 py-2">
								<dt class="font-medium text-gray-700">Phone</dt>
								<dd class="text-right">{{ $organization->phone ?: '—' }}</dd>
							</div>
							@if($linkedDoctors->count() > 0)
								<div class="flex items-center justify-between gap-3 rounded-lg bg-gray-50 px-3 py-2">
									<dt class="font-medium text-gray-700">Doctors listed</dt>
									<dd class="text-right">{{ $linkedDoctors->count() }}</dd>
								</div>
							@endif
						</dl>
					</div>

					<div class="overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-emerald-600 to-teal-500 p-5 text-white shadow-lg">
						<div class="flex items-start gap-3">
							<div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15 ring-1 ring-white/25">
								<svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M4 7h16M4 12h10m-10 5h16" stroke-linecap="round"/>
								</svg>
							</div>
							<div class="space-y-2">
								<h3 class="text-lg font-semibold">Need another clinic?</h3>
								<p class="text-sm text-emerald-50/90">Compare clinics, hospitals, and diagnostic centers nearby.</p>
								<a
									href="{{ route('organizations.index') }}"
									class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-black shadow-md shadow-emerald-900/20 transition hover:bg-brand-50"
								>
									<svg class="mr-1.5 h-4 w-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
									<span class="text-black">Back to search</span>
								</a>
							</div>
						</div>
					</div>

					<div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
						<h3 class="text-base font-semibold text-gray-900">Good to know</h3>
						<ul class="mt-3 space-y-2 text-sm text-gray-700">
							<li class="flex items-start gap-2">
								<svg class="mt-1 h-4 w-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<span>Mobile-friendly booking keeps the experience clean on small screens.</span>
							</li>
							<li class="flex items-start gap-2">
								<svg class="mt-1 h-4 w-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<span>Clinic will follow up using the contact details you share.</span>
							</li>
							<li class="flex items-start gap-2">
								<svg class="mt-1 h-4 w-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<span>See specialties and doctors to understand focus areas before booking.</span>
							</li>
						</ul>
					</div>
				</div>
			</aside>
		</div>

		<div class="grid gap-4 sm:gap-6 lg:grid-cols-3">
			<div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm space-y-3">
				<div class="flex items-center gap-2">
					<div class="h-9 w-9 flex items-center justify-center rounded-lg bg-brand-50 text-brand-700 ring-1 ring-brand-100">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<div>
						<p class="text-xs uppercase tracking-wide text-gray-500">Fast responses</p>
						<p class="text-sm font-semibold text-gray-900">Replies usually within 1 business day</p>
					</div>
				</div>
				<div class="flex items-center justify-between text-xs text-gray-600">
					<span>Bookings confirmed last week</span>
					<span class="font-semibold text-brand-700">+18</span>
				</div>
				<div class="h-2 rounded-full bg-gray-100 overflow-hidden">
					<div class="h-full w-3/5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>
				</div>
			</div>
			<div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm space-y-3">
				<div class="flex items-center gap-2">
					<div class="h-9 w-9 flex items-center justify-center rounded-lg bg-amber-50 text-amber-700 ring-1 ring-amber-100">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="12" cy="12" r="9"/>
							<path d="M12 7v5l3 2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
					<div>
						<p class="text-xs uppercase tracking-wide text-gray-500">Flexible slots</p>
						<p class="text-sm font-semibold text-gray-900">Same-week appointments available</p>
					</div>
				</div>
				<div class="flex items-center justify-between text-xs text-gray-600">
					<span>Average wait</span>
					<span class="font-semibold text-amber-700">2-4 days</span>
				</div>
				<div class="h-2 rounded-full bg-gray-100 overflow-hidden">
					<div class="h-full w-2/3 rounded-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
				</div>
			</div>
			<div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm space-y-3">
				<div class="flex items-center gap-2">
					<div class="h-9 w-9 flex items-center justify-center rounded-lg bg-blue-50 text-blue-700 ring-1 ring-blue-100">
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M4 7h16M4 12h10m-10 5h16" stroke-linecap="round"/>
						</svg>
					</div>
					<div>
						<p class="text-xs uppercase tracking-wide text-gray-500">Patients stay</p>
						<p class="text-sm font-semibold text-gray-900">92% return for follow-ups</p>
					</div>
				</div>
				<div class="flex items-center justify-between text-xs text-gray-600">
					<span>Mobile booking success</span>
					<span class="font-semibold text-blue-700">Stable</span>
				</div>
				<div class="h-2 rounded-full bg-gray-100 overflow-hidden">
					<div class="h-full w-4/5 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500"></div>
				</div>
			</div>
		</div>

		@if($nearbyDoctors->count() > 0)
			<div class="mt-6 sm:mt-8 rounded-3xl border border-gray-100 bg-white p-4 sm:p-6 shadow-sm">
				<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
					<div>
						<h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
							<svg class="w-6 h-6 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
								<circle cx="12" cy="9" r="2.5"/>
							</svg>
							<span>Nearby doctors</span>
						</h2>
						<p class="text-sm text-gray-600 mt-1">Doctors with addresses near {{ $organization->name }} in {{ $organization->city ?: ($organization->state ?: 'the area') }}.</p>
					</div>
					<a href="{{ route('doctors.index', ['city' => $organization->city, 'state' => $organization->state]) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-800 px-3 py-1.5 rounded-lg hover:bg-brand-50 transition">
						<span>View all doctors</span>
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
					@foreach($nearbyDoctors as $doctor)
						<a href="{{ route('doctors.show', $doctor) }}" class="group relative block rounded-xl border border-gray-100 bg-gradient-to-b from-white to-gray-50 p-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-brand-500 hover:shadow-lg">
							<div class="flex items-start justify-between gap-3">
								<div class="flex-1 space-y-2">
									<div class="flex items-start gap-2">
										<div class="flex-1">
											<div class="text-base font-semibold text-gray-900 group-hover:text-brand-700 line-clamp-2 transition-colors">
												{{ $doctor->name }}
											</div>
											@if($doctor->taxonomy)
												<div class="text-sm text-gray-600 mt-1 line-clamp-1">
													{{ $doctor->taxonomy }}
												</div>
											@endif
										</div>
									</div>
									@if($doctor->city || $doctor->state)
										<div class="flex items-center gap-1.5 text-xs font-medium text-gray-700">
											<svg class="h-3.5 w-3.5 text-brand-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
												<circle cx="12" cy="9" r="2.5"/>
											</svg>
											<span class="line-clamp-1">{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', '.$doctor->state : '' }}</span>
										</div>
									@endif
									@if($doctor->organization_name)
										<div class="flex items-center gap-1.5 text-xs text-gray-500">
											<svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M4 21V9l8-5 8 5v12H4Z"/>
												<path d="M9 21v-6h6v6"/>
											</svg>
											<span class="line-clamp-1">{{ $doctor->organization_name }}</span>
										</div>
									@endif
								</div>
								<div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700 ring-1 ring-brand-100 group-hover:bg-brand-100 group-hover:ring-brand-200 transition-colors">
									<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
							</div>
							<div class="mt-3 pt-3 border-t border-gray-100">
								<span class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-700 group-hover:text-brand-800">
									<span>View profile</span>
									<svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
							</div>
						</a>
					@endforeach
				</div>
			</div>
		@endif

		@if($nearbyClinics->count() > 0)
			<div class="mt-6 sm:mt-8 rounded-3xl border border-gray-100 bg-white p-4 sm:p-6 shadow-sm">
				<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
					<div>
						<h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
							<svg class="w-6 h-6 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M4 21V9l8-5 8 5v12H4Z"/>
								<path d="M9 21v-6h6v6"/>
							</svg>
							<span>Nearby clinics</span>
						</h2>
						<p class="text-sm text-gray-600 mt-1">Other healthcare facilities in {{ $organization->city ?: ($organization->state ?: 'the area') }} you may want to compare.</p>
					</div>
					<a href="{{ route('organizations.index', ['city' => $organization->city, 'state' => $organization->state]) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 hover:text-brand-800 px-3 py-1.5 rounded-lg hover:bg-brand-50 transition">
						<span>View all clinics</span>
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
					@foreach($nearbyClinics as $clinic)
						@php
							$seed = abs(crc32(($clinic->name ?? '') . '|' . (string) $clinic->id));
							$hospitalImages = [
								'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=256&h=256&q=80',
								'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=256&h=256&q=80',
								'https://images.unsplash.com/photo-1550831107-1553da8c8464?auto=format&fit=crop&w=256&h=256&q=80',
								'https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?auto=format&fit=crop&w=256&h=256&q=80',
								'https://images.unsplash.com/photo-1504439468489-c8920d796a29?auto=format&fit=crop&w=256&h=256&q=80',
								'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=256&h=256&q=80',
								'https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?auto=format&fit=crop&w=256&h=256&q=80'
							];
							$imgUrl = $hospitalImages[$seed % count($hospitalImages)];
						@endphp
						<a href="{{ route('organizations.show', $clinic) }}" class="group relative block overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-brand-500 hover:shadow-lg">
							<div class="relative">
								<div class="aspect-[4/3] overflow-hidden bg-gray-100">
									<img src="{{ $imgUrl }}" alt="{{ $clinic->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
									<div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
								</div>
								<div class="absolute top-3 right-3">
									<div class="bg-white/90 backdrop-blur-sm rounded-full p-2 shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
										<svg class="w-4 h-4 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
								</div>
							</div>
							<div class="p-4">
								<div class="flex items-start justify-between gap-2 mb-2">
									<h3 class="font-semibold text-gray-900 group-hover:text-brand-700 transition-colors line-clamp-2 flex-1">
										{{ $clinic->name }}
									</h3>
								</div>
								<div class="space-y-2">
									@if($clinic->city || $clinic->state)
										<div class="flex items-center gap-1.5 text-sm text-gray-600">
											<svg class="h-4 w-4 text-brand-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
												<circle cx="12" cy="9" r="2.5"/>
											</svg>
											<span class="line-clamp-1">{{ $clinic->city ?: '—' }}{{ $clinic->state ? ', '.$clinic->state : '' }}</span>
										</div>
									@endif
									@if($clinic->phone)
										<div class="flex items-center gap-1.5 text-sm text-gray-600">
											<svg class="h-4 w-4 text-brand-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											<span class="line-clamp-1">{{ $clinic->phone }}</span>
										</div>
									@endif
								</div>
								<div class="mt-3 pt-3 border-t border-gray-100">
									<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">
										<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="m5 12 5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										<span>Open for booking</span>
									</span>
								</div>
							</div>
						</a>
					@endforeach
				</div>
			</div>
		@endif


		<div class="fixed inset-x-4 bottom-4 z-30 sm:hidden">
			<div class="flex items-center gap-2 rounded-2xl bg-white/95 px-3 py-2 shadow-lg ring-1 ring-gray-200 backdrop-blur">
				<button
					type="button"
					@click="openBook()"
					class="flex-1 inline-flex items-center justify-center rounded-xl bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-md shadow-emerald-900/20"
				>
					<svg class="mr-1.5 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M12 5v14m-7-7h14" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					Book
				</button>
				<button
					type="button"
					@click="openQuestion()"
					class="inline-flex items-center justify-center rounded-xl px-3 py-2 text-sm font-semibold text-brand-700 ring-1 ring-brand-200"
				>
					<svg class="mr-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M12 18h.01M8 9a4 4 0 0 1 7.06-2.53A3.5 3.5 0 0 1 14 13.5h-1v1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7L5 7v12a2 2 0 0 0 2 2Z" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					Ask
				</button>
			</div>
		</div>

		{{-- Book visit modal --}}
		<div
			x-show="showBookModal"
			x-transition.opacity
			class="fixed inset-0 z-40 flex items-end sm:items-center justify-center bg-black/40 px-4 py-4 sm:py-6"
			aria-modal="true"
			role="dialog"
		>
			<div
				x-show="showBookModal"
				x-transition
				@click.outside="showBookModal = false"
				class="w-full max-w-lg rounded-3xl bg-white shadow-2xl border border-gray-100 p-5 sm:p-6 md:p-7"
			>
				<div class="flex items-start justify-between gap-3">
					<div>
						<h2 class="mt-1 text-lg sm:text-xl font-semibold text-gray-900">Book a visit at {{ $organization->name }}</h2>
						<p class="mt-1 text-xs sm:text-sm text-gray-500">
							Share when you’d like to come in and how the clinic can reach you to confirm your visit.
						</p>
					</div>
					<button
						type="button"
						class="inline-flex rounded-full p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100"
						@click="showBookModal = false"
						aria-label="Close booking form"
					>
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M6 6l12 12M6 18L18 6" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</button>
				</div>

				<form class="mt-4 space-y-3" @submit.prevent="if(isBookFormValid) { closeModals(); showToast('Visit request sent. The clinic will call you back soon.'); }">
					<div class="grid sm:grid-cols-2 gap-3">
						<label class="block text-sm font-medium text-gray-700">
							<span>Your name <span class="text-red-500">*</span></span>
							<input type="text" x-model="bookForm.name" class="mt-1 input h-10" placeholder="John Smith" required>
						</label>
						<label class="block text-sm font-medium text-gray-700">
							<span>Contact email <span class="text-red-500">*</span></span>
							<input type="email" x-model="bookForm.email" class="mt-1 input h-10" placeholder="you@example.com" required>
						</label>
					</div>
					<div class="grid sm:grid-cols-2 gap-3">
						<label class="block text-sm font-medium text-gray-700">
							<span>Preferred date</span>
							<input type="date" class="mt-1 input h-10">
						</label>
						<label class="block text-sm font-medium text-gray-700">
							<span>Visit type</span>
							<select class="mt-1 select h-10">
								<option value="">Not sure</option>
								<option>Checkup</option>
								<option>Diagnostics</option>
								<option>Follow‑up</option>
							</select>
						</label>
					</div>
					<label class="block text-sm font-medium text-gray-700">
						<span>Notes for the clinic</span>
						<textarea class="mt-1 input min-h-[80px] resize-y" placeholder="Share any important context, insurance details, or preferences."></textarea>
					</label>

					<div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-3">
						<button
							type="submit"
							:disabled="!isBookFormValid"
							:class="isBookFormValid ? 'btn-primary w-full sm:w-auto justify-center' : 'btn-primary w-full sm:w-auto justify-center opacity-50 cursor-not-allowed'"
						>
							Request visit
						</button>
					</div>
				</form>
			</div>
		</div>

		{{-- Ask a question modal --}}
		<div
			x-show="showQuestionModal"
			x-transition.opacity
			class="fixed inset-0 z-40 flex items-end sm:items-center justify-center bg-black/40 px-4 py-4 sm:py-6"
			aria-modal="true"
			role="dialog"
		>
			<div
				x-show="showQuestionModal"
				x-transition
				@click.outside="showQuestionModal = false"
				class="w-full max-w-lg rounded-3xl bg-white shadow-2xl border border-gray-100 p-5 sm:p-6 md:p-7"
			>
				<div class="flex items-start justify-between gap-3">
					<div>
						<h2 class="mt-1 text-lg sm:text-xl font-semibold text-gray-900">Ask about {{ $organization->name }}</h2>
						<p class="mt-1 text-xs sm:text-sm text-gray-500">
							Ask about services, insurance coverage, opening hours, or anything else you need to clarify.
						</p>
					</div>
					<button
						type="button"
						class="inline-flex rounded-full p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100"
						@click="showQuestionModal = false"
						aria-label="Close question form"
					>
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M6 6l12 12M6 18L18 6" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</button>
				</div>

				<form class="mt-4 space-y-3" @submit.prevent="if(isQuestionFormValid) { closeModals(); showToast('Question sent. Expect a reply from the clinic.'); }">
					<label class="block text-sm font-medium text-gray-700">
						<span>Your email <span class="text-red-500">*</span></span>
						<input type="email" x-model="questionForm.email" class="mt-1 input h-10" placeholder="you@example.com" required>
					</label>
					<label class="block text-sm font-medium text-gray-700">
						<span>Your question <span class="text-red-500">*</span></span>
						<textarea
							x-model="questionForm.question"
							class="mt-1 input min-h-[90px] resize-y"
							placeholder="Ask about services, insurance coverage, opening hours, or anything else."
							required
						></textarea>
					</label>

					<div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-3">
						<button
							type="submit"
							:disabled="!isQuestionFormValid"
							:class="isQuestionFormValid ? 'btn-primary w-full sm:w-auto justify-center' : 'btn-primary w-full sm:w-auto justify-center opacity-50 cursor-not-allowed'"
						>
							Send question
						</button>
					</div>
				</form>
			</div>
		</div>

		{{-- Global toast for lightweight success messages --}}
		<div
			x-show="toastVisible"
			x-transition.opacity.duration.200ms
			x-transition.scale.duration.200ms
			class="fixed bottom-4 left-1/2 -translate-x-1/2 sm:left-auto sm:right-6 sm:translate-x-0 z-50"
		>
			<div class="rounded-full bg-gray-900 text-white text-sm sm:text-base px-4 sm:px-5 py-2.5 shadow-lg shadow-black/40 flex items-center gap-2">
				<svg class="w-4 h-4 text-emerald-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<p x-text="toastMessage"></p>
			</div>
		</div>
	</div>
@endsection
