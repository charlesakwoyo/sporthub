@extends('layouts.app')

@section( 'Home - SportHub')

@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
    }
    .event-card, .blog-card {
        transition: all 0.3s ease;
    }
    .event-card:hover, .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .video-thumbnail {
        position: relative;
        cursor: pointer;
    }
    .video-thumbnail::after {
        content: '▶';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: white;
        text-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    .testimonial-card {
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        transform: scale(1.02);
    }
    .category-tag {
        @apply inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section with Carousel -->
    <section id="hero" class="relative h-screen overflow-hidden bg-gray-900">
        <!-- Carousel Container -->
        <div id="heroCarousel" class="relative w-full h-full">
            <!-- Slide 1 - Basketball -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1543351611-58f69d7c1781?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Basketball Tournaments</h1>
                        <p class="text-xl md:text-2xl mb-8">Join the most competitive basketball leagues in your city</p>
                        <a href="#events" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            Join Tournament
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 - Volleyball -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1600250397301-2f0bb1f7c1da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Beach Volleyball</h1>
                        <p class="text-xl md:text-2xl mb-8">Experience the thrill of beach volleyball tournaments</p>
                        <a href="#events" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            Play Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Table Tennis -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1511882150382-421056c89033?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Table Tennis</h1>
                        <p class="text-xl md:text-2xl mb-8">Fast-paced action for players of all skill levels</p>
                        <a href="#events" class="inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            Start Playing
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 - Football -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1579952363872-0f3ae97b1caa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Football Leagues</h1>
                        <p class="text-xl md:text-2xl mb-8">Experience the thrill of competitive football matches</p>
                        <a href="#events" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            View Leagues
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Tennis -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1540747911897-70718e1e7c6e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Tennis Tournaments</h1>
                        <p class="text-xl md:text-2xl mb-8">Compete in local and regional tennis championships</p>
                        <a href="#events" class="inline-block bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            Register Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 4 - Swimming -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Swimming Competitions</h1>
                        <p class="text-xl md:text-2xl mb-8">Dive into exciting swimming events for all levels</p>
                        <a href="#events" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            View Schedule
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 5 - Athletics -->
            <div class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                    <div class="max-w-4xl mx-auto text-white z-10 transform transition-all duration-1000 translate-y-8 opacity-0">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Athletics Events</h1>
                        <p class="text-xl md:text-2xl mb-8">Track and field competitions for all ages and skill levels</p>
                        <a href="#events" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105">
                            Join Event
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Arrows -->
            <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full z-20 transition duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full z-20 transition duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <!-- Dots Navigation -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="0"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="1"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="2"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="3"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="4"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="5"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="6"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="7"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="8"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition duration-300 dot-btn" data-slide="9"></button>
            </div>
        </div>
        
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto transform transition-all duration-1000 ease-out opacity-0 translate-y-10" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                Experience Sports <span class="text-blue-400">Like Never Before</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-10 max-w-3xl mx-auto">
                Join our community of sports enthusiasts. Find events, read blogs, and connect with fellow athletes around the world.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#events" class="group px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20">
                    <span class="flex items-center justify-center">
                        Explore Events
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                </a>
                <a href="#latest-blogs" class="px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-bold rounded-lg transition-all duration-300 border border-white/20 hover:border-white/30">
                    Read Our Blog
                </a>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
                <a href="#events" class="text-white hover:text-blue-300 transition-colors">
                    <span class="block text-sm mb-2">Scroll Down</span>
                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section id="events" class="py-20 md:py-28 bg-gradient-to-b from-gray-50 to-white" data-aos="fade-up">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Upcoming Events</h2>
                <p class="text-gray-600 mt-2">Join these exciting sports events near you</p>
            </div>

            <div id="events-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @include('partials.events-list', ['featuredEvents' => $featuredEvents])
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    View All Events
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Latest Blog Posts -->
    <section id="latest-blogs" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Latest Blog Posts</h2>
                <p class="text-gray-600 mt-2">Stay updated with the latest sports news and tips</p>
            </div>

            <div id="blogs-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @include('partials.blogs-list', ['latestBlogs' => $latestBlogs])
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    View All Articles
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Video Highlights Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Latest Highlights</h2>
                <p class="text-gray-600 mt-2">Watch the best moments from recent events</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredVideos as $video)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="relative group cursor-pointer" onclick="openVideoModal('{{ $video['video_id'] }}')">
                        <img src="{{ $video['thumbnail_url'] }}" alt="{{ $video['title'] }}" class="w-full h-48 object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="bg-red-600 text-white rounded-full p-4 transform transition-transform group-hover:scale-110">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                            <h3 class="text-white font-bold text-lg">{{ $video['title'] }}</h3>
                            <div class="flex items-center mt-1 text-gray-300 text-sm">
                                <span>{{ number_format($video['views']) }} views</span>
                                <span class="mx-2">•</span>
                                <span>{{ \Carbon\Carbon::parse($video['published_at'])->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div id="videoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90">
        <div class="relative w-full max-w-4xl mx-4">
            <button onclick="closeVideoModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <div class="aspect-w-16 aspect-h-9">
                <div id="videoContainer" class="w-full h-96">
                    <!-- Video will be inserted here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">What People Say</h2>
                <p class="mt-2 opacity-90">Hear from our community members</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="testimonial-card bg-white bg-opacity-10 p-8 rounded-xl backdrop-filter backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-white text-opacity-90 mb-6">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center">
                        <img src="{{ $testimonial->user->profile_photo_url }}" 
                             alt="{{ $testimonial->user->name }}"
                             class="w-12 h-12 rounded-full border-2 border-white border-opacity-20">
                        <div class="ml-4">
                            <h4 class="font-bold">{{ $testimonial->user->name }}</h4>
                            <p class="text-sm opacity-80">{{ $testimonial->user->role ?? 'Community Member' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Video Modal -->
    <div id="videoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-75">
        <div class="relative w-full max-w-4xl mx-4">
            <button onclick="closeVideoModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <div class="aspect-w-16 aspect-h-9">
                <div id="videoContainer" class="w-full h-96">
                    <!-- Video will be inserted here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Browse by <span class="text-indigo-600">Category</span></h2>
                <p class="mt-4 text-lg text-gray-600">Find events that match your interests</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('events.index', ['category' => $category->slug]) }}" class="group bg-white p-6 rounded-xl shadow-md text-center hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <div class="mx-auto h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition duration-300 mb-4">
                            {!! $category->icon !!}
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 group-hover:text-indigo-600 transition duration-300">{{ $category->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $category->events_count }} events</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ready to experience the best sports events?</span>
            </h2>
            <p class="mt-3 max-w-md mx-auto text-base text-indigo-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Join thousands of sports enthusiasts and never miss an exciting moment again.
            </p>
            <div class="mt-8 flex justify-center">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition duration-300 transform hover:scale-105">
                        Get Started
                    </a>
                </div>
                <div class="ml-3 inline-flex">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition duration-300">
                        Browse Events
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">What Our <span class="text-indigo-600">Attendees</span> Say</h2>
                <p class="mt-4 text-lg text-gray-600">Don't just take our word for it. Here's what our community has to say.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6">"The best sports event platform I've ever used. Found amazing local basketball tournaments and met great players!"</p>
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Michael Johnson</p>
                            <p class="text-sm text-gray-500">Basketball Enthusiast</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6">"As a coach, finding quality tournaments for my team has never been easier. The platform is intuitive and saves me hours of research."</p>
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Sarah Williams</p>
                            <p class="text-sm text-gray-500">Soccer Coach</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6">"The ticket purchasing process is so smooth, and I love getting reminders before events. Made attending local sports events hassle-free!"</p>
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/75.jpg" alt="">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">David Kim</p>
                            <p class="text-sm text-gray-500">Sports Fan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners/Sponsors -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold uppercase text-gray-500 tracking-wider mb-8">
                Trusted by leading sports organizations
            </p>
            <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                <div class="col-span-1 flex justify-center">
                    <img class="h-12 grayscale opacity-70 hover:opacity-100 transition duration-300" src="{{ asset('images/logos/nike.svg') }}" alt="Nike">
                </div>
                <div class="col-span-1 flex justify-center">
                    <img class="h-12 grayscale opacity-70 hover:opacity-100 transition duration-300" src="{{ asset('images/logos/adidas.svg') }}" alt="Adidas">
                </div>
                <div class="col-span-1 flex justify-center">
                    <img class="h-12 grayscale opacity-70 hover:opacity-100 transition duration-300" src="{{ asset('images/logos/puma.svg') }}" alt="Puma">
                </div>
                <div class="col-span-1 flex justify-center">
                    <img class="h-12 grayscale opacity-70 hover:opacity-100 transition duration-300" src="{{ asset('images/logos/under-armour.svg') }}" alt="Under Armour">
                </div>
                <div class="col-span-1 flex justify-center">
                    <img class="h-12 grayscale opacity-70 hover:opacity-100 transition duration-300" src="{{ asset('images/logos/espn.svg') }}" alt="ESPN">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Hero Carousel Styles */
    .slide {
        transition: opacity 1s ease-in-out;
    }
    
    .slide.active {
        opacity: 1;
    }
    
    .slide-content {
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Add custom animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #2563eb;
    }
</style>
@endpush

@push('scripts')
<!-- Hero Carousel Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot-btn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentSlide = 0;
        let slideInterval;
        const slideDuration = 6000; // 6 seconds
        
        // Show initial slide
        showSlide(currentSlide);
        
        // Auto-advance slides
        function startSlideShow() {
            slideInterval = setInterval(() => {
                nextSlide();
            }, slideDuration);
        }
        
        // Start the slideshow
        startSlideShow();
        
        // Pause on hover
        const carousel = document.getElementById('heroCarousel');
        carousel.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });
        
        carousel.addEventListener('mouseleave', () => {
            startSlideShow();
        });
        
        // Navigation functions
        function showSlide(index) {
            // Hide all slides and reset content animation
            slides.forEach((slide, i) => {
                slide.style.opacity = '0';
                const content = slide.querySelector('.transform');
                if (content) {
                    content.style.opacity = '0';
                    content.style.transform = 'translateY(2rem)';
                }
            });
            
            // Show current slide
            slides[index].style.opacity = '1';
            const currentContent = slides[index].querySelector('.transform');
            if (currentContent) {
                setTimeout(() => {
                    currentContent.style.opacity = '1';
                    currentContent.style.transform = 'translateY(0)';
                }, 50);
            }
            
            // Update active dot
            dots.forEach(dot => dot.classList.remove('bg-white'));
            dots[index].classList.add('bg-white');
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }
        
        // Event listeners
        nextBtn.addEventListener('click', () => {
            clearInterval(slideInterval);
            nextSlide();
            startSlideShow();
        });
        
        prevBtn.addEventListener('click', () => {
            clearInterval(slideInterval);
            prevSlide();
            startSlideShow();
        });
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                clearInterval(slideInterval);
                currentSlide = index;
                showSlide(currentSlide);
                startSlideShow();
            });
        });
        
        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;
        
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            clearInterval(slideInterval);
        }, { passive: true });
        
        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startSlideShow();
        }, { passive: true });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const swipeDiff = touchStartX - touchEndX;
            
            if (Math.abs(swipeDiff) > swipeThreshold) {
                if (swipeDiff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }
    });
</script>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js">
</script>

<script>
    // Auto-update content
    function updateContent() {
        fetch('{{ route('get.latest.content') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('events-container').innerHTML = data.events;
                    document.getElementById('blogs-container').innerHTML = data.blogs;
                    
                    // Re-initialize any event listeners if needed
                    initializeEventListeners();
                }
            })
            .catch(error => console.error('Error updating content:', error));
    }

    // Update content every 30 seconds
    setInterval(updateContent, 30000);

    // Also update when the page becomes visible again
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateContent();
        }
    });

    // Initialize event listeners
    function initializeEventListeners() {
        // Re-initialize any event listeners here if needed
        // For example, if you have click handlers on the events or blogs
    }

    // Initial call to set up event listeners
    document.addEventListener('DOMContentLoaded', function() {
        initializeEventListeners();
    });

    // Video Modal Functions
    function openVideoModal(videoId) {
        const modal = document.getElementById('videoModal');
        const videoContainer = document.getElementById('videoContainer');
        
        // Create iframe with autoplay
        const iframe = document.createElement('iframe');
        iframe.setAttribute('id', 'youtubePlayer');
        iframe.setAttribute('class', 'w-full h-full');
        iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&modestbranding=1`);
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
        iframe.setAttribute('allowfullscreen', '');
        
        // Clear previous video and add new one
        videoContainer.innerHTML = '';
        videoContainer.appendChild(iframe);
        
        // Show the modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const videoContainer = document.getElementById('videoContainer');
        
        // Clear the video container (this stops the video)
        videoContainer.innerHTML = '';
        
        // Hide the modal
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('videoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeVideoModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVideoModal();
        }
    });
</script>

<script></script>
<script>
    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Animate hero content on load
        const heroContent = document.querySelector('#hero .relative');
        if (heroContent) {
            setTimeout(() => {
                heroContent.classList.remove('opacity-0', 'translate-y-10');
                heroContent.classList.add('opacity-100', 'translate-y-0');
            }, 100);
        }
    });
    // Video Modal Functions
    function openVideoModal(videoUrl) {
        console.log('Opening video modal with URL:', videoUrl);
        const modal = document.getElementById('videoModal');
        const videoContainer = document.getElementById('videoContainer');
        
        // Extract video ID from different YouTube URL formats
        let videoId = '';
        if (videoUrl.includes('youtube.com/watch?v=')) {
            videoId = videoUrl.split('v=')[1];
            const ampersandPosition = videoId.indexOf('&');
            if (ampersandPosition !== -1) {
                videoId = videoId.substring(0, ampersandPosition);
            }
        } else if (videoUrl.includes('youtu.be/')) {
            videoId = videoUrl.split('youtu.be/')[1];
        } else if (videoUrl.includes('youtube.com/embed/')) {
            videoId = videoUrl.split('youtube.com/embed/')[1].split('?')[0];
        }
        
        if (!videoId) {
            console.error('Could not extract video ID from URL:', videoUrl);
            return;
        }
        
        // Create a new iframe for the video
        const iframe = document.createElement('iframe');
        iframe.setAttribute('id', 'youtubePlayer');
        iframe.setAttribute('class', 'w-full h-full');
        iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&enablejsapi=1`);
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
        iframe.setAttribute('allowfullscreen', '');
        
        // Clear previous video and add new one
        videoContainer.innerHTML = '';
        videoContainer.appendChild(iframe);
        
        // Show the modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        console.log('Closing video modal');
        const modal = document.getElementById('videoModal');
        const videoContainer = document.getElementById('videoContainer');
        
        // Clear the video container
        videoContainer.innerHTML = '';
        
        // Hide the modal
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('videoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeVideoModal();
        }
    });

    // Like functionality
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function() {
            const eventId = this.dataset.eventId;
            const heartIcon = this.querySelector('i');
            const likeCount = this.querySelector('.like-count');
            
            // Toggle like state
            const isLiked = heartIcon.classList.contains('text-red-500');
            
            // Update UI immediately for better UX
            if (isLiked) {
                heartIcon.classList.remove('text-red-500', 'fas');
                heartIcon.classList.add('far');
                likeCount.textContent = parseInt(likeCount.textContent) - 1;
            } else {
                heartIcon.classList.remove('far');
                heartIcon.classList.add('text-red-500', 'fas');
                likeCount.textContent = parseInt(likeCount.textContent) + 1;
            }
            
            // Send AJAX request to like/unlike
            fetch(`/events/${eventId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'PATCH'
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update like count from server response
                likeCount.textContent = data.likes_count;
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert UI if there's an error
                if (isLiked) {
                    heartIcon.classList.add('text-red-500', 'fas');
                    heartIcon.classList.remove('far');
                    likeCount.textContent = parseInt(likeCount.textContent) + 1;
                } else {
                    heartIcon.classList.remove('text-red-500', 'fas');
                    heartIcon.classList.add('far');
                    likeCount.textContent = parseInt(likeCount.textContent) - 1;
                }
            });
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush
