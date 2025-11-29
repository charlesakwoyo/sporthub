@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    My Tickets
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('events.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Find Events
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('dashboard.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Overview
                </a>
                <a href="{{ route('dashboard.events') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    My Events
                </a>
                <a href="{{ route('dashboard.tickets') }}" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                    My Tickets
                </a>
                <a href="{{ route('dashboard.notifications') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Notifications
                </a>
            </nav>
        </div>

        <div class="mt-8">
            @if($tickets->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($tickets as $ticket)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2m5-8a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Ticket #{{ $ticket->id }}
                                            </dt>
                                            <dd>
                                                <div class="text-lg font-medium text-gray-900">
                                                    {{ $ticket->event->title }}
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Date</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $ticket->event->start_datetime->format('M j, Y') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Time</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $ticket->event->start_datetime->format('g:i A') }}
                                            </dd>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $ticket->event->location }}</dd>
                                    </div>
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Ticket Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $ticket->ticketType->name ?? 'General Admission' }}</dd>
                                    </div>
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">
                                            @php
                                                $statusClasses = [
                                                    'confirmed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    'refunded' => 'bg-gray-100 text-gray-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                ][$ticket->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </dd>
                                    </div>
                                </div>
                                <div class="mt-5 flex">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        View details
                                    </a>
                                    @if($ticket->status === 'confirmed' && $ticket->event->start_datetime > now())
                                        <a href="#" class="ml-6 text-red-600 hover:text-red-900 text-sm font-medium">
                                            Cancel
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white shadow rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 5v2m0 4v2m0 4v2m5-8a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by registering for an event.</p>
                    <div class="mt-6">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Browse Events
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
