@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Contact Us
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                Have questions? We're here to help. Fill out the form below or check our FAQ section.
            </p>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Send us a message</h3>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" required
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('name', auth()->user() ? auth()->user()->name : '') }}">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email" required
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('email', auth()->user() ? auth()->user()->email : '') }}">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <div class="mt-1">
                                <input type="text" name="subject" id="subject" required
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('subject') }}">
                            </div>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" required
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('message') }}</textarea>
                            </div>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- FAQ Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Frequently Asked Questions</h3>
                    <div class="space-y-4">
                        @foreach($faqs as $index => $faq)
                            <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }" class="border border-gray-200 rounded-lg overflow-hidden">
                                <button 
                                    @click="open = !open"
                                    class="w-full px-4 py-3 text-left text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex justify-between items-center"
                                    :aria-expanded="open">
                                    <span>{{ $faq['question'] }}</span>
                                    <svg class="h-5 w-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" x-collapse class="px-4 py-3 bg-white text-gray-600 text-sm">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-8 bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 text-base text-gray-500">
                                    <p>support@sportshub.com</p>
                                    <p class="mt-1">We'll respond within 24 hours</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3 text-base text-gray-500">
                                    <p>123 Sports Avenue</p>
                                    <p class="mt-1">Nairobi, Kenya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Initialize any Alpine.js components if needed
    });
</script>
@endpush
@endsection
