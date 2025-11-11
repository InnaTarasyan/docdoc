<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title', config('app.name', 'Doc Directory'))</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
		<header class="app-header">
			<div class="container-tight" x-data="{ open: false }">
				<div class="flex items-center justify-between h-16">
					<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 font-semibold text-lg text-sky-700">
						<span>DocDoc</span>
					</a>
					<nav class="hidden sm:flex items-center gap-6 text-sm">
						<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="hover:text-sky-700">Doctors</a>
						<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="hover:text-sky-700">Organizations</a>
						<a href="{{ route('specialties.index') }}" target="_blank" rel="noopener noreferrer" class="hover:text-sky-700">Specialties</a>
					</nav>
					<button @click="open = !open" class="sm:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50" aria-label="Open menu">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
						</svg>
					</button>
				</div>
				<div x-cloak class="sm:hidden">
					<div x-show="open" class="py-2 border-t">
						<a href="{{ route('doctors.index') }}" target="_blank" rel="noopener noreferrer" class="block px-2 py-2 hover:bg-gray-50 rounded-md">Doctors</a>
						<a href="{{ route('organizations.index') }}" target="_blank" rel="noopener noreferrer" class="block px-2 py-2 hover:bg-gray-50 rounded-md">Organizations</a>
						<a href="{{ route('specialties.index') }}" target="_blank" rel="noopener noreferrer" class="block px-2 py-2 hover:bg-gray-50 rounded-md">Specialties</a>
					</div>
				</div>
			</div>
		</header>

		<main class="container-tight py-8">
			@hasSection('breadcrumbs')
				<nav class="mb-6 text-sm text-gray-600">
					@yield('breadcrumbs')
				</nav>
			@endif
			@yield('content')
		</main>

		<footer class="app-footer">
			<div class="container-tight py-6">
				<p>&copy; {{ date('Y') }} DocDoc Directory</p>
			</div>
		</footer>
	</body>
	</html>


