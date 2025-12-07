<nav x-data="{ isOpen: false, profileOpen: false }" @keydown.window.escape="isOpen = false; profileOpen = false" class="bg-white shadow-sm fixed w-full top-0 z-40">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">SportHub</span>
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-2 lg:space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-900 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-gray-100' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('events.index') }}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('events.*') ? 'bg-gray-100' : '' }}">
                        Events
                    </a>
                    <a href="{{ route('blogs.index') }}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('blogs.*') ? 'bg-gray-100' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'bg-gray-100' : '' }}">
                        About
                    </a>
                    <a href="{{ route('contact.show') }}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('contact.*') ? 'bg-gray-100' : '' }}">
                        Contact
                    </a>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <div class="ml-3 relative" x-data="{ open: false }" @click.away="open = false">
                        <div>
                            <button @click="open = !open" @click.away="open = false" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                            </button>
                        </div>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                             role="menu" 
                             aria-orientation="vertical" 
                             aria-labelledby="user-menu">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                Dashboard
                            </a>
                            <a href="{{ route('dashboard.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                Your Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign up
                    </a>
                @endauth
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" 
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-100 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="sm:hidden absolute top-16 left-0 right-0 bg-white shadow-lg rounded-b-lg overflow-hidden z-50" 
         id="mobile-menu"
         x-cloak>
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-3 text-base font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-home w-5 inline-block mr-3"></i> Home
            </a>
            <a href="{{ route('events.index') }}" class="block px-4 py-3 text-base font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('events.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-calendar-alt w-5 inline-block mr-3"></i> Events
            </a>
            <a href="{{ route('blogs.index') }}" class="block px-4 py-3 text-base font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('blogs.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-newspaper w-5 inline-block mr-3"></i> Blog
            </a>
            <a href="{{ route('about') }}" class="block px-4 py-3 text-base font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('about') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-info-circle w-5 inline-block mr-3"></i> About
            </a>
            <a href="{{ route('contact.show') }}" class="block px-4 py-3 text-base font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('contact.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <i class="fas fa-envelope w-5 inline-block mr-3"></i> Contact
            </a>
        </div>
        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Dashboard</a>
                    <a href="{{ route('dashboard.profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Your Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3">
                <div class="space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Log in</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Sign up</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
