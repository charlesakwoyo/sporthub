@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Latest Blog Posts</h1>
            <p class="text-xl text-gray-600">Discover the latest news, tips, and insights</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <!-- Search and Filter -->
                <div class="mb-8 bg-white rounded-lg shadow-sm p-4">
                    <form action="{{ route('blogs.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Search posts..." 
                                   value="{{ request('search') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="w-full sm:w-48">
                            <select name="category" 
                                    onchange="this.form.submit()"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->published_posts_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Blog Posts Grid -->
                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="h-48 overflow-hidden">
                                    @if($post->featured_image && Storage::disk('public')->exists($post->featured_image))
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                             alt="{{ $post->title }}"
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400">No Image Available</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->reading_time }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                    <h2 class="text-xl font-bold mb-2 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('blogs.show', $post) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('blogs.category', $post->category) }}" 
                                           class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                            {{ $post->category->name }}
                                        </a>
                                        <a href="{{ route('blogs.show', $post) }}" 
                                           class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                            Read More →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No posts found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-6">
                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-100">Categories</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('blogs.index') }}" 
                               class="flex justify-between items-center px-3 py-2 rounded-lg {{ !request('category') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50' }}">
                                <span>All Categories</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                    {{ \App\Models\Blog::published()->count() }}
                                </span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blogs.index', ['category' => $category->id]) }}"
                                   class="flex justify-between items-center px-3 py-2 rounded-lg {{ request('category') == $category->id ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                        {{ $category->published_posts_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Popular Posts -->
                @if($popularPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-100">Popular Posts</h2>
                        <div class="space-y-4">
                            @foreach($popularPosts as $post)
                                <a href="{{ route('blogs.show', $post) }}" class="group flex items-start space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors">
                                    @if($post->featured_image)
                                        <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded">
                                            @if($post->featured_image && Storage::disk('public')->exists($post->featured_image))
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                                     alt="{{ $post->title }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-xs text-gray-400">No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                                        </h3>
                                        <div class="text-sm text-gray-500">
                                            {{ $post->published_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Newsletter -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-2">Subscribe to our newsletter</h2>
                    <p class="text-sm text-gray-600 mb-4">Get the latest posts delivered right to your inbox.</p>
                    <form class="space-y-3">
                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <input id="email" name="email" type="email" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Enter your email">
                        </div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .pagination {
        @apply flex justify-center space-x-2 mt-8;
    }
    .pagination .page-item {
        @apply inline-flex;
    }
    .pagination .page-link {
        @apply px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-md hover:bg-gray-50;
    }
    .pagination .active .page-link {
        @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700;
    }
    .pagination .disabled .page-link {
        @apply bg-gray-100 text-gray-400 cursor-not-allowed hover:bg-gray-100;
    }
</style>
@endpush
