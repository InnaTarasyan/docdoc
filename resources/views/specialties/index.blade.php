@extends('layouts.app')

@section('title', 'Specialties')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Specialties</span>
@endsection

@section('content')
	@php
		$totalSpecialties = method_exists($specialties, 'total') ? $specialties->total() : $specialties->count();
		$pageSpecialties = $specialties->count();
	@endphp

	<div class="space-y-6 sm:space-y-8">
		<section class="relative mt-1 sm:mt-0 sm:rounded-[36px] sm:overflow-hidden sm:border sm:border-white/10 sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:p-8 sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)] text-white">
			<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/15 bg-white/10 backdrop-blur-2xl"></div>
			<div class="hidden sm:block absolute -top-16 -right-12 w-64 h-64 bg-emerald-300/35 blur-[140px] rounded-full pointer-events-none"></div>
			<div class="hidden sm:block absolute bottom-[-40px] left-6 w-72 h-72 bg-emerald-400/30 blur-[160px] rounded-full pointer-events-none"></div>

			<div class="relative z-10 px-4 py-6 sm:p-0">
				<p class="text-sm uppercase tracking-[0.25em] font-semibold text-emerald-100/80 mb-3">Browse specialties</p>
				<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
					<div class="space-y-3 max-w-2xl">
						<h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold leading-tight text-gray-900 sm:text-white">Find the specialty that matches your needs</h1>
						<p class="text-sm sm:text-base text-gray-600 sm:text-emerald-50/90">Tap a specialty card to open doctors who practice in that field. The layout adapts smoothly from small phones to wide desktop screens.</p>
					</div>
					<a href="{{ route('doctors.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/40 bg-white/95 px-5 py-3 text-sm font-semibold text-emerald-900 shadow-lg shadow-black/10 transition hover:bg-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-900">
						View doctors
						<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
				<div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
					<div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur">
						<p class="text-xs uppercase tracking-wide text-white/70">Total specialties</p>
						<p class="text-2xl sm:text-3xl font-semibold">{{ number_format($totalSpecialties) }}</p>
					</div>
					<div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur">
						<p class="text-xs uppercase tracking-wide text-white/70">This page</p>
						<p class="text-2xl sm:text-3xl font-semibold">{{ number_format($pageSpecialties) }}</p>
					</div>
					<div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur">
						<p class="text-xs uppercase tracking-wide text-white/70">Mobile friendly</p>
						<p class="text-lg font-semibold flex items-center gap-1">
							<svg class="w-5 h-5 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							Tap to explore
						</p>
					</div>
				</div>
			</div>
		</section>

		@if($specialties->count() === 0)
			<div class="relative rounded-3xl border border-dashed border-gray-300 bg-white px-6 py-10 text-center shadow-sm">
				<div class="absolute -top-4 left-1/2 -translate-x-1/2 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
					Status
					<span class="inline-flex h-2 w-2 rounded-full bg-red-400 animate-pulse"></span>
				</div>
				<p class="text-lg font-semibold text-gray-900">No specialties match yet</p>
				<p class="mt-2 text-sm text-gray-600">Please adjust your search or try again later — we are adding more specialties every week.</p>
				<a href="{{ route('home') }}" class="mt-5 inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/70">
					Back to home
					<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
			</div>
		@else
			<section class="relative rounded-3xl border border-gray-200/70 bg-white shadow-sm sm:rounded-[30px] sm:border-white/20 sm:bg-white/95 sm:shadow-[0_25px_50px_rgba(15,118,110,0.12)] overflow-hidden">
				<div class="hidden sm:block absolute inset-0 rounded-[30px] border border-white/20 pointer-events-none"></div>
				<div class="hidden sm:block absolute inset-y-8 right-8 w-32 bg-emerald-100/40 blur-3xl rounded-full pointer-events-none"></div>
				<div class="relative z-10 p-4 sm:p-8">
					<div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
						<div>
							<p class="text-xs uppercase tracking-wide text-brand-700 font-semibold">Specialty directory</p>
							<h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Tap a card to open matching doctors</h2>
							<p class="text-sm text-gray-600 mt-1">Cards stretch evenly on desktop, while mobile stacks them neatly for thumb-friendly browsing.</p>
						</div>
						<div class="inline-flex flex-wrap gap-2 text-xs text-gray-600">
							<span class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-gray-50 px-3 py-1">Swipe on mobile</span>
							<span class="inline-flex items-center gap-1 rounded-full border border-brand-100 bg-brand-50 text-brand-700 px-3 py-1">Hover for CTA</span>
						</div>
					</div>

					<div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 sm:gap-4">
						@foreach($specialties as $spec)
							<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}"
							   class="group relative block overflow-hidden rounded-2xl border border-gray-100/80 bg-white px-4 py-4 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-brand-500 hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500/40">
								<div class="absolute inset-0 bg-gradient-to-br from-brand-50/80 via-transparent to-brand-100/60 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
								<div class="relative z-10 flex items-start gap-3">
									<div class="inline-flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 ring-1 ring-brand-100 transition-transform duration-300 group-hover:scale-110">
										@include('components.specialty-icon', ['name' => $spec->description, 'class' => 'w-5 h-5'])
									</div>
									<div class="min-w-0 flex-1">
										<div class="font-semibold text-gray-900 leading-tight line-clamp-2 group-hover:text-brand-800">
											{{ $spec->description }}
										</div>
										<div class="mt-1 text-xs uppercase tracking-wide text-gray-500">Code {{ $spec->code }}</div>
									</div>
								</div>
								<div class="relative z-10 mt-4 flex items-center justify-between text-sm font-semibold text-brand-700">
									<span>View doctors</span>
									<svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
							</a>
						@endforeach
					</div>

					<div class="mt-8">
						{{ $specialties->links() }}
					</div>
				</div>
			</section>
		@endif
	</div>
@endsection


