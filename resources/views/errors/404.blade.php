@extends('layouts.app')

@section('title', 'Page Not Found - 404')

@section('content')
<div class="error-404-container">
	<div class="error-404-content">
		<!-- 404 Number with enhanced decorative elements -->
		<div class="error-404-number-wrapper">
			<div class="error-404-glow"></div>
			<h1 class="error-404-number">404</h1>
			<div class="error-404-icon-overlay">
				<svg class="w-full h-full text-brand-400 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
				</svg>
			</div>
		</div>

		<!-- Main Message -->
		<h2 class="error-404-title">
			Page Not Found
		</h2>
		<p class="error-404-description">
			Oops! The page you're looking for seems to have wandered off. It might have been moved, deleted, or perhaps it never existed.
		</p>

		<!-- Decorative Icons -->
		<div class="error-404-decorative-icons">
			<svg class="error-404-icon error-404-icon-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25a4.5 4.5 0 0 1 8.25-2.602A4.5 4.5 0 0 1 21 8.25Z"/>
			</svg>
			<svg class="error-404-icon error-404-icon-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16M4 12h16"/>
			</svg>
			<svg class="error-404-icon error-404-icon-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
			</svg>
		</div>

		<!-- Action Buttons -->
		<div class="error-404-buttons">
			<a href="{{ route('home') }}" class="error-404-btn error-404-btn-primary">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
				</svg>
				<span>Go to Homepage</span>
			</a>
			<button onclick="window.history.back()" class="error-404-btn error-404-btn-secondary">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
				</svg>
				<span>Go Back</span>
			</button>
		</div>

		<!-- Quick Links -->
		<div class="error-404-quick-links">
			<p class="error-404-quick-links-label">You might be looking for:</p>
			<div class="error-404-quick-links-list">
				<a href="{{ route('doctors.index') }}" class="error-404-quick-link">
					Doctors
				</a>
				<span class="error-404-quick-link-separator">•</span>
				<a href="{{ route('organizations.index') }}" class="error-404-quick-link">
					Organizations
				</a>
				<span class="error-404-quick-link-separator">•</span>
				<a href="{{ route('specialties.index') }}" class="error-404-quick-link">
					Specialties
				</a>
				<span class="error-404-quick-link-separator">•</span>
				<a href="{{ route('search.index') }}" class="error-404-quick-link">
					Search
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

