@extends('layouts.app')

@section('title', $doctor->name . ' - Author Articles')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<a href="{{ route('blog.index') }}" class="hover:underline">Blog</a>
	<span class="mx-1">/</span>
	<span class="line-clamp-1">{{ $doctor->name }}</span>
@endsection

@section('content')
<div class="grid gap-6 sm:gap-8">
	<!-- Author Header Section -->
	<section class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
		<div class="bg-gradient-to-br from-emerald-50 via-emerald-100/50 to-teal-50 px-4 py-6 sm:px-8 sm:py-10">
			<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
				<!-- Avatar -->
				<div class="relative shrink-0">
					@php
						$initials = '';
						$nameParts = explode(' ', $doctor->name);
						if (count($nameParts) >= 2) {
							$initials = substr($nameParts[1], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1);
						} else {
							$initials = substr($doctor->name, 0, 2);
						}
						$avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($doctor->name) . '&size=120&background=10b981&color=fff&bold=true&font-size=0.5';
					@endphp
					<img 
						src="{{ $avatarUrl }}" 
						alt="{{ $doctor->name }}"
						class="w-20 h-20 sm:w-24 sm:h-24 rounded-full ring-4 ring-white shadow-lg object-cover"
						loading="eager"
					>
				</div>
				
				<!-- Author Info -->
				<div class="flex-1 min-w-0">
					<h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2 sm:mb-3">
						{{ $doctor->name }}
					</h1>
					@if($doctor->taxonomy)
						<p class="text-base sm:text-lg text-emerald-700 font-semibold mb-2 sm:mb-3">
							{{ $doctor->taxonomy }}
						</p>
					@endif
					@if($doctor->city || $doctor->state)
						<div class="flex items-center gap-2 text-sm sm:text-base text-gray-600 mb-3 sm:mb-4">
							<svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
								<circle cx="12" cy="9" r="2.5"/>
							</svg>
							<span>{{ $doctor->city ?: '—' }}{{ $doctor->state ? ', ' . $doctor->state : '' }}</span>
						</div>
					@endif
					<div class="flex flex-wrap items-center gap-3 sm:gap-4 text-sm sm:text-base text-gray-600">
						<div class="flex items-center gap-2">
							<svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
							</svg>
							<span class="font-medium">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Articles Section -->
	<section class="mt-6 sm:mt-8">
		@if($posts->count() > 0)
			<div class="mb-4 sm:mb-6">
				<h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
					Articles by {{ $doctor->name }}
				</h2>
				<p class="text-sm sm:text-base text-gray-600 mt-1 sm:mt-2">
					Showing {{ $posts->count() }} of {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}
				</p>
			</div>
			
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
				@foreach($posts as $post)
					<article class="group bg-white rounded-xl sm:rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
						@if($post->image_url)
							<a href="{{ route('blog.show', $post) }}" class="block relative h-48 sm:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200">
								<img 
									src="{{ $post->image_url }}" 
									alt="{{ $post->title }}"
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								>
								<div class="absolute top-3 right-3 sm:top-4 sm:right-4">
									<span class="inline-flex items-center gap-1 rounded-full bg-white/95 backdrop-blur-sm px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-semibold text-emerald-700 shadow-sm">
										{{ $post->topic }}
									</span>
								</div>
							</a>
						@else
							<a href="{{ route('blog.show', $post) }}" class="block relative h-48 sm:h-56 overflow-hidden bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-100">
								<div class="absolute inset-0 flex items-center justify-center">
									<svg class="w-16 h-16 sm:w-20 sm:h-20 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
									</svg>
								</div>
								<div class="absolute top-3 right-3 sm:top-4 sm:right-4">
									<span class="inline-flex items-center gap-1 rounded-full bg-white/95 backdrop-blur-sm px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-semibold text-emerald-700 shadow-sm">
										{{ $post->topic }}
									</span>
								</div>
							</a>
						@endif
						
						<div class="p-4 sm:p-5 lg:p-6">
							<div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-2 sm:mb-3">
								<time datetime="{{ $post->published_at->format('Y-m-d') }}">
									{{ $post->published_at->format('M d, Y') }}
								</time>
								<span>•</span>
								<span>{{ $post->read_time }} min read</span>
							</div>
							
							<h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-emerald-700 transition-colors line-clamp-2">
								<a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
							</h3>
							
							@if($post->excerpt)
								<p class="text-gray-600 text-sm sm:text-base mb-3 sm:mb-4 line-clamp-3 leading-relaxed">
									{{ $post->excerpt }}
								</p>
							@elseif($post->content)
								<p class="text-gray-600 text-sm sm:text-base mb-3 sm:mb-4 line-clamp-3 leading-relaxed">
									{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}
								</p>
							@endif
							
							<a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-1 sm:gap-1.5 text-sm sm:text-base font-semibold text-emerald-700 hover:text-emerald-800 group-hover:gap-2 transition-all">
								Read more
								<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
								</svg>
							</a>
						</div>
					</article>
				@endforeach
			</div>
			
			<!-- Pagination -->
			@if($posts->hasPages())
				<div class="mt-6 sm:mt-8">
					{{ $posts->links() }}
				</div>
			@endif
		@else
			<div class="text-center py-12 sm:py-16 bg-white rounded-xl sm:rounded-2xl border border-gray-100">
				<svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
				</svg>
				<h3 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-2">No articles yet</h3>
				<p class="text-gray-600 text-sm sm:text-base">This author hasn't published any articles yet.</p>
				<div class="mt-6">
					<a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm sm:text-base font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
						<svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
						</svg>
						Back to Blog
					</a>
				</div>
			</div>
		@endif
	</section>
</div>

<style>
	.line-clamp-1 {
		display: -webkit-box;
		-webkit-line-clamp: 1;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}
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
</style>
@endsection
