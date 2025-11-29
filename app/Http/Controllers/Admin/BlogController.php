<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Blog::with(['category', 'author', 'tags'])
            ->latest()
            ->paginate(15);

        return view('admin.blogs.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = BlogCategory::all();
        $tags = Tag::all();

        return view('admin.blogs.create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'required|string|max:500',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Generate slug from title
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['author_id'] = Auth::id();

        // Set published_at if not set and post is published
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs/featured', 'public');
        }

        // Create the blog post
        $post = Blog::create($validated);

        // Sync tags
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.blogs.show', $post->id)
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog post.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $post = Blog::with(['category', 'author', 'tags', 'comments'])
            ->findOrFail($id);

        return view('admin.blogs.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified blog post.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        $tags = Tag::all();
        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('admin.blogs.edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'selectedTags' => $selectedTags,
        ]);
    }

    /**
     * Update the specified blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $post = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'required|string|max:500',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Generate slug from title if it has changed
        if ($post->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $post->id);
        }

        // Handle published_at
        if ($validated['is_published'] && !$post->published_at) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs/featured', 'public');
        }

        // Update the blog post
        $post->update($validated);

        // Sync tags
        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('admin.blogs.show', $post->id)
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Blog::findOrFail($id);

        // Delete featured image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        // Detach tags
        $post->tags()->detach();

        // Delete comments
        $post->comments()->delete();

        $post->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Toggle blog post status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id)
    {
        $post = Blog::findOrFail($id);
        $post->is_published = !$post->is_published;
        
        // Set published_at if publishing for the first time
        if ($post->is_published && !$post->published_at) {
            $post->published_at = now();
        }
        
        $post->save();

        return response()->json([
            'success' => true,
            'is_published' => $post->is_published,
            'message' => 'Blog post status updated successfully!'
        ]);
    }

    /**
     * Generate a unique slug for the blog post.
     *
     * @param  string  $title
     * @param  int|null  $id
     * @return string
     */
    protected function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = 1;
        $originalSlug = $slug;

        while (Blog::where('slug', $slug)
            ->when($id, function($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
