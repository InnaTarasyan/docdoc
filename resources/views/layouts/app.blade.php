<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title', config('app.name', 'Doc Directory'))</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		@livewireStyles
	</head>
	<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
		<header class="bg-white shadow">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex items-center justify-between h-16">
					<a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-lg text-sky-700">
						<span>DocDoc</span>
					</a>
					<nav class="hidden sm:flex items-center gap-6 text-sm">
						<a href="{{ route('doctors.index') }}" class="hover:text-sky-700">Doctors</a>
						<a href="{{ route('organizations.index') }}" class="hover:text-sky-700">Organizations</a>
						<a href="{{ route('specialties.index') }}" class="hover:text-sky-700">Specialties</a>
					</nav>
				</div>
			</div>
		</header>

		<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			@hasSection('breadcrumbs')
				<nav class="mb-6 text-sm text-gray-600">
					@yield('breadcrumbs')
				</nav>
			@endif
			@yield('content')
		</main>

		<footer class="border-t bg-white">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-gray-600">
				<p>&copy; {{ date('Y') }} DocDoc Directory</p>
			</div>
		</footer>
		@livewireScripts
	</body>
	</html>


