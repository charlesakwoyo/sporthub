@extends('layouts.admin')

@section('title', 'View Message - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Message Details</h1>
            <div class="flex space-x-2">
                <form action="{{ route('admin.contact-messages.mark-as-unread', $contactMessage) }}" method="POST" class="inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Mark as Unread
                    </button>
                </form>
                <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Message
                    </button>
                </form>
            </div>
        </div>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Received {{ $contactMessage->created_at->diffForHumans() }}
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                {{ $contactMessage->subject }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                From: {{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;
            </p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Received: {{ $contactMessage->created_at->format('F j, Y, g:i a') }}
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($contactMessage->message)) !!}
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Back to Messages
        </a>
    </div>
</div>
@endsection
