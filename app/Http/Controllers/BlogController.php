<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            if (!empty($searchTerm)) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
//                        ->orWhere('excerpt', 'like', '%' . $searchTerm . '%')
//                        ->orWhere('content', 'like', '%' . $searchTerm . '%')
//                        ->orWhere('author', 'like', '%' . $searchTerm . '%')
                        ->orWhere('topic', 'like', '%' . $searchTerm . '%');
                });
            }
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

        // Get search term for highlighting
        $searchTerm = $request->has('q') && $request->q ? trim($request->q) : null;

        // If AJAX request, return JSON with HTML
        if ($request->wantsJson() || $request->ajax()) {
            try {
                $html = view('blog._articles', compact('posts', 'searchTerm'))->render();
                
                // Build URL with query parameters (filter out empty values)
                $url = url()->current();
                $queryParams = [];
                if ($request->has('q') && trim($request->q)) {
                    $queryParams['q'] = trim($request->q);
                }
                if ($request->has('topic') && $request->topic) {
                    $queryParams['topic'] = $request->topic;
                }
                if ($request->has('page') && $request->page > 1) {
                    $queryParams['page'] = $request->page;
                }
                if (!empty($queryParams)) {
                    $url .= '?' . http_build_query($queryParams);
                }

                return response()->json([
                    'html' => $html,
                    'url' => $url,
                ]);
            } catch (\Exception $e) {
                \Log::error('Blog search error: ' . $e->getMessage());
                return response()->json([
                    'html' => '<div class="text-center py-8"><p class="text-red-600">An error occurred while searching. Please try again.</p></div>',
                    'url' => url()->current(),
                ], 500);
            }
        }

        return view('blog.index', compact('posts', 'topics', 'searchTerm'));
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
