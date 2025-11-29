@extends('layouts.app')

@section('title', 'About Us - ' . config('app.name'))

@push('styles')
<style>
    .team-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .value-card {
        transition: transform 0.3s ease;
    }
    .value-card:hover {
        transform: translateY(-5px);
    }
    .value-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        font-size: 1.5rem;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">About Us</h1>
            <p class="text-xl opacity-90">
                We are passionate about connecting sports enthusiasts with the best events and experiences.
                Our mission is to make sports more accessible and enjoyable for everyone.
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-white transform translate-y-1/2 -skew-y-2 origin-top"></div>
</section>

<!-- Our Story -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Our Story</h2>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Founded in 2023, SportHub was born out of a shared love for sports and a desire to create a better way for fans to discover and attend sporting events. 
                What started as a small project has grown into a platform that serves thousands of sports enthusiasts across the country.
            </p>
            <p class="text-gray-600 leading-relaxed">
                We believe that sports have the power to bring people together, create lasting memories, and inspire greatness in all of us. 
                Our platform is designed to make it easier than ever to find, book, and enjoy the sports events you love.
            </p>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Our Core Values</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">These principles guide everything we do at SportHub</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($coreValues as $value)
            <div class="value-card bg-white p-8 rounded-lg shadow-md text-center">
                <div class="value-icon mb-6">
                    <i class="fas fa-{{ $value['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">{{ $value['title'] }}</h3>
                <p class="text-gray-600">{{ $value['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Meet Our Team</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">The passionate individuals behind SportHub</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teamMembers as $member)
            <div class="team-card bg-white rounded-lg overflow-hidden shadow-md">
                <div class="h-64 bg-gray-200 overflow-hidden">
                    <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold">{{ $member['name'] }}</h3>
                    <p class="text-blue-600 mb-4">{{ $member['position'] }}</p>
                    <p class="text-gray-600 mb-4">{{ $member['bio'] }}</p>
                    <div class="flex justify-center space-x-4">
                        @if(isset($member['social']['twitter']))
                        <a href="{{ $member['social']['twitter'] }}" class="text-gray-500 hover:text-blue-500">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        @endif
                        @if(isset($member['social']['linkedin']))
                        <a href="{{ $member['social']['linkedin'] }}" class="text-gray-500 hover:text-blue-700">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        @endif
                        @if(isset($member['social']['facebook']))
                        <a href="{{ $member['social']['facebook'] }}" class="text-gray-500 hover:text-blue-800">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Join Our Community</h2>
        <p class="text-xl opacity-90 mb-8 max-w-2xl mx-auto">
            Ready to experience the best sports events? Join thousands of sports enthusiasts today.
        </p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
            Get Started
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Add any custom JavaScript for the about page here
    document.addEventListener('DOMContentLoaded', function() {
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
