@extends('layouts.app')

@section('title', $post->title . ' - Medical Blog')

@section('breadcrumbs')
	<a href="{{ route('home') }}" class="hover:underline">Home</a>
	<span class="mx-1">/</span>
	<a href="{{ route('blog.index') }}" class="hover:underline">Blog</a>
	<span class="mx-1">/</span>
	<span class="line-clamp-1">{{ $post->title }}</span>
@endsection

@section('content')
<div class="grid gap-6 sm:gap-8">
	<!-- Article Header -->
	<article class="bg-white rounded-2xl sm:rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
		@if($post->image_url)
			<div class="relative h-64 sm:h-80 lg:h-96 overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200">
				<img 
					src="{{ $post->image_url }}" 
					alt="{{ $post->title }}"
					class="w-full h-full object-cover"
					loading="eager"
				>
				<div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
				<div class="absolute top-4 right-4">
					<span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-sm px-4 py-1.5 text-sm font-semibold text-emerald-700 shadow-lg">
						{{ $post->category }}
					</span>
				</div>
			</div>
		@else
			<div class="relative h-64 sm:h-80 lg:h-96 overflow-hidden bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-100">
				<div class="absolute inset-0 flex items-center justify-center">
					<svg class="w-32 h-32 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
					</svg>
				</div>
				<div class="absolute top-4 right-4">
					<span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur-sm px-4 py-1.5 text-sm font-semibold text-emerald-700 shadow-lg">
						{{ $post->category }}
					</span>
				</div>
			</div>
		@endif
		
		<div class="p-6 sm:p-8 lg:p-10">
			<!-- Article Meta -->
			<div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6">
				<div class="flex items-center gap-2">
					<div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
						<span class="text-emerald-700 text-sm font-semibold">{{ substr($post->author, 0, 2) }}</span>
					</div>
					<span class="font-medium text-gray-700">{{ $post->author }}</span>
				</div>
				<span>•</span>
				<time datetime="{{ $post->published_at->format('Y-m-d') }}" class="font-medium">
					{{ $post->published_at->format('F d, Y') }}
				</time>
				<span>•</span>
				<span>{{ $post->read_time }} min read</span>
			</div>
			
			<!-- Article Title -->
			<h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
				{{ $post->title }}
			</h1>
			
			@if($post->excerpt)
				<p class="text-xl text-gray-600 mb-8 leading-relaxed">
					{{ $post->excerpt }}
				</p>
			@endif
			
			<!-- Article Content -->
			<div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-emerald-700 prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:text-gray-700 prose-img:rounded-xl prose-img:shadow-lg">
				{!! $post->content !!}
			</div>
			
			<!-- Article Footer -->
			<div class="mt-10 pt-8 border-t border-gray-200">
				<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
					<div class="flex items-center gap-3">
						<div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
							<span class="text-emerald-700 font-semibold">{{ substr($post->author, 0, 2) }}</span>
						</div>
						<div>
							<p class="font-semibold text-gray-900">{{ $post->author }}</p>
							<p class="text-sm text-gray-500">Medical Professional</p>
						</div>
					</div>
					<a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
						</svg>
						Back to Blog
					</a>
				</div>
			</div>
		</div>
	</article>
	
	<!-- Related Articles Section -->
	@php
		$relatedPosts = \App\Models\BlogPost::where('category', $post->category)
			->where('id', '!=', $post->id)
			->whereNotNull('published_at')
			->where('published_at', '<=', now())
			->orderBy('published_at', 'desc')
			->limit(3)
			->get();
	@endphp
	
	@if($relatedPosts->count() > 0)
		<section class="mt-6 sm:mt-8">
			<div class="flex items-center justify-between mb-6">
				<h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Related Articles</h2>
				<a href="{{ route('blog.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
					View all
				</a>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
				@foreach($relatedPosts as $relatedPost)
					<article class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
						@if($relatedPost->image_url)
							<a href="{{ route('blog.show', $relatedPost) }}" class="block relative h-48 overflow-hidden bg-gradient-to-br from-emerald-100 to-emerald-200">
								<img 
									src="{{ $relatedPost->image_url }}" 
									alt="{{ $relatedPost->title }}"
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								>
							</a>
						@else
							<a href="{{ route('blog.show', $relatedPost) }}" class="block relative h-48 overflow-hidden bg-gradient-to-br from-emerald-100 via-emerald-50 to-teal-100">
								<div class="absolute inset-0 flex items-center justify-center">
									<svg class="w-16 h-16 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
									</svg>
								</div>
							</a>
						@endif
						
						<div class="p-5">
							<div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
								<time datetime="{{ $relatedPost->published_at->format('Y-m-d') }}">
									{{ $relatedPost->published_at->format('M d, Y') }}
								</time>
								<span>•</span>
								<span>{{ $relatedPost->read_time }} min read</span>
							</div>
							
							<h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-700 transition-colors line-clamp-2">
								<a href="{{ route('blog.show', $relatedPost) }}">{{ $relatedPost->title }}</a>
							</h3>
							
							@if($relatedPost->excerpt)
								<p class="text-gray-600 text-sm mb-4 line-clamp-2">
									{{ $relatedPost->excerpt }}
								</p>
							@endif
							
							<a href="{{ route('blog.show', $relatedPost) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-800 group-hover:gap-2 transition-all">
								Read more
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
								</svg>
							</a>
						</div>
					</article>
				@endforeach
			</div>
		</section>
	@endif
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
	.prose {
		color: inherit;
	}
	.prose p {
		margin-top: 1.25em;
		margin-bottom: 1.25em;
	}
	.prose ul, .prose ol {
		margin-top: 1.25em;
		margin-bottom: 1.25em;
		padding-left: 1.625em;
	}
	.prose li {
		margin-top: 0.5em;
		margin-bottom: 0.5em;
	}
	.prose h2 {
		font-size: 1.875em;
		margin-top: 2em;
		margin-bottom: 1em;
		font-weight: 700;
	}
	.prose h3 {
		font-size: 1.5em;
		margin-top: 1.6em;
		margin-bottom: 0.6em;
		font-weight: 600;
	}
	.prose strong {
		font-weight: 600;
	}
</style>
@endsection




