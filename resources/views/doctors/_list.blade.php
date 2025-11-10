@php /** @var \Illuminate\Pagination\LengthAwarePaginator $doctors */ @endphp
@if($doctors->count() === 0)
	<div class="bg-white border rounded-xl p-6 text-center text-gray-600">No doctors found. Try adjusting filters.</div>
@else
	<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
		@foreach($doctors as $doctor)
			<a href="{{ route('doctors.show', $doctor) }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl bg-white border p-4 shadow-sm hover:border-sky-600 hover:shadow transition">
				<div class="font-medium text-gray-900">{{ $doctor->name }}</div>
				<div class="text-sm text-gray-600">{{ $doctor->taxonomy ?: '—' }}</div>
				<div class="text-sm text-gray-600">{{ $doctor->gender ? ($doctor->gender === 'M' ? 'Male' : 'Female') : '' }}</div>
				<div class="text-sm text-gray-600">{{ $doctor->city }}, {{ $doctor->state }}</div>
				@if($doctor->organization_name)
					<div class="text-sm text-gray-700 mt-1">{{ $doctor->organization_name }}</div>
				@endif
			</a>
		@endforeach
	</div>

	<div class="mt-6">
		{{ $doctors->links() }}
	</div>
@endif


