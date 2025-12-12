<div class="flex items-center justify-between gap-2">
	<h2 class="text-base sm:text-lg font-semibold text-gray-900">Patient reviews</h2>
	@if($doctor->reviews->count() > 0)
		<span class="text-xs text-gray-500">
			{{ $doctor->reviews->count() }}
			{{ \Illuminate\Support\Str::plural('review', $doctor->reviews->count()) }}
		</span>
	@endif
</div>

@if($doctor->reviews->count() > 0)
	<div class="mt-4 space-y-3">
		@foreach($doctor->reviews as $review)
			<article class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm">
				<div class="flex items-start justify-between gap-3">
					<div>
						<p class="font-semibold text-gray-900">{{ $review->name }}</p>
						<p class="text-xs text-gray-500">{{ $review->created_at->format('M j, Y') }}</p>
					</div>
					<div class="flex items-center gap-1 text-amber-400">
						@for($i = 0; $i < 5; $i++)
							<svg class="w-4 h-4" viewBox="0 0 24 24" fill="{{ $i < $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
								<path d="m12 3.5 2.47 5 5.53.8-4 3.9.94 5.5L12 16.9 7.06 18.7 8 13.9l-4-3.9 5.53-.8L12 3.5Z"/>
							</svg>
						@endfor
					</div>
				</div>
				@if($review->comment)
					<p class="mt-2 text-gray-700 leading-relaxed">
						{{ $review->comment }}
					</p>
				@endif
			</article>
		@endforeach
	</div>
@else
	<p class="mt-2 text-sm text-gray-500">
		No reviews yet — be the first to share your experience.
	</p>
@endif






