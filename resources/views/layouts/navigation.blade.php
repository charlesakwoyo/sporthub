<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ms-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')">Events</x-nav-link>
                    <x-nav-link :href="route('blogs.index')" :active="request()->routeIs('blogs.*')">Blog</x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">About</x-nav-link>

                    {{-- FIXED CONTACT LINK --}}
                    <x-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.show')">
                        Contact
                    </x-nav-link>

                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Admin Dashboard</x-nav-link>
                    @endif
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">My Dashboard</x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md 
                            text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 
                            hover:text-gray-700 dark:hover:text-gray-300 
                            focus:outline-none transition ease-in-out duration-150">
                            
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="h-8 w-8 rounded-full object-cover">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif

                            <div class="ms-2">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 
                        hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 
                        focus:outline-none transition duration-150 ease-in-out">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" 
                            class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" 
                            class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if(Auth::user()->profile_photo_path)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="h-10 w-10 rounded-full">
                    </div>
                @else
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-sm font-medium text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')">Events</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('blogs.index')" :active="request()->routeIs('blogs.*')">Blog</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">About</x-responsive-nav-link>

            {{-- FIXED CONTACT --}}
            <x-responsive-nav-link :href="route('contact.show')" :active="request()->routeIs('contact.show')">
                Contact
            </x-responsive-nav-link>

            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Admin Dashboard
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                My Dashboard
            </x-responsive-nav-link>
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
