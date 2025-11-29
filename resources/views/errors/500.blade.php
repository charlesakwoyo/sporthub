@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Oops! Something went wrong
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ $message ?? 'We encountered an error while processing your request. Our team has been notified.' }}
            </p>
        </div>
        <div class="mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Go back home
            </a>
        </div>
    </div>
</div>
@endsection
