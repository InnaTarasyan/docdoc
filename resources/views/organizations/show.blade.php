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
	<div
		class="grid lg:grid-cols-3 gap-6"
		x-data="{
			showBookModal: false,
			showQuestionModal: false,
			toast: null,
			toastTimeout: null,
			openBook() {
				this.showQuestionModal = false;
				this.showBookModal = true;
			},
			openQuestion() {
				this.showBookModal = false;
				this.showQuestionModal = true;
			},
			closeModals() {
				this.showBookModal = false;
				this.showQuestionModal = false;
			},
			showToast(message) {
				this.toast = message;
				clearTimeout(this.toastTimeout);
				this.toastTimeout = setTimeout(() => this.toast = null, 3500);
			}
		}"
		x-cloak
	>
		<div
			x-show="toast"
			x-transition
			class="fixed inset-x-4 bottom-6 z-40 sm:inset-x-auto sm:right-6 sm:left-auto sm:max-w-sm"
			role="status"
			aria-live="polite"
		>
			<div class="flex items-start gap-3 rounded-2xl bg-emerald-600 text-emerald-50 px-4 py-3 shadow-xl shadow-emerald-900/30 border border-emerald-300/60">
				<div class="mt-0.5">
					<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M12 9v4m0 4h.01M10.29 3.86 2.82 18a1.7 1.7 0 0 0 0 1.7c.3.53.86.86 1.47.86h15.42c.61 0 1.17-.33 1.47-.86a1.7 1.7 0 0 0 0-1.7L13.71 3.86a1.7 1.7 0 0 0-2.96 0Z" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
				<div class="text-sm font-medium" x-text="toast"></div>
				<button
					type="button"
					class="ml-auto text-emerald-100/80 hover:text-white transition"
					@click="toast = null"
					aria-label="Close notification"
				>
					<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M6 6l12 12M6 18L18 6" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
			</div>
		</div>

		<section class="lg:col-span-2 space-y-4 sm:space-y-6">
			<div class="bg-white sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 rounded-2xl sm:rounded-[32px] border border-gray-100 sm:border-white/10 shadow-sm sm:shadow-[0_25px_60px_rgba(6,95,70,0.3)] overflow-hidden">
				<div class="hidden sm:block absolute inset-0 rounded-[32px] border border-white/15 opacity-40 pointer-events-none"></div>
				<div class="hidden sm:block absolute -top-16 -left-4 w-64 h-64 bg-emerald-400/30 blur-[140px] rounded-full pointer-events-none"></div>
				<div class="hidden sm:block absolute -bottom-20 right-0 w-72 h-72 bg-teal-300/25 blur-[160px] rounded-full pointer-events-none"></div>

				<div class="relative z-10 p-4 sm:p-8 lg:p-10">
					<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
						<div class="flex items-start gap-4 sm:gap-6">
							<div class="shrink-0">
								<div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl sm:rounded-[26px] bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-400 flex items-center justify-center text-white text-2xl sm:text-3xl font-semibold shadow-lg shadow-emerald-900/30">
									@php
										$initials = collect(explode(' ', $organization->name))
											->filter()
											->take(3)
											->map(fn($part) => mb_substr($part, 0, 1))
											->implode('');
									@endphp
									{{ $initials }}
								</div>
							</div>
							<div class="space-y-2 sm:space-y-3">
								<div class="flex flex-wrap items-center gap-2 sm:gap-3">
									<h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 sm:text-white">
										{{ $organization->name }}
									</h1>
									<span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-emerald-50 sm:bg-white/15 text-emerald-800 sm:text-emerald-50 ring-1 ring-emerald-100 sm:ring-white/30">
										Healthcare organization
									</span>
								</div>
								<div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
									@if($organization->city || $organization->state)
										<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 sm:bg-emerald-900/35 text-gray-800 sm:text-emerald-50">
											<svg class="w-4 h-4 text-emerald-600 sm:text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
												<circle cx="12" cy="9" r="2.5"/>
											</svg>
											<span>{{ $organization->city ?: '—' }}{{ $organization->state ? ', '.$organization->state : '' }}</span>
										</span>
									@endif
									@if($organization->phone)
										<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 sm:bg-emerald-900/35 text-gray-800 sm:text-emerald-50">
											<svg class="w-4 h-4 text-emerald-600 sm:text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .95.68l1.5 4.5a1 1 0 0 1-.5 1.22l-2.26 1.13a11.05 11.05 0 0 0 5.52 5.52l1.13-2.26a1 1 0 0 1 1.22-.5l4.5 1.5a1 1 0 0 1 .68.95V19a2 2 0 0 1-2 2h-1C9.72 21 3 14.28 3 6V5Z" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											<span>{{ $organization->phone }}</span>
										</span>
									@endif
								</div>
							</div>
						</div>

						<div class="w-full lg:w-auto">
							<div class="rounded-2xl sm:rounded-3xl bg-gray-50 sm:bg-white/10 border border-gray-100 sm:border-white/20 px-4 py-3 sm:px-5 sm:py-4 text-sm sm:text-base text-gray-800 sm:text-emerald-50 flex flex-col gap-3 sm:gap-4">
								<div class="flex items-center justify-between gap-3">
									<div>
										<p class="text-xs uppercase tracking-wide text-gray-500 sm:text-emerald-200 font-semibold">Availability</p>
										<p class="mt-1 text-sm font-medium text-gray-800 sm:text-emerald-50">Checkups, diagnostics & more</p>
									</div>
									<a
										href="{{ route('organizations.index') }}"
										class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wide text-emerald-100/80 hover:text-white"
									>
										<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										<span>Back to search</span>
									</a>
								</div>
								<div class="flex flex-col sm:flex-row sm:items-center gap-2">
									<button
										type="button"
										@click="openBook()"
										class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-emerald-900/30 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-400 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900/40"
									>
										<svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 5v14m-7-7h14" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										<span>Book a visit</span>
									</button>
									<button
										type="button"
										@click="openQuestion()"
										class="inline-flex items-center justify-center px-3.5 py-2 rounded-full text-xs sm:text-sm font-semibold text-brand-700 sm:text-emerald-50 bg-white sm:bg-transparent border border-brand-100 sm:border-white/40 hover:bg-brand-50 sm:hover:bg-white/10 transition"
									>
										<svg class="w-4 h-4 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M12 18h.01M8 9a4 4 0 0 1 7.06-2.53A3.5 3.5 0 0 1 14 13.5h-1v1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7L5 7v12a2 2 0 0 0 2 2Z" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										<span>Ask a question</span>
									</button>
								</div>
								<p class="text-[11px] sm:text-xs text-gray-500 sm:text-emerald-100/80">
									Booking and questions here are design previews only — no real data is sent.
								</p>
							</div>
						</div>
					</div>

					<div class="mt-6 grid sm:grid-cols-2 gap-4 text-sm">
						<div class="rounded-xl border border-gray-100 sm:border-white/20 bg-white/95 sm:bg-white/10 p-4">
							<h2 class="text-sm font-medium text-gray-900 sm:text-white mb-1.5">Location</h2>
							<p class="text-gray-800 sm:text-emerald-50">
								{{ $organization->city ?: '—' }}{{ $organization->state ? ', '.$organization->state : '' }}
							</p>
							@if($organization->city || $organization->state)
								<p class="mt-1 text-xs text-gray-500 sm:text-emerald-100/80">
									Exact address is not displayed here. Use the city and state when planning your visit.
								</p>
							@endif
						</div>
						<div class="rounded-xl border border-gray-100 sm:border-white/20 bg-white/95 sm:bg-white/10 p-4">
							<h2 class="text-sm font-medium text-gray-900 sm:text-white mb-1.5">Contact</h2>
							<p class="text-gray-800 sm:text-emerald-50">
								{{ $organization->phone ?: 'Phone not listed in registry data.' }}
							</p>
							<p class="mt-1 text-xs text-gray-500 sm:text-emerald-100/80">
								In a live product, this area could include email, website and online check‑in links.
							</p>
						</div>
					</div>
				</div>
			</div>

			@if($linkedDoctors->count() > 0)
				<div class="mt-4 sm:mt-6">
					<h2 class="text-lg font-medium text-gray-900 mb-3">Doctors at this organization</h2>
					<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
						@foreach($linkedDoctors as $doctor)
							<a href="{{ route('doctors.show', $doctor) }}" class="group block rounded-xl bg-white border border-gray-100 p-4 shadow-sm hover:border-brand-600 hover:shadow-md transition overflow-hidden">
								<div class="flex flex-col gap-1.5">
									<div class="font-medium text-gray-900 group-hover:text-brand-700 line-clamp-2">{{ $doctor->name }}</div>
									<div class="text-sm text-gray-600 line-clamp-2">{{ $doctor->taxonomy ?: 'Specialty not specified' }}</div>
									@if($doctor->city || $doctor->state)
										<div class="mt-1 text-xs font-medium text-gray-700 flex items-center gap-1.5">
											<svg class="w-3.5 h-3.5 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
												<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
												<circle cx="12" cy="9" r="2.5"/>
											</svg>
											<span>{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', '.$doctor->state : '' }}</span>
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
				<div class="bg-white rounded-2xl border shadow-sm p-6">
					<h2 class="font-medium text-gray-900">Quick info</h2>
					<dl class="mt-3 space-y-2 text-sm">
						<dt class="font-medium text-gray-700">City / State</dt>
						<dd class="text-gray-900">{{ $organization->city ?: '—' }} {{ $organization->state ? ", $organization->state" : '' }}</dd>
						<dt class="font-medium text-gray-700">Phone</dt>
						<dd class="text-gray-900">{{ $organization->phone ?: '—' }}</dd>
					</dl>
				</div>

				<div class="bg-gradient-to-br from-brand-600 via-emerald-600 to-teal-500 rounded-2xl shadow-lg text-white p-4 sm:p-5">
					<h3 class="text-sm sm:text-base font-semibold mb-2">Browse more organizations</h3>
					<p class="text-xs sm:text-sm text-emerald-50/90 mb-3">
						Use filters to compare clinics, hospitals, and medical centers in your area.
					</p>
					<a
						href="{{ route('organizations.index') }}"
						class="inline-flex items-center justify-center px-4 py-2.5 rounded-full bg-white text-sm font-semibold text-brand-800 hover:bg-brand-50 transition"
					>
						<svg class="w-4 h-4 mr-1.5 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M4 12h16m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<span>Back to search</span>
					</a>
				</div>
			</div>
		</aside>

		{{-- Book visit modal (imitation) --}}
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
						<p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-500">Booking (preview only)</p>
						<h2 class="mt-1 text-lg sm:text-xl font-semibold text-gray-900">Book a visit at {{ $organization->name }}</h2>
						<p class="mt-1 text-xs sm:text-sm text-gray-500">
							This is a visual-only booking experience. Use it to see how a real flow could feel.
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

				<form
					class="mt-4 space-y-3"
					@submit.prevent="
						closeModals();
						showToast('Visit request preview submitted. In a production app, this would notify the organization.');
					"
				>
					<div class="grid sm:grid-cols-2 gap-3">
						<label class="block text-sm font-medium text-gray-700">
							<span>Your name</span>
							<input type="text" class="mt-1 input h-10" placeholder="John Smith" required>
						</label>
						<label class="block text-sm font-medium text-gray-700">
							<span>Contact email</span>
							<input type="email" class="mt-1 input h-10" placeholder="you@example.com" required>
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
							class="btn-primary w-full sm:w-auto justify-center"
						>
							Preview submit
						</button>
						<p class="text-[11px] sm:text-xs text-gray-500">
							No real appointment is created from this form.
						</p>
					</div>
				</form>
			</div>
		</div>

		{{-- Ask a question modal (imitation) --}}
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
						<p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-500">Question (preview only)</p>
						<h2 class="mt-1 text-lg sm:text-xl font-semibold text-gray-900">Ask about {{ $organization->name }}</h2>
						<p class="mt-1 text-xs sm:text-sm text-gray-500">
							Great for testing how a support or triage form could behave on mobile and desktop.
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

				<form
					class="mt-4 space-y-3"
					@submit.prevent="
						closeModals();
						showToast('Question preview submitted. In production, this would route to the organization or support.');
					"
				>
					<label class="block text-sm font-medium text-gray-700">
						<span>Your email</span>
						<input type="email" class="mt-1 input h-10" placeholder="you@example.com" required>
					</label>
					<label class="block text-sm font-medium text-gray-700">
						<span>Your question</span>
						<textarea
							class="mt-1 input min-h-[90px] resize-y"
							placeholder="Ask about services, insurance coverage, opening hours, or anything else."
							required
						></textarea>
					</label>

					<div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-3">
						<button
							type="submit"
							class="btn-primary w-full sm:w-auto justify-center"
						>
							Preview send
						</button>
						<p class="text-[11px] sm:text-xs text-gray-500">
							This interaction is for UX preview only; no message is stored or sent.
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection


