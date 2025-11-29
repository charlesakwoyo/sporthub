// resources/views/dashboard/partials/sidebar.blade.php
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-6">
                <x-application-logo class="h-8 w-auto" />
            </div>
            <nav class="mt-5 flex-1" aria-label="Sidebar">
                <div class="px-2 space-y-1">
                    <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(request()->routeIs('dashboard')) bg-gray-100 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif">
                        <svg class="mr-3 h-6 w-6 @if(request()->routeIs('dashboard')) text-gray-500 @else text-gray-400 group-hover:text-gray-500 @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('dashboard.events') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(request()->routeIs('dashboard.events*')) bg-gray-100 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif">
                        <svg class="mr-3 h-6 w-6 @if(request()->routeIs('dashboard.events*')) text-gray-500 @else text-gray-400 group-hover:text-gray-500 @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        My Events
                    </a>

                    <a href="{{ route('dashboard.blogs') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(request()->routeIs('dashboard.blogs*')) bg-gray-100 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif">
                        <svg class="mr-3 h-6 w-6 @if(request()->routeIs('dashboard.blogs*')) text-gray-500 @else text-gray-400 group-hover:text-gray-500 @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        My Blogs
                    </a>

                    <a href="{{ route('dashboard.tickets') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(request()->routeIs('dashboard.tickets*')) bg-gray-100 text-gray-900 @else text-gray-600 hover:bg-gray-50 hover:text-gray-900 @endif">
                        <svg class="mr-3 h-6 w-6 @if(request()->routeIs('dashboard.tickets*')) text-gray-500 @else text-gray-400 group-hover:text-gray-500 @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2m0 4v2h-4v-2m4 0h-4m4 0h4m-10-4v2m0-4v2m0-4v2m0-4v2H8v-2m0 0H8m0 0H5a2 2 0 00-2 2v10a2 2 0 002 2h3m10 0h3a2 2 0 002-2V7a2 2 0 00-2-2h-3" />
                        </svg>
                        My Tickets
                    </a>
                </div>

                @admin
                <div class="mt-8">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="admin-headline">
                        Admin
                    </h3>
                    <div class="mt-1 space-y-1" aria-labelledby="admin-headline">
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                            <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin Dashboard
                        </a>
                    </div>
                </div>
                @endadmin
            </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
            <a href="{{ route('profile.show') }}" class="flex-shrink-0 w-full group block">
                <div class="flex items-center">
                    <div>
                        <img class="inline-block h-9 w-9 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">View profile</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>