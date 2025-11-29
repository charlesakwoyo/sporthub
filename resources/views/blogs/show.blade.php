@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        <!-- Featured Image -->
        @if($blog->featured_image)
            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                 alt="{{ $blog->title }}" 
                 class="w-full h-96 object-cover rounded-lg mb-8">
        @endif

        <!-- Post Header -->
        <header class="mb-8">
            <h1 class="text-4xl font-bold mb-2">{{ $blog->title }}</h1>
            <div class="flex items-center text-gray-500 text-sm mb-4">
                <span>Posted on {{ $blog->published_at->format('F d, Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ $blog->category->name ?? 'Uncategorized' }}</span>
                <span class="mx-2">•</span>
                <span>{{ $blog->views }} {{ Str::plural('view', $blog->views) }}</span>
            </div>
        </header>

        <!-- Post Content -->
        <div class="prose max-w-none mb-12">
            {!! $blog->content !!}
        </div>

        <!-- Post Footer -->
        <footer class="border-t border-gray-200 pt-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ $blog->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($blog->user->name) }}" 
                         alt="{{ $blog->user->name }}" 
                         class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <div class="font-medium">{{ $blog->user->name }}</div>
                        <div class="text-sm text-gray-500">Author</div>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <!-- Add social sharing buttons here if needed -->
                </div>
            </div>
        </footer>
    </article>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-6">You might also like</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($related->featured_image)
                            <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                 alt="{{ $related->title }}" 
                                 class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2">
                                {{ $related->published_at->format('M d, Y') }}
                            </div>
                            <h3 class="text-xl font-bold mb-2">
                                <a href="{{ route('blogs.show', $related) }}" class="hover:text-blue-600">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600">{{ \Illuminate\Support\Str::limit($related->excerpt, 100) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection