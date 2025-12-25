@extends('layouts.app')

@section('title', 'Medical Blog - Health Articles & Insights')

@section('content')
<div class="grid gap-4 sm:gap-6 md:gap-8">
	<!-- Hero Section -->
	<section class="relative w-full rounded-xl sm:rounded-2xl overflow-hidden mx-0 sm:mx-0 px-0 sm:px-0 bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950">
		<div class="absolute inset-0 bg-gradient-to-br from-emerald-900/70 via-emerald-900/40 to-emerald-950/70 mix-blend-multiply z-0"></div>
		<div class="absolute inset-0 hidden sm:block pointer-events-none">
			<div class="absolute w-64 h-64 bg-emerald-400/35 blur-3xl rounded-full" style="top: -120px; left: -60px;"></div>
			<div class="absolute w-72 h-72 bg-teal-300/30 blur-3xl rounded-full" style="bottom: -180px; right: -40px;"></div>
		</div>
		<div class="relative z-10 px-4 py-6 sm:py-8 md:py-10 lg:py-12 sm:px-8 md:px-10 text-center">
			<h1 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-3 sm:mb-4 drop-shadow-lg">Medical Blog</h1>
			<p class="text-white/90 text-sm sm:text-base md:text-lg max-w-2xl mx-auto drop-shadow-md px-2 sm:px-0">Expert health insights, medical articles, and wellness tips from healthcare professionals</p>
		</div>
	</section>

	<!-- Topic Filter Section -->
	<section class="mt-4 sm:mt-6 md:mt-8">
		<div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 md:p-6">
			<div class="flex items-center justify-between mb-3 sm:mb-4 md:mb-6">
				<h2 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Explore by Topic</h2>
				<div class="flex items-center gap-2 sm:gap-3">
					@if(request('topic'))
						<a href="{{ route('blog.index') }}" class="text-xs sm:text-sm font-medium text-emerald-700 hover:text-emerald-800 flex items-center gap-1 transition-colors">
							<svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
							</svg>
							<span class="hidden sm:inline">Clear filter</span>
							<span class="sm:hidden">Clear</span>
						</a>
					@endif
					@if(!request('topic'))
						<a href="{{ route('blog.topics') }}" class="text-xs sm:text-sm font-medium text-emerald-700 hover:text-emerald-800 flex items-center gap-1 transition-colors">
							<span>View All</span>
							<svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
							</svg>
						</a>
					@endif
				</div>
			</div>
			
		<!-- Topic Cards: Responsive layout for all devices -->
		<div class="w-full overflow-hidden">
			<!-- Mobile: 2-column grid -->
			<ul class="grid grid-cols-2 sm:hidden gap-2.5 sm:gap-3">
				@php
					$getTopicImage = function($topicName) {
						$topicSlug = strtolower(str_replace([' ', "'"], ['-', ''], $topicName));
						$imagePath = "/img/topics/{$topicSlug}.png";
						$fullPath = public_path($imagePath);
						return file_exists($fullPath) ? asset($imagePath) : null;
					};
				@endphp
				
				<!-- All Topics Card -->
				<li>
					<a href="{{ route('blog.index') }}" 
						class="group block w-full transition-all duration-200 hover:scale-105">
						<div class="relative overflow-hidden rounded-xl bg-gradient-to-br {{ !request('topic') ? 'from-emerald-600 to-emerald-700 ring-2 ring-emerald-500 ring-offset-2' : 'from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300' }} transition-all duration-200 aspect-[4/3] shadow-sm hover:shadow-md">
							@if(!request('topic'))
								<div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700"></div>
							@endif
							<div class="absolute inset-0 flex flex-col items-center justify-center p-3">
								<div class="text-center">
									<span class="text-xs font-semibold {{ !request('topic') ? 'text-white' : 'text-gray-900' }} leading-tight block">
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
					<li>
						<a href="{{ route('blog.index', ['topic' => $topic]) }}" 
							class="group block w-full transition-all duration-200 hover:scale-105">
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
												'cardiology' => 'M21 8.25c0-1.83-1.5-3.33-3.33-3.33-1.5 0-2.83.83-3.5 2.09-.67-1.26-2-2.09-3.5-2.09C8.5 5 7 6.5 7 8.25c0 1.83 1.5 3.33 3.33 3.33.83 0 1.58-.33 2.17-.83L12 12.5l.5-.75c.59.5 1.34.83 2.17.83C16.5 12.58 18 11.08 18 9.25c0-1.83-1.5-3.33-3.33-3.33-1.5 0-2.83.83-3.5 2.09-.67-1.26-2-2.09-3.5-2.09C5.5 5 4 6.5 4 8.25c0 1.83 1.5 3.33 3.33 3.33.83 0 1.58-.33 2.17-.83L12 12.5l2.5-1.75c.59.5 1.34.83 2.17.83C18.5 12.58 21 11.08 21 8.25z',
												'neurology' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
												'dermatology' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.648 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42',
												'pediatrics' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
												'oncology' => 'M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546M5.106 18.894c-3.808-3.808-3.808-9.98 0-13.789m13.788 0c3.808 3.808 3.808 9.981 0 13.79M12 12h.008v.008H12V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
												default => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'
											};
										@endphp
										<svg class="w-10 h-10 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $topicIcon }}"/>
										</svg>
									</div>
								@endif
								<div class="absolute inset-0 flex items-end justify-center p-2">
									<span class="text-xs font-semibold {{ $isActive ? 'text-white drop-shadow-lg' : 'text-gray-900 bg-white/80 backdrop-blur-sm px-2 py-1 rounded' }} leading-tight text-center">
										{{ $topic }}
									</span>
								</div>
							</div>
						</a>
					</li>
				@endforeach
			</ul>
			
			<!-- Tablet: 3-column grid -->
			<ul class="hidden sm:grid md:hidden grid-cols-3 gap-3">
				@php
					$getTopicImage = function($topicName) {
						$topicSlug = strtolower(str_replace([' ', "'"], ['-', ''], $topicName));
						$imagePath = "/img/topics/{$topicSlug}.png";
						$fullPath = public_path($imagePath);
						return file_exists($fullPath) ? asset($imagePath) : null;
					};
				@endphp
				
				<!-- All Topics Card -->
				<li>
					<a href="{{ route('blog.index') }}" 
						class="group block w-full transition-all duration-200 hover:scale-105">
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
					<li>
						<a href="{{ route('blog.index', ['topic' => $topic]) }}" 
							class="group block w-full transition-all duration-200 hover:scale-105">
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
												'cardiology' => 'M21 8.25c0-1.83-1.5-3.33-3.33-3.33-1.5 0-2.83.83-3.5 2.09-.67-1.26-2-2.09-3.5-2.09C8.5 5 7 6.5 7 8.25c0 1.83 1.5 3.33 3.33 3.33.83 0 1.58-.33 2.17-.83L12 12.5l.5-.75c.59.5 1.34.83 2.17.83C16.5 12.58 18 11.08 18 9.25c0-1.83-1.5-3.33-3.33-3.33-1.5 0-2.83.83-3.5 2.09-.67-1.26-2-2.09-3.5-2.09C5.5 5 4 6.5 4 8.25c0 1.83 1.5 3.33 3.33 3.33.83 0 1.58-.33 2.17-.83L12 12.5l2.5-1.75c.59.5 1.34.83 2.17.83C18.5 12.58 21 11.08 21 8.25z',
												'neurology' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
												'dermatology' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.648 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42',
												'pediatrics' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
												'oncology' => 'M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546M5.106 18.894c-3.808-3.808-3.808-9.98 0-13.789m13.788 0c3.808 3.808 3.808 9.981 0 13.79M12 12h.008v.008H12V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
												default => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'
											};
										@endphp
										<svg class="w-10 h-10 sm:w-12 sm:h-12 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
			
			<!-- Desktop: Horizontal scrolling -->
			<div class="hidden md:block overflow-x-auto scrollbar-hide pb-2 -mx-4 md:-mx-6 px-4 md:px-6">
				<ul class="flex gap-3 md:gap-4 lg:gap-5">
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
								class="group block w-[140px] md:w-[150px] lg:w-[160px] transition-all duration-200 hover:scale-105">
								<div class="relative overflow-hidden rounded-xl bg-gradient-to-br {{ !request('topic') ? 'from-emerald-600 to-emerald-700 ring-2 ring-emerald-500 ring-offset-2' : 'from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300' }} transition-all duration-200 aspect-[4/3] shadow-sm hover:shadow-md">
									@if(!request('topic'))
										<div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700"></div>
									@endif
									<div class="absolute inset-0 flex flex-col items-center justify-center p-3 md:p-4">
										<div class="text-center">
											<span class="text-xs md:text-sm font-semibold {{ !request('topic') ? 'text-white' : 'text-gray-900' }} leading-tight block">
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
									class="group block w-[140px] md:w-[150px] lg:w-[160px] transition-all duration-200 hover:scale-105">
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
	<section class="mt-4 sm:mt-6 md:mt-8">
		@if(request('topic'))
			<div class="mb-3 sm:mb-4 md:mb-6">
				<p class="text-gray-600 text-xs sm:text-sm md:text-base">
					Showing articles in <span class="font-semibold text-emerald-700">{{ request('topic') }}</span>
					<span class="text-gray-500">({{ $posts->total() }} {{ Str::plural('article', $posts->total()) }})</span>
				</p>
			</div>
		@endif
		@if($posts->count() > 0)
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
				@foreach($posts as $post)
					<article class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 w-full max-w-full">
						@if($post->image_url)
							<a href="{{ route('blog.show', $post) }}" class="block relative h-36 sm:h-44 md:h-52 lg:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200">
								<img 
									src="{{ $post->image_url }}" 
									alt="{{ $post->title }}"
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								>
								<div class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 md:top-4 md:right-4">
									<span class="inline-flex items-center gap-1 rounded-full bg-white/95 backdrop-blur-sm px-2 py-0.5 sm:px-2.5 sm:py-1 md:px-3 text-[10px] sm:text-xs font-semibold text-emerald-700 shadow-sm">
										{{ $post->topic }}
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
										{{ $post->topic }}
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
								<a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
							</h2>
							
							@if($post->excerpt)
								<p class="text-gray-600 text-xs sm:text-sm md:text-base mb-2.5 sm:mb-3 md:mb-4 line-clamp-3 leading-relaxed">
									{{ $post->excerpt }}
								</p>
							@elseif($post->content)
								<p class="text-gray-600 text-xs sm:text-sm md:text-base mb-2.5 sm:mb-3 md:mb-4 line-clamp-3 leading-relaxed">
									{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}
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
				<div class="mt-8 sm:mt-10">
					{{ $posts->links() }}
				</div>
			@endif
		@else
			<div class="text-center py-8 sm:py-12 md:py-16 bg-white rounded-xl sm:rounded-2xl border border-gray-100">
				<svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 mx-auto text-gray-400 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
				</svg>
				<h3 class="text-lg sm:text-xl md:text-2xl font-semibold text-gray-900 mb-1.5 sm:mb-2">No articles yet</h3>
				<p class="text-sm sm:text-base text-gray-600 px-4">Check back soon for health articles and medical insights.</p>
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

