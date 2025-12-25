@extends('layouts.app')

@section('title', 'Medical Blog - Health Articles & Insights')

@section('content')
<div class="grid gap-6 sm:gap-8">
	<!-- Hero Section -->
	<section class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden mx-0 sm:mx-0 px-0 sm:px-0 bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950">
		<div class="absolute inset-0 bg-gradient-to-br from-emerald-900/70 via-emerald-900/40 to-emerald-950/70 mix-blend-multiply z-0"></div>
		<div class="absolute inset-0 hidden sm:block pointer-events-none">
			<div class="absolute w-64 h-64 bg-emerald-400/35 blur-3xl rounded-full" style="top: -120px; left: -60px;"></div>
			<div class="absolute w-72 h-72 bg-teal-300/30 blur-3xl rounded-full" style="bottom: -180px; right: -40px;"></div>
		</div>
		<div class="relative z-10 px-4 py-8 sm:px-10 sm:py-12 text-center">
			<h1 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Medical Blog</h1>
			<p class="text-white/90 text-base sm:text-lg max-w-2xl mx-auto drop-shadow-md">Expert health insights, medical articles, and wellness tips from healthcare professionals</p>
		</div>
	</section>

	<!-- Topic Filter Section -->
	<section class="mt-6 sm:mt-8">
		<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">
			<div class="flex items-center justify-between mb-4 sm:mb-6">
				<h2 class="text-lg sm:text-xl font-semibold text-gray-900">Explore by Topic</h2>
				<div class="flex items-center gap-3">
					@if(request('topic'))
						<a href="{{ route('blog.index') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800 flex items-center gap-1 transition-colors">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
							</svg>
							<span class="hidden sm:inline">Clear filter</span>
						</a>
					@endif
					@if(!request('topic'))
						<a href="{{ route('blog.topics') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800 flex items-center gap-1 transition-colors">
							<span>View All</span>
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
							</svg>
						</a>
					@endif
				</div>
			</div>
			
			<!-- Horizontal Scrolling Topic Cards -->
			<div class="w-full overflow-hidden">
				<div class="overflow-x-auto scrollbar-hide pb-2 -mx-4 sm:-mx-6 px-4 sm:px-6">
					<ul class="flex gap-3 sm:gap-4">
						@php
							$getTopicImage = function($topicName) {
								$topicSlug = strtolower(str_replace([' ', "'"], ['-', ''], $topicName));
								$imagePath = "/img/topics/{$topicSlug}.png";
								$fullPath = public_path($imagePath);
								return file_exists($fullPath) ? asset($imagePath) : null;
							};
						@endphp
						
						<!-- All Topics Card -->
						<li class="flex-shrink-0">
							<a href="{{ route('blog.index') }}" 
								class="group block w-[140px] transition-all duration-200 hover:scale-105">
								<div class="relative overflow-hidden rounded-xl bg-gradient-to-br {{ !request('topic') ? 'from-emerald-600 to-emerald-700 ring-2 ring-emerald-500 ring-offset-2' : 'from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300' }} transition-all duration-200 aspect-[4/3] shadow-sm hover:shadow-md">
									@if(!request('topic'))
										<div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700"></div>
									@endif
									<div class="absolute inset-0 flex flex-col items-center justify-center p-3">
										<div class="text-center">
											<span class="text-xs sm:text-sm font-semibold {{ !request('topic') ? 'text-white' : 'text-gray-900' }} leading-tight block">
												All Topics
											</span>
										</div>
									</div>
								</div>
							</a>
						</li>
						
						<!-- Topic Cards -->
						@foreach($topics as $topic)
							@php
								$topicImage = $getTopicImage($topic);
								$isActive = request('topic') === $topic;
							@endphp
							<li class="flex-shrink-0">
								<a href="{{ route('blog.index', ['topic' => $topic]) }}" 
									class="group block w-[140px] transition-all duration-200 hover:scale-105">
									<div class="relative overflow-hidden rounded-xl {{ $isActive ? 'ring-2 ring-emerald-500 ring-offset-2' : '' }} transition-all duration-200 aspect-[4/3] shadow-sm hover:shadow-md">
										@if($topicImage)
											<img 
												src="{{ $topicImage }}" 
												alt="{{ $topic }}"
												class="w-full h-full object-cover {{ $isActive ? 'opacity-100' : 'opacity-90 group-hover:opacity-100' }} transition-opacity duration-200"
												loading="lazy"
											>
										@else
											<div class="w-full h-full bg-gradient-to-br {{ $isActive ? 'from-emerald-500 to-emerald-600' : 'from-gray-200 to-gray-300 group-hover:from-gray-300 group-hover:to-gray-400' }} transition-all duration-200 flex items-center justify-center">
												@php
													$topicIcon = match(strtolower($topic)) {
														'cardiology' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
														'neurology' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
														'dermatology' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
														'pediatrics' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
														'oncology' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
														default => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
													};
												@endphp
												<svg class="w-12 h-12 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $topicIcon }}"/>
												</svg>
											</div>
										@endif
										<div class="absolute inset-0 flex items-end justify-center p-2 sm:p-3">
											<span class="text-xs sm:text-sm font-semibold {{ $isActive ? 'text-white drop-shadow-lg' : 'text-gray-900 bg-white/80 backdrop-blur-sm px-2 py-1 rounded' }} leading-tight text-center">
												{{ $topic }}
											</span>
										</div>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- Blog Posts Grid -->
	<section class="mt-6 sm:mt-8">
		@if(request('topic'))
			<div class="mb-6">
				<p class="text-gray-600 text-sm sm:text-base">
					Showing articles in <span class="font-semibold text-emerald-700">{{ request('topic') }}</span>
					<span class="text-gray-500">({{ $posts->total() }} {{ Str::plural('article', $posts->total()) }})</span>
				</p>
			</div>
		@endif
		@if($posts->count() > 0)
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
				@foreach($posts as $post)
					<article class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
						@if($post->image_url)
							<a href="{{ route('blog.show', $post) }}" class="block relative h-48 sm:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200">
								<img 
									src="{{ $post->image_url }}" 
									alt="{{ $post->title }}"
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								>
								<div class="absolute top-4 right-4">
									<span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-emerald-700 shadow-sm">
										{{ $post->topic }}
									</span>
								</div>
							</a>
						@else
							<a href="{{ route('blog.show', $post) }}" class="block relative h-48 sm:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-100">
								<div class="absolute inset-0 flex items-center justify-center">
									<svg class="w-20 h-20 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
									</svg>
								</div>
								<div class="absolute top-4 right-4">
									<span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-emerald-700 shadow-sm">
										{{ $post->topic }}
									</span>
								</div>
							</a>
						@endif
						
						<div class="p-5 sm:p-6">
							<div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-3">
								<time datetime="{{ $post->published_at->format('Y-m-d') }}">
									{{ $post->published_at->format('M d, Y') }}
								</time>
								<span>•</span>
								<span>{{ $post->read_time }} min read</span>
							</div>
							
							<h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 group-hover:text-emerald-700 transition-colors line-clamp-2">
								<a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
							</h2>
							
							@if($post->excerpt)
								<p class="text-gray-600 text-sm sm:text-base mb-4 line-clamp-3 leading-relaxed">
									{{ $post->excerpt }}
								</p>
							@elseif($post->content)
								<p class="text-gray-600 text-sm sm:text-base mb-4 line-clamp-3 leading-relaxed">
									{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}
								</p>
							@endif
							
							<div class="flex items-center justify-between pt-4 border-t border-gray-100">
								<div class="flex items-center gap-2">
									<div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
										<span class="text-emerald-700 text-xs font-semibold">{{ substr($post->author, 0, 2) }}</span>
									</div>
									@if($post->doctor)
										<a href="{{ route('blog.author', $post->doctor) }}" class="text-sm text-gray-600 font-medium hover:text-emerald-700 transition-colors">
											{{ $post->author }}
										</a>
									@else
										<span class="text-sm text-gray-600 font-medium">{{ $post->author }}</span>
									@endif
								</div>
								<a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800 group-hover:gap-2 transition-all">
									Read more
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
				<div class="mt-8 sm:mt-10">
					{{ $posts->links() }}
				</div>
			@endif
		@else
			<div class="text-center py-12 sm:py-16 bg-white rounded-2xl border border-gray-100">
				<svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
				</svg>
				<h3 class="text-xl font-semibold text-gray-900 mb-2">No articles yet</h3>
				<p class="text-gray-600">Check back soon for health articles and medical insights.</p>
			</div>
		@endif
	</section>
</div>

<style>
	.line-clamp-2 {
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}
	.line-clamp-3 {
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}
	
	/* Hide scrollbar for Chrome, Safari and Opera */
	.scrollbar-hide::-webkit-scrollbar {
		display: none;
	}
	
	/* Hide scrollbar for IE, Edge and Firefox */
	.scrollbar-hide {
		-ms-overflow-style: none;  /* IE and Edge */
		scrollbar-width: none;  /* Firefox */
	}
	
	/* Smooth scrolling */
	.scrollbar-hide {
		scroll-behavior: smooth;
		-webkit-overflow-scrolling: touch;
	}
</style>
@endsection

