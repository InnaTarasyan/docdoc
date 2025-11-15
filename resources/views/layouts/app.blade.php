<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title', config('app.name', 'Doc Directory'))</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="min-h-screen bg-gray-50 text-gray-900 antialiased flex flex-col">
		<header class="app-header">
			<div class="container-tight" x-data="{ open: false }">
				<div class="flex items-center justify-between h-16">
					<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 font-semibold text-lg text-brand-700 group">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 text-brand-600 group-hover:text-brand-700 transition-colors">
							<path d="M12 4v16M4 12h16" stroke-width="2" stroke-linecap="round"/>
						</svg>
						<span>DocDoc</span>
					</a>
					<nav class="hidden sm:flex items-center gap-6 text-sm">
						<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Doctors</a>
						<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Organizations</a>
						<a href="{{ route('specialties.index') }}" target="_blank" rel="noopener noreferrer" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">Specialties</a>
						<a href="{{ route('about') }}" class="text-gray-700 hover:text-brand-700 transition-colors font-medium">About</a>
					</nav>
					<button @click="open = !open" class="sm:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors" aria-label="Toggle menu" aria-expanded="false" :aria-expanded="open">
						<svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
						</svg>
						<svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
						</svg>
					</button>
				</div>
				<div x-cloak x-show="open" 
					 x-transition:enter="transition ease-out duration-200"
					 x-transition:enter-start="opacity-0 transform -translate-y-1"
					 x-transition:enter-end="opacity-100 transform translate-y-0"
					 x-transition:leave="transition ease-in duration-150"
					 x-transition:leave-start="opacity-100 transform translate-y-0"
					 x-transition:leave-end="opacity-0 transform -translate-y-1"
					 class="sm:hidden border-t">
					<div class="py-2">
						<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Doctors</a>
						<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Organizations</a>
						<a href="{{ route('specialties.index') }}" target="_blank" rel="noopener noreferrer" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">Specialties</a>
						<a href="{{ route('about') }}" class="block px-4 py-2.5 hover:bg-gray-50 rounded-md transition-colors text-gray-700 hover:text-gray-900">About</a>
					</div>
				</div>
			</div>
		</header>

		<main class="container-tight py-8 flex-grow">
			@hasSection('breadcrumbs')
				<nav class="mb-6 text-sm text-gray-600">
					@yield('breadcrumbs')
				</nav>
			@endif
			@yield('content')
		</main>

	<footer class="app-footer">
		<div class="container-tight py-8 sm:py-10">
			<div class="footer-content">
				<!-- Copyright and Developer Info -->
				<div class="footer-section">
					<p class="footer-copyright">
						&copy; {{ date('Y') }} Inna Tarasyan. All rights reserved.
					</p>
					<p class="footer-developer">
						Website developed and maintained by <strong>Inna Tarasyan</strong>, Web Developer.
					</p>
				</div>

				<!-- Contact Request -->
				<div class="footer-section">
					<p class="footer-contact">
						🤝 We kindly ask that you do not use or share information from this site without first reaching out to the author. If you have questions or would like to use any content, please contact <strong>Inna Tarasyan</strong>—I'm always happy to connect!
					</p>
				</div>

				<!-- Legal Links -->
				<div class="footer-section footer-links-wrapper">
					<div class="footer-links">
						<a href="{{ route('legal.privacy') }}" class="footer-link">Privacy Policy</a>
						<span class="footer-link-separator">|</span>
						<a href="{{ route('legal.terms') }}" class="footer-link">Terms of Use</a>
					</div>
				</div>

				<!-- Security Status -->
				<div class="footer-section footer-security">
					<div class="security-badge">
						<span class="security-icon">✅</span>
						<span>Site status: No unsafe content detected by Google Safe Browsing.</span>
					</div>
					<div class="security-badge">
						<span class="security-icon">🔒</span>
						<span>Our SSL security has been rated A by Qualys SSL Labs.</span>
					</div>
					<div class="security-badge">
						<span class="security-icon">✅</span>
						<span>Checked by Google Safe Browsing</span>
					</div>
				</div>
			</div>
		</div>
	</footer>
	</body>
	</html>


