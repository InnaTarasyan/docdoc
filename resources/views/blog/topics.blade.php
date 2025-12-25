@extends('layouts.app')

@section('title', 'All Topics - Medical Blog')

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
			<h1 class="text-white text-3xl sm:text-4xl md:text-5xl font-bold mb-4 drop-shadow-lg">Explore All Topics</h1>
			<p class="text-white/90 text-base sm:text-lg max-w-2xl mx-auto drop-shadow-md">Browse health articles and medical insights by topic</p>
		</div>
	</section>

	<!-- All Topics Grid -->
	<section class="mt-6 sm:mt-8">
		<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 lg:p-8">
			<div class="mb-6 sm:mb-8">
				<h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Browse by Topic</h2>
				<p class="text-gray-600 text-sm sm:text-base">Discover articles organized by health topics</p>
			</div>

			@php
				$getTopicImage = function($topicName) {
					$topicSlug = strtolower(str_replace([' ', "'"], ['-', ''], $topicName));
					$imagePath = "/img/topics/{$topicSlug}.png";
					$fullPath = public_path($imagePath);
					return file_exists($fullPath) ? asset($imagePath) : null;
				};

				$getTopicIcon = function($topic) {
					return match(strtolower($topic)) {
						'cardiology', 'heart' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
						'neurology', 'brain' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
						'dermatology', 'skin' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
						'pediatrics', 'child' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
						'oncology', 'cancer' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
						'orthopedics', 'bone' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
						'gynecology', 'women' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
						'psychiatry', 'mental' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
						'endocrinology', 'hormone' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
						'gastroenterology', 'stomach' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
						'ophthalmology', 'eye' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
						'urology', 'kidney' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
						'pulmonology', 'lung' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
						'rheumatology', 'joint' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4',
						default => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
					};
				};
			@endphp

			@if($topics->count() > 0)
				<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 md:gap-5">
					@foreach($topics as $topicData)
						@php
							$topic = $topicData->topic;
							$postCount = $topicData->post_count;
							$topicImage = $getTopicImage($topic);
							$topicIcon = $getTopicIcon($topic);
						@endphp
						<a href="{{ route('blog.index', ['topic' => $topic]) }}" 
							class="group block transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 rounded-xl">
							<div class="relative overflow-hidden rounded-xl transition-all duration-200 aspect-[4/3] shadow-sm hover:shadow-lg bg-gradient-to-br from-gray-50 to-gray-100">
								@if($topicImage)
									<img 
										src="{{ $topicImage }}" 
										alt="{{ $topic }}"
										class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity duration-200"
										loading="lazy"
									>
								@else
									<div class="w-full h-full bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-100 group-hover:from-emerald-200 group-hover:via-emerald-100 group-hover:to-teal-200 transition-all duration-200 flex items-center justify-center">
										<svg class="w-10 h-10 sm:w-12 sm:h-12 text-emerald-600 opacity-70 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $topicIcon }}"/>
										</svg>
									</div>
								@endif
								
								<!-- Overlay gradient for better text readability -->
								<div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
								
								<!-- Topic name and count -->
								<div class="absolute inset-0 flex flex-col items-center justify-end p-2 sm:p-3">
									<div class="text-center w-full">
										<span class="text-xs sm:text-sm font-semibold text-gray-900 bg-white/95 backdrop-blur-sm px-2 py-1.5 rounded-md leading-tight block shadow-sm">
											{{ $topic }}
										</span>
										@if($postCount > 0)
											<span class="text-[10px] sm:text-xs text-gray-600 mt-1.5 block">
												{{ $postCount }} {{ Str::plural('article', $postCount) }}
											</span>
										@endif
									</div>
								</div>
							</div>
						</a>
					@endforeach
				</div>
			@else
				<div class="text-center py-12 sm:py-16">
					<svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
					</svg>
					<h3 class="text-xl font-semibold text-gray-900 mb-2">No topics available</h3>
					<p class="text-gray-600">Check back soon for health topics and articles.</p>
				</div>
			@endif

			<!-- Back to Blog Link -->
			<div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-gray-200">
				<a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-emerald-700 hover:text-emerald-800 font-medium transition-colors">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
					</svg>
					<span>Back to Blog</span>
				</a>
			</div>
		</div>
	</section>
</div>
@endsection

