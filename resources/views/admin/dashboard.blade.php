@extends('layouts.admin')

@section('title', 'Admin Dashboard - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Total Users</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['totalUsers'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Total Events</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['totalEvents'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Blog Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Blog Posts</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['totalBlogs'] }}</p>
                </div>
            </div>
        </div>

        <!-- Unread Messages -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 dark:text-gray-300 text-sm font-medium">Unread Messages</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['unreadMessages'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Users</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentUsers as $user)
                <div class="px-6 py-4 flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <span class="text-gray-500 dark:text-gray-300 font-medium">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                    <div class="ml-auto text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
                @empty
                <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No users found
                </div>
                @endforelse
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    View all users
                </a>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Upcoming Events</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($upcomingEvents as $event)
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-md p-2">
                            <span class="text-blue-600 dark:text-blue-300 font-medium text-sm">
                                {{ $event->start_datetime->format('M') }}
                            </span>
                            <div class="text-center text-blue-800 dark:text-blue-200 font-bold">
                                {{ $event->start_datetime->format('d') }}
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $event->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $event->category ? $event->category->name : 'Uncategorized' }}
                            </p>
                        </div>
                        <div class="ml-auto">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">
                                {{ $event->start_datetime->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No upcoming events
                </div>
                @endforelse
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    View all events
                </a>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Blog Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Blog Posts</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentBlogs as $blog)
                <div class="px-6 py-4">
                    <div class="flex items-start">
                        @if($blog->featured_image)
                        <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden">
                            <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover">
                        </div>
                        @endif
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $blog->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                By {{ $blog->author->name }} • {{ $blog->created_at->diffForHumans() }}
                            </p>
                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $blog->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No blog posts found
                </div>
                @endforelse
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.blogs.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    View all blog posts
                </a>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Messages</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentMessages as $message)
                <div class="px-6 py-4">
                    <div class="flex justify-between">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $message->name }}
                            @if($message->user)
                                <span class="text-xs text-gray-500 dark:text-gray-400">(Registered User)</span>
                            @endif
                        </p>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        {{ Str::limit($message->message, 100) }}
                    </p>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $message->email }}
                        </span>
                        @if(!$message->is_read)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                            New
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No messages found
                </div>
                @endforelse
            </div>
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    View all messages
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
