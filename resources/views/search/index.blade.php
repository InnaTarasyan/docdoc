@extends('layouts.app')

@section('title', 'Search')

@section('breadcrumbs')
	<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Search</span>
@endsection

@section('content')
	<div class="grid gap-6">
		<form action="{{ route('search.index') }}" method="get" class="ajax-filter-form" data-ajax-list="true" data-results="#search-results">
			<div class="flex flex-col sm:flex-row gap-3">
				<div class="relative flex-1">
					<span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
							<path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.473 9.8l3.613 3.614a.75.75 0 1 0 1.06-1.06l-3.614-3.614A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" />
						</svg>
					</span>
					<input type="text" name="q" value="{{ old('q', $q) }}" placeholder="Search doctors, organizations, or specialties" class="input pl-10 h-12" autocomplete="off" />
				</div>
				<button type="submit" class="btn-primary h-12 px-6">Search</button>
			</div>
		</form>

		<section id="search-results">
			@include('search._results', [
				'q' => $q,
				'doctors' => $doctors,
				'organizations' => $organizations,
				'specialties' => $specialties,
			])
		</section>
	</div>
@endsection

*** End Patch***  }?> ***!

