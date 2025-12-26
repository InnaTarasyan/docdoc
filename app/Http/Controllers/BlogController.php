<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Doctor;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('doctor')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Filter by topic if provided
        if ($request->has('topic') && $request->topic) {
            $query->where('topic', $request->topic);
        }

        // Search query filter
        if ($request->has('q') && $request->q) {
            $searchTerm = trim($request->q);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('excerpt', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->orWhere('topic', 'like', '%' . $searchTerm . '%');
            });
        }

        $posts = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString(); // Preserve query parameters in pagination links

        // Get only first 5 unique topics for the filter
        $topics = BlogPost::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('topic')
            ->distinct()
            ->orderBy('topic')
            ->limit(5)
            ->pluck('topic');

        // If AJAX request, return JSON with HTML
        if ($request->wantsJson() || $request->ajax()) {
            $html = view('blog._articles', compact('posts'))->render();
            
            // Build URL with query parameters
            $url = url()->current();
            $queryParams = $request->only(['q', 'topic', 'page']);
            if (!empty($queryParams)) {
                $url .= '?' . http_build_query(array_filter($queryParams));
            }

            return response()->json([
                'html' => $html,
                'url' => $url,
            ]);
        }

        return view('blog.index', compact('posts', 'topics'));
    }

    /**
     * Show all topics page (similar to healthline.com/wellness)
     */
    public function topics()
    {
        // Get all unique topics with post counts
        $topics = BlogPost::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('topic')
            ->select('topic')
            ->selectRaw('COUNT(*) as post_count')
            ->groupBy('topic')
            ->orderBy('topic')
            ->get();

        return view('blog.topics', compact('topics'));
    }

    public function show(BlogPost $post)
    {
        if (!$post->published_at || $post->published_at->isFuture()) {
            abort(404);
        }

        $post->load('doctor');

        return view('blog.show', compact('post'));
    }

    /**
     * Show all blog posts by a specific doctor author.
     * Similar to: https://www.vsevrachizdes.ru/blog/authors/lukankina-irina-aleksandrovna
     */
    public function author(Doctor $doctor)
    {
        $posts = $doctor->blogPosts()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('blog.author', compact('doctor', 'posts'));
    }
}
