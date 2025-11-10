@php /** @var \Illuminate\Support\Collection $cities */ @endphp
<option value="">Any city</option>
@foreach($cities as $c)
	<option value="{{ $c }}" @selected(($filters['city'] ?? '') === $c)>{{ $c }}</option>
@endforeach


