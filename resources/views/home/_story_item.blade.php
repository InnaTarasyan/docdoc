<article class="h-full rounded-3xl border border-white/30 bg-white/95 p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl" role="listitem">
	<div class="flex items-center gap-3">
		<div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 font-semibold flex items-center justify-center">
			{{ $initials }}
		</div>
		<div>
			<p class="text-base font-semibold text-gray-900">{{ $story->name }}</p>
			<p class="text-xs text-gray-500">{{ $story->created_at->format('M j, Y') }}</p>
		</div>
		<span class="ml-auto inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
			<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			Verified
		</span>
	</div>
	<p class="mt-5 text-base leading-relaxed text-gray-700 border-l-2 border-emerald-100 pl-4">
		"{{ $story->comment }}"
	</p>
	<div class="mt-6 flex items-center justify-between text-sm font-semibold">
		<div class="inline-flex items-center gap-1 text-yellow-500">
			@for($i = 0; $i < 5; $i++)
				<svg class="w-4 h-4" viewBox="0 0 20 20" fill="{{ $i < $story->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
					<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
				</svg>
			@endfor
		</div>
	</div>
</article>

