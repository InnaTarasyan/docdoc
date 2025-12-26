@php
	// Helper function to highlight search terms
	$highlightSearch = function($text, $searchTerm) {
		if (empty($searchTerm) || empty($text)) {
			return e($text);
		}
		
		// Escape search term for regex pattern
		$pattern = '/(' . preg_quote($searchTerm, '/') . ')/i';
		
		// Use preg_replace_callback to highlight matches while preserving case
		$result = preg_replace_callback($pattern, function($matches) {
			return '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">' . e($matches[0]) . '</mark>';
		}, $text);
		
		return $result ?: e($text);
	};
@endphp

@if($posts->count() > 0)
	<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-6" id="blog-articles-grid">
		@foreach($posts as $post)
			<article class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 w-full max-w-full">
				@if($post->valid_image_url)
					<a href="{{ route('blog.show', $post) }}" class="block relative h-36 sm:h-44 md:h-52 lg:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200">
						<img 
							src="{{ $post->valid_image_url }}" 
							alt="{{ $post->title }}"
							class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
							loading="lazy"
						>
						<div class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 md:top-4 md:right-4">
							<span class="inline-flex items-center gap-1 rounded-full bg-white/95 backdrop-blur-sm px-2 py-0.5 sm:px-2.5 sm:py-1 md:px-3 text-[10px] sm:text-xs font-semibold text-emerald-700 shadow-sm">
								{!! $highlightSearch($post->topic, $searchTerm ?? null) !!}
							</span>
						</div>
					</a>
				@else
					<a href="{{ route('blog.show', $post) }}" class="block relative h-36 sm:h-44 md:h-52 lg:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-100">
						<div class="absolute inset-0 flex items-center justify-center">
							<svg class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
							</svg>
						</div>
						<div class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 md:top-4 md:right-4">
							<span class="inline-flex items-center gap-1 rounded-full bg-white/95 backdrop-blur-sm px-2 py-0.5 sm:px-2.5 sm:py-1 md:px-3 text-[10px] sm:text-xs font-semibold text-emerald-700 shadow-sm">
								{!! $highlightSearch($post->topic, $searchTerm ?? null) !!}
							</span>
						</div>
					</a>
				@endif
				
				<div class="p-3.5 sm:p-4 md:p-5 lg:p-6">
					<div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs md:text-sm text-gray-500 mb-2 sm:mb-2.5 md:mb-3">
						<time datetime="{{ $post->published_at->format('Y-m-d') }}">
							{{ $post->published_at->format('M d, Y') }}
						</time>
						<span>•</span>
						<span>{{ $post->read_time }} min read</span>
					</div>
					
					<h2 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-2.5 md:mb-3 group-hover:text-emerald-700 transition-colors line-clamp-2">
						<a href="{{ route('blog.show', $post) }}">{!! $highlightSearch($post->title, $searchTerm ?? null) !!}</a>
					</h2>
					
					@if($post->excerpt)
						<p class="text-gray-600 text-xs sm:text-sm md:text-base mb-2.5 sm:mb-3 md:mb-4 line-clamp-3 leading-relaxed">
							{!! $highlightSearch($post->excerpt, $searchTerm ?? null) !!}
						</p>
					@elseif($post->content)
						<p class="text-gray-600 text-xs sm:text-sm md:text-base mb-2.5 sm:mb-3 md:mb-4 line-clamp-3 leading-relaxed">
							{!! $highlightSearch(\Illuminate\Support\Str::limit(strip_tags($post->content), 150), $searchTerm ?? null) !!}
						</p>
					@endif
					
					<div class="flex items-center justify-between pt-2.5 sm:pt-3 md:pt-4 border-t border-gray-100 gap-2 sm:gap-3 md:gap-4">
						<div class="flex items-center gap-1.5 sm:gap-2 min-w-0 flex-1">
							<div class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
								<span class="text-emerald-700 text-[10px] sm:text-xs font-semibold">{{ substr($post->author, 0, 2) }}</span>
							</div>
							@if($post->doctor)
								<a href="{{ route('blog.author', $post->doctor) }}" class="text-[11px] sm:text-xs md:text-sm text-gray-600 font-medium hover:text-emerald-700 transition-colors truncate">
									{{ $post->author }}
								</a>
							@else
								<span class="text-[11px] sm:text-xs md:text-sm text-gray-600 font-medium truncate">{{ $post->author }}</span>
							@endif
						</div>
						<a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[11px] sm:text-xs md:text-sm font-semibold text-emerald-700 hover:text-emerald-800 group-hover:gap-1.5 sm:group-hover:gap-2 transition-all flex-shrink-0">
							<span class="hidden sm:inline">Read more</span>
							<span class="sm:hidden">Read</span>
							<svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
							</svg>
						</a>
					</div>
				</div>
			</article>
		@endforeach
	</div>
	
	<!-- Pagination -->
	@if($posts->hasPages())
		<div class="mt-8 sm:mt-10" id="blog-pagination">
			{{ $posts->links() }}
		</div>
	@endif
@else
	<div class="text-center py-8 sm:py-12 md:py-16 bg-white rounded-xl sm:rounded-2xl border border-gray-100" id="blog-empty-state">
		<svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 mx-auto text-gray-400 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
		</svg>
		<h3 class="text-lg sm:text-xl md:text-2xl font-semibold text-gray-900 mb-1.5 sm:mb-2">No articles found</h3>
		<p class="text-sm sm:text-base text-gray-600 px-4">Try adjusting your search or filters to find what you're looking for.</p>
	</div>
@endif

