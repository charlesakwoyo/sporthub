@extends('layouts.app')

@section('content')
<div class="pt-24">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">Upcoming Events</h1>
            @auth
                <a href="{{ route('dashboard.events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Create Event
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Login to Create Event
                </a>
            @endauth
        </div>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg p-4 mb-8">
            <form method="GET" action="{{ route('events.index') }}" class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search events..." 
                        value="{{ request('search') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                </div>
                <div>
                    <select 
                        name="category" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select 
                        name="date" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                        <option value="">All Dates</option>
                        <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ request('date') == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_weekend" {{ request('date') == 'this_weekend' ? 'selected' : '' }}>This Weekend</option>
                        <option value="next_week" {{ request('date') == 'next_week' ? 'selected' : '' }}>Next Week</option>
                        <option value="this_month" {{ request('date') == 'this_month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Filter
                </button>
            </form>
        </div>

        <!-- Events Grid -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $event->title }}</h2>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: {{ $event->category->color ?? '#3b82f6' }}; color: white;">
                                    {{ $event->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">{{ $event->short_description ?? \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event->start_datetime->format('M j, Y g:i A') }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->location }}
                            </div>
                            
                            <a 
                                href="{{ route('events.show', $event) }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $events->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No events found</h3>
                <p class="mt-1 text-gray-500">There are currently no upcoming events matching your criteria.</p>
                <div class="mt-6">
                    <a 
                        href="{{ route('dashboard.events.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Create an Event
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection