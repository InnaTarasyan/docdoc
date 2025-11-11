@extends('layouts.app')

@section('title', 'Specialties')

@section('breadcrumbs')
	<a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<span>Specialties</span>
@endsection

@section('content')
	<h1 class="text-xl font-semibold text-gray-900 mb-4">Specialties</h1>
	@if($specialties->count() === 0)
		<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No specialties found.</div>
	@else
		<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
			@foreach($specialties as $spec)
				<a href="{{ route('doctors.index', ['specialty' => $spec->description]) }}" target="_blank" rel="noopener noreferrer" class="block rounded-lg bg-white border shadow-sm px-4 py-3 hover:border-sky-600 hover:shadow transition text-gray-800">
					<div class="flex items-center gap-2">
						@include('components.specialty-icon', ['name' => $spec->description, 'class' => 'mr-1'])
						<div class="min-w-0">
							<div class="font-medium text-sm truncate">{{ $spec->description }}</div>
							<div class="text-xs text-gray-500 mt-0.5">{{ $spec->code }}</div>
						</div>
					</div>
				</a>
			@endforeach
		</div>
		<div class="mt-6">
			{{ $specialties->links() }}
		</div>
	@endif
@endsection


