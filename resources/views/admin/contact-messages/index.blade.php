@extends('layouts.admin')

@section('title', 'Contact Messages - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Contact Messages</h1>
        <div class="flex space-x-2">
            <form action="{{ route('admin.contact-messages.mark-all-read') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Mark All as Read
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        @if($messages->count() > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($messages as $message)
                    <li class="hover:bg-gray-50 dark:hover:bg-gray-700 {{ !$message->is_read ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                        <a href="{{ route('admin.contact-messages.show', $message) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium {{ !$message->is_read ? 'text-blue-600 dark:text-blue-300' : 'text-gray-900 dark:text-white' }} truncate">
                                        {{ $message->subject }}
                                    </p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        @if(!$message->is_read)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span class="mr-2">{{ $message->name }}</span>
                                            <span class="text-gray-300 dark:text-gray-600">•</span>
                                            <span class="ml-2">{{ $message->email }}</span>
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                        <span>{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right sm:px-6">
                {{ $messages->links() }}
            </div>
        @else
            <div class="px-4 py-5 sm:p-6 text-center text-gray-500 dark:text-gray-400">
                No contact messages found.
            </div>
        @endif
    </div>
</div>
@endsection
