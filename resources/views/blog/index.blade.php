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
												'cardiology' => 'M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z',
												'neurology' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
												'dermatology' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.648 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42',
												'pediatrics' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
												'oncology' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
												'orthopedics' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
												'gynecology' => 'M12 2.25a.75.75 0 01.75.75v.756a49.106 49.106 0 019.152 1 .75.75 0 01-.152 1.485h-1.918l2.474 10.124a.75.75 0 01-.375.84A6.721 6.721 0 0118.75 18a6.721 6.721 0 01-3.181-.795.75.75 0 01-.375-.84l2.474-10.124H12.75v13.28c1.293.076 2.534.343 3.697.776a.75.75 0 01-.262 1.453h-8.37a.75.75 0 01-.262-1.453c1.162-.433 2.404-.7 3.697-.775V6.24H6.332l2.474 10.124a.75.75 0 01-.375.84A6.721 6.721 0 015.25 18a6.721 6.721 0 01-3.181-.795.75.75 0 01-.375-.84L3.768 6.882H1.918a.75.75 0 01-.152-1.485 49.105 49.105 0 019.152-1V3a.75.75 0 01.75-.75zm6.364 13.522a.75.75 0 01.636.744c.069.557-.079 1.188-.462 1.767a.75.75 0 11-1.197-.9c.24-.32.373-.686.4-1.05zm-12.728 0a.75.75 0 01.636.744c.069.557-.079 1.188-.462 1.767a.75.75 0 11-1.197-.9c.24-.32.373-.686.4-1.05z',
												'psychiatry' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z',
												'endocrinology' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
												'gastroenterology' => 'M12 3c-1.5 0-3 .5-4 1.5C7 3.5 6 3 4.5 3c-1.5 0-3 .5-4 1.5v12c1-.5 2.5-1.5 4-1.5 1.5 0 2.5.5 3.5 1.5 1-1 2-1.5 3.5-1.5 1.5 0 3 1 4 1.5V4.5c-1-.5-2.5-1.5-4-1.5z',
												'ophthalmology' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
												'urology' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6.75 6.75h.008v.008H6.75V6.75z',
												'pulmonology' => 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.224 48.224 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L18.75 4.971zm-16.5 0a6.226 6.226 0 013 .52m-3 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L5.25 4.971z',
												'rheumatology' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
												default => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'
											};
										@endphp
										@php
											$filledIcons = ['cardiology', 'heart', 'urology', 'kidney'];
											$isFilled = in_array(strtolower($topic), $filledIcons);
										@endphp
										@if($isFilled)
											<svg class="w-10 h-10 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-70 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
												<path d="{{ $topicIcon }}"/>
											</svg>
										@else
											<svg class="w-10 h-10 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topicIcon }}"/>
											</svg>
										@endif
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
												'cardiology' => 'M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z',
												'neurology' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
												'dermatology' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.648 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42',
												'pediatrics' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
												'oncology' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
												'orthopedics' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
												'gynecology' => 'M12 2.25a.75.75 0 01.75.75v.756a49.106 49.106 0 019.152 1 .75.75 0 01-.152 1.485h-1.918l2.474 10.124a.75.75 0 01-.375.84A6.721 6.721 0 0118.75 18a6.721 6.721 0 01-3.181-.795.75.75 0 01-.375-.84l2.474-10.124H12.75v13.28c1.293.076 2.534.343 3.697.776a.75.75 0 01-.262 1.453h-8.37a.75.75 0 01-.262-1.453c1.162-.433 2.404-.7 3.697-.775V6.24H6.332l2.474 10.124a.75.75 0 01-.375.84A6.721 6.721 0 015.25 18a6.721 6.721 0 01-3.181-.795.75.75 0 01-.375-.84L3.768 6.882H1.918a.75.75 0 01-.152-1.485 49.105 49.105 0 019.152-1V3a.75.75 0 01.75-.75zm6.364 13.522a.75.75 0 01.636.744c.069.557-.079 1.188-.462 1.767a.75.75 0 11-1.197-.9c.24-.32.373-.686.4-1.05zm-12.728 0a.75.75 0 01.636.744c.069.557-.079 1.188-.462 1.767a.75.75 0 11-1.197-.9c.24-.32.373-.686.4-1.05z',
												'psychiatry' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z',
												'endocrinology' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
												'gastroenterology' => 'M12 3c-1.5 0-3 .5-4 1.5C7 3.5 6 3 4.5 3c-1.5 0-3 .5-4 1.5v12c1-.5 2.5-1.5 4-1.5 1.5 0 2.5.5 3.5 1.5 1-1 2-1.5 3.5-1.5 1.5 0 3 1 4 1.5V4.5c-1-.5-2.5-1.5-4-1.5z',
												'ophthalmology' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
												'urology' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6.75 6.75h.008v.008H6.75V6.75z',
												'pulmonology' => 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.224 48.224 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L18.75 4.971zm-16.5 0a6.226 6.226 0 013 .52m-3 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L5.25 4.971z',
												'rheumatology' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
												default => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'
											};
										@endphp
										@if(strtolower($topic) === 'cardiology')
											<svg class="w-10 h-10 sm:w-12 sm:h-12 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-70 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
												<path d="{{ $topicIcon }}"/>
											</svg>
										@else
											<svg class="w-10 h-10 sm:w-12 sm:h-12 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topicIcon }}"/>
											</svg>
										@endif
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
														'cardiology' => 'M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z',
														'neurology' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
														'dermatology' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.648 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42',
														'pediatrics' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
														'oncology' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
														'orthopedics' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
														'gynecology' => 'M12 2.25a.75.75 0 01.75.75v.756a49.106 49.106 0 019.152 1 .75.75 0 01-.152 1.485h-1.918l2.474 10.124a.75.75 0 01-.375.84A6.721 6.721 0 0118.75 18a6.721 6.721 0 01-3.181-.795.75.75 0 01-.375-.84l2.474-10.124H12.75v13.28c1.293.076 2.534.343 3.697.776a.75.75 0 01-.262 1.453h-8.37a.75.75 0 01-.262-1.453c1.162-.433 2.404-.7 3.697-.775V6.24H6.332l2.474 10.124a.75.75 0 01-.375.84A6.721 6.721 0 015.25 18a6.721 6.721 0 01-3.181-.795.75.75 0 01-.375-.84L3.768 6.882H1.918a.75.75 0 01-.152-1.485 49.105 49.105 0 019.152-1V3a.75.75 0 01.75-.75zm6.364 13.522a.75.75 0 01.636.744c.069.557-.079 1.188-.462 1.767a.75.75 0 11-1.197-.9c.24-.32.373-.686.4-1.05zm-12.728 0a.75.75 0 01.636.744c.069.557-.079 1.188-.462 1.767a.75.75 0 11-1.197-.9c.24-.32.373-.686.4-1.05z',
														'psychiatry' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z',
														'endocrinology' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
														'gastroenterology' => 'M12 3c-1.5 0-3 .5-4 1.5C7 3.5 6 3 4.5 3c-1.5 0-3 .5-4 1.5v12c1-.5 2.5-1.5 4-1.5 1.5 0 2.5.5 3.5 1.5 1-1 2-1.5 3.5-1.5 1.5 0 3 1 4 1.5V4.5c-1-.5-2.5-1.5-4-1.5z',
														'ophthalmology' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
														'urology' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6.75 6.75h.008v.008H6.75V6.75z',
														'pulmonology' => 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.224 48.224 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L18.75 4.971zm-16.5 0a6.226 6.226 0 013 .52m-3 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L5.25 4.971z',
														'rheumatology' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
														default => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'
													};
												@endphp
												@php
													$filledIcons = ['cardiology', 'heart', 'urology', 'kidney'];
													$isFilled = in_array(strtolower($topic), $filledIcons);
												@endphp
												@if($isFilled)
													<svg class="w-12 h-12 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-70 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
														<path d="{{ $topicIcon }}"/>
													</svg>
												@else
													<svg class="w-12 h-12 {{ $isActive ? 'text-white' : 'text-gray-500' }} opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $topicIcon }}"/>
													</svg>
												@endif
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

