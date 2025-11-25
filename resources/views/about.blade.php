@extends('layouts.app')

@section('title', 'About')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>About</span>
@endsection

@section('content')
	<div class="space-y-6 sm:space-y-10">
		<section class="relative overflow-hidden rounded-3xl border border-white/10 bg-white px-4 py-6 shadow-sm sm:rounded-[36px] sm:bg-gradient-to-br sm:from-emerald-900 sm:via-emerald-800 sm:to-emerald-900 sm:px-8 sm:py-10 sm:text-white sm:shadow-[0_25px_60px_rgba(6,95,70,0.28)]">
			<div class="hidden sm:block absolute inset-0 rounded-[36px] border border-white/15 opacity-80 pointer-events-none"></div>
			<div class="hidden sm:block absolute -top-10 -right-8 h-48 w-48 rounded-full bg-emerald-300/35 blur-[140px]"></div>
			<div class="hidden sm:block absolute bottom-0 left-6 h-64 w-64 rounded-full bg-emerald-500/20 blur-[200px]"></div>

			<div class="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-center">
				<div class="flex-1 space-y-5 text-center sm:text-left">
					<p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-brand-700 sm:text-emerald-100/80">Independent builder</p>
					<h1 class="text-3xl font-semibold leading-tight text-gray-900 sm:text-white">Hi, I'm Inna Tarasyan</h1>
					<p class="text-base text-gray-600 sm:text-emerald-50/90">
						I build healthcare data tools that feel modern, credible, and fast. The DocDoc directory imports official NPI Registry data,
						organizes it with Laravel, and exposes mobile-friendly ways to explore doctors, organizations, and specialties.
					</p>
					<div class="grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 sm:grid-cols-3">
						<div class="rounded-2xl border border-gray-100/70 bg-brand-50/70 px-4 py-3 text-gray-900 sm:border-white/25 sm:bg-white/10 sm:text-white">
							<p class="text-[11px] uppercase tracking-[0.3em] text-gray-600 sm:text-white/70">Base</p>
							<p class="text-lg font-semibold">🇦🇲 Armenia</p>
						</div>
						<div class="rounded-2xl border border-gray-100/70 bg-brand-50/70 px-4 py-3 text-gray-900 sm:border-white/25 sm:bg-white/10 sm:text-white">
							<p class="text-[11px] uppercase tracking-[0.3em] text-gray-600 sm:text-white/70">Stack</p>
							<p class="text-lg font-semibold">Laravel + Livewire</p>
						</div>
						<div class="rounded-2xl border border-gray-100/70 bg-brand-50/70 px-4 py-3 text-gray-900 sm:border-white/25 sm:bg-white/10 sm:text-white">
							<p class="text-[11px] uppercase tracking-[0.3em] text-gray-600 sm:text-white/70">Focus</p>
							<p class="text-lg font-semibold">Real data UX</p>
						</div>
					</div>
				</div>

				<div class="mx-auto w-full max-w-xs sm:max-w-sm">
					<div class="relative overflow-hidden rounded-[32px] border border-white/40 bg-gradient-to-br from-emerald-600/40 to-emerald-800/70 p-3 shadow-[0_20px_40px_rgba(6,95,70,0.35)]">
						<div class="absolute inset-0 rounded-[32px] border border-white/40"></div>
						<div class="relative rounded-[28px] bg-white/95 p-3">
							<img src="{{ asset('img/inna.jpg') }}" alt="Inna Tarasyan" class="h-64 w-full rounded-[24px] object-cover sm:h-72">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="rounded-3xl border border-gray-200/70 bg-white p-5 shadow-sm sm:rounded-[32px] sm:p-8 sm:shadow-[0_25px_50px_rgba(15,118,110,0.12)]">
			<div class="flex flex-col gap-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
				<div class="space-y-2">
					<p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-brand-700">About the project</p>
					<h2 class="text-2xl font-semibold text-gray-900 leading-snug">NPI Registry importer + directory</h2>
					<p class="text-sm text-gray-600">A Laravel 10 application that routinely pulls NPPES data, normalizes it, and surfaces it through Livewire-powered experiences.</p>
				</div>
				<div class="inline-flex items-center justify-center gap-2 rounded-2xl border border-brand-100 bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">
					<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					Live & maintained
				</div>
			</div>

			<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
				<div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-brand-50 via-white to-white px-5 py-6 shadow-sm">
					<p class="text-xs uppercase tracking-[0.3em] text-gray-500">Pipelines</p>
					<h3 class="mt-1 text-lg font-semibold text-gray-900">Reliable imports</h3>
					<p class="text-sm text-gray-600">Artisan commands fetch NPI data with per-state + specialty filters and store it without duplicates.</p>
				</div>
				<div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-brand-50 via-white to-white px-5 py-6 shadow-sm">
					<p class="text-xs uppercase tracking-[0.3em] text-gray-500">Directory</p>
					<h3 class="mt-1 text-lg font-semibold text-gray-900">Mobile-first UI</h3>
					<p class="text-sm text-gray-600">Doctors, organizations, and specialties share the same emerald gradients, rounded shells, and accessible filters.</p>
				</div>
				<div class="rounded-2xl border border-gray-100 bg-gradient-to-br from-brand-50 via-white to-white px-5 py-6 shadow-sm">
					<p class="text-xs uppercase tracking-[0.3em] text-gray-500">Trust</p>
					<h3 class="mt-1 text-lg font-semibold text-gray-900">Ownership & logging</h3>
					<p class="text-sm text-gray-600">All code, content, and updates are handled personally; logs document each import run for traceability.</p>
				</div>
			</div>
		</section>

		<section class="grid gap-6 lg:grid-cols-2">
			<div class="relative overflow-hidden rounded-[32px] border border-white/10 bg-gradient-to-br from-emerald-950 via-emerald-900 to-brand-700 p-5 text-white shadow-[0_20px_50px_rgba(6,95,70,0.25)] sm:p-8 about-mobile-card-shell">
				<div class="absolute inset-0 rounded-[32px] border border-white/15 opacity-70 pointer-events-none"></div>
				<div class="relative z-10 space-y-4 about-mobile-feature-stack">
					<p class="text-xs uppercase tracking-[0.3em] text-white/80 text-center sm:text-left">Key capabilities</p>
					<h2 class="text-2xl font-semibold leading-tight text-white text-center sm:text-left">What the platform does</h2>
					<ul class="space-y-4 text-sm text-white/90">
						<li class="flex items-start gap-3">
							<span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-sm font-semibold text-emerald-900">1</span>
							<div class="space-y-1">
								<p class="text-base font-semibold text-white">API ingestion & validation</p>
								<p class="text-white/85">Handles pagination, taxonomy filters, and guards against invalid requests before persisting.</p>
							</div>
						</li>
						<li class="flex items-start gap-3">
							<span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-sm font-semibold text-emerald-900">2</span>
							<div class="space-y-1">
								<p class="text-base font-semibold text-white">Organized data model</p>
								<p class="text-white/85">Doctors, organizations, specialties, and addresses live in purpose-built tables with searchable columns.</p>
							</div>
						</li>
						<li class="flex items-start gap-3">
							<span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-sm font-semibold text-emerald-900">3</span>
							<div class="space-y-1">
								<p class="text-base font-semibold text-white">Live filtering UI</p>
								<p class="text-white/85">AJAX/Livewire blends allow instant filtering while preserving accessibility and responsive layouts.</p>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<div class="rounded-[32px] border border-gray-200/70 bg-white p-6 shadow-sm sm:p-8 about-mobile-card-shell">
				<p class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-700">Contact & ownership</p>
				<h2 class="text-2xl font-semibold text-gray-900">Built and run by one person</h2>
				<p class="text-sm text-gray-600">
					DocDoc is a solo project. No outside company runs the data or interfaces—every component from design to infrastructure is authored and maintained by me.
				</p>
				<div class="mt-4 space-y-3">
					<div class="flex items-start gap-3 rounded-2xl border border-gray-100 bg-brand-50/50 px-4 py-3">
						<svg class="h-5 w-5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M5 7h14M5 12h14m-7 5h7" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<div>
							<p class="text-sm font-semibold text-gray-900">Transparency first</p>
							<p class="text-sm text-gray-600">Data sourcing, logs, and deployment steps are documented for clarity.</p>
						</div>
					</div>
					<div class="flex items-start gap-3 rounded-2xl border border-gray-100 bg-brand-50/50 px-4 py-3">
						<svg class="h-5 w-5 text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/>
							<path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.07 6.07-1.41-1.41M6.34 6.34 4.93 4.93m12.73 0-1.41 1.41M6.34 17.66l-1.41 1.41" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<div>
							<p class="text-sm font-semibold text-gray-900">Secure by design</p>
							<p class="text-sm text-gray-600">HTTPS-only hosting, SSL A rating, and Google Safe Browsing checks.</p>
						</div>
					</div>
				</div>
				<div class="mt-6 rounded-2xl border border-brand-100 bg-brand-50/70 px-4 py-4">
					<p class="text-sm font-semibold text-gray-900">Say hello</p>
					<p class="text-sm text-gray-600">collaboration, questions, or audits welcome.</p>
					<a href="mailto:innatarasyancryptotrading@gmail.com" class="mt-2 inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:bg-brand-700">
						Email innatarasyancryptotrading@gmail.com
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
			</div>
		</section>
	</div>
@endsection
