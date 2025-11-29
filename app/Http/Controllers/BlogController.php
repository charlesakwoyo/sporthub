<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['user', 'category'])
            ->published()
            ->latest('published_at');

        // Search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category')) {
            $query->where('blog_category_id', $request->input('category'));
        }

        $posts = $query->paginate(9);
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])->get();

        // Get popular posts (most viewed in the last 30 days)
        $popularPosts = Blog::where('published_at', '>=', now()->subDays(30))
            ->where('is_published', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('blogs.index', compact('posts', 'categories', 'popularPosts'));
    }

    public function show(Blog $blog)
    {
        // Increment view count
        $blog->increment('views');
        
        // Get related posts
        $relatedPosts = Blog::where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blogs.show', compact('blog', 'relatedPosts'));
    }

    public function category(BlogCategory $category)
    {
        $posts = $category->posts()
            ->with('user')
            ->published()
            ->latest('published_at')
            ->paginate(9);

        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->published();
        }])->get();

        $popularPosts = Blog::where('published_at', '>=', now()->subDays(30))
            ->where('is_published', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('blogs.category', compact('category', 'posts', 'categories', 'popularPosts'));
    }
}
