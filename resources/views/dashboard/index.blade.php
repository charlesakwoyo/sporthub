// resources/views/dashboard/index.blade.php
@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-lg font-medium text-gray-900">Dashboard Overview</h2>
            
            <!-- Stats -->
            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <x-dashboard.stat-card 
                    title="Total Events" 
                    :value="$stats['total_events']" 
                    icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    color="indigo"
                />
                
                <x-dashboard.stat-card 
                    title="Upcoming Events" 
                    :value="$stats['upcoming_events']" 
                    icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    color="green"
                />
                
                <x-dashboard.stat-card 
                    title="Blog Posts" 
                    :value="$stats['total_blogs']" 
                    icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                    color="yellow"
                />
                
                <x-dashboard.stat-card 
                    title="Tickets" 
                    :value="$stats['total_tickets']" 
                    icon="M15 5v2m0 4v2m0 4v2m0 4v2h-4v-2m4 0h-4m4 0h4m-10-4v2m0-4v2m0-4v2m0-4v2H8v-2m0 0H8m0 0H5a2 2 0 00-2 2v10a2 2 0 002 2h3m10 0h3a2 2 0 002-2V7a2 2 0 00-2-2h-3"
                    color="purple"
                />
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
        <!-- Recent Events -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Events</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentEvents as $event)
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-indigo-600 truncate">{{ $event->title }}</h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $event->start_datetime->format('M d, Y') }} • {{ $event->location }}
                                </p>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <a href="{{ route('dashboard.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-4 sm:px-6 text-sm text-gray-500">
                        No events found.
                    </div>
                @endforelse
            </div>
            <div class="px-4 py-4 sm:px-6 border-t border-gray-200">
                <a href="{{ route('dashboard.events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    View all events
                </a>
            </div>
        </div>

        <!-- Recent Blog Posts -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Blog Posts</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentBlogs as $blog)
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-indigo-600 truncate">{{ $blog->title }}</h4>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $blog->created_at->diffForHumans() }} • {{ $blog->status }}
                                </p>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <a href="{{ route('dashboard.blogs.show', $blog) }}" class="text-indigo-600 hover:text-indigo-900">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-4 sm:px-6 text-sm text-gray-500">
                        No blog posts found.
                    </div>
                @endforelse
            </div>
            <div class="px-4 py-4 sm:px-6 border-t border-gray-200">
                <a href="{{ route('dashboard.blogs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    View all blog posts
                </a>
            </div>
        </div>
    </div>
@endsection