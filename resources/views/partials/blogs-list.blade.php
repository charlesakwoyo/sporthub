@foreach($latestBlogs as $blog)
<article class="blog-card bg-white rounded-xl overflow-hidden shadow-md">
    <a href="{{ route('blogs.show', $blog->slug) }}">
        <img src="{{ $blog->image_url }}" 
             alt="{{ $blog->title }}" 
             class="w-full h-48 object-cover">
    </a>
    <div class="p-6">
        <div class="flex items-center text-sm text-gray-500 mb-3">
            <span>{{ $blog->created_at->format('M d, Y') }}</span>
            <span class="mx-2">•</span>
            <span>{{ $blog->read_time ?? '3' }} min read</span>
        </div>
        <h3 class="text-xl font-bold mb-3">
            <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-blue-600">{{ $blog->title }}</a>
        </h3>
        <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 150) }}</p>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ $blog->author->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($blog->author->name ?? 'Admin') . '&color=7F9CF5&background=EBF4FF' }}" 
                     alt="{{ $blog->author->name ?? 'Admin' }}" 
                     class="w-8 h-8 rounded-full mr-2 object-cover">
                <span class="text-sm font-medium">{{ $blog->author->name ?? 'Admin' }}</span>
            </div>
            <div class="flex items-center text-gray-500 text-sm">
                <i class="far fa-comment-alt mr-1"></i>
                <span>{{ $blog->comments_count ?? 0 }}</span>
            </div>
        </div>
    </div>
</article>
@endforeach
