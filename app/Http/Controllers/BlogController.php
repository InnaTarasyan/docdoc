<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Filter by topic if provided
        if ($request->has('topic') && $request->topic) {
            $query->where('topic', $request->topic);
        }

        $posts = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString(); // Preserve query parameters in pagination links

        // Get all unique topics for the filter
        $topics = BlogPost::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('topic')
            ->distinct()
            ->orderBy('topic')
            ->pluck('topic');

        return view('blog.index', compact('posts', 'topics'));
    }

    public function show(BlogPost $post)
    {
        if (!$post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        return view('blog.show', compact('post'));
    }
}
