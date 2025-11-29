@props(['title', 'value', 'icon', 'color' => 'indigo'])

@php
$colors = [
    'indigo' => [
        'bg' => 'bg-indigo-500',
        'text' => 'text-indigo-500',
    ],
    'green' => [
        'bg' => 'bg-green-500',
        'text' => 'text-green-500',
    ],
    'yellow' => [
        'bg' => 'bg-yellow-500',
        'text' => 'text-yellow-500',
    ],
    'purple' => [
        'bg' => 'bg-purple-500',
        'text' => 'text-purple-500',
    ],
];
$color = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0 rounded-md p-3 {{ $color['bg'] }} bg-opacity-10">
                <svg class="h-6 w-6 {{ $color['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd>
                        <div class="text-lg font-medium text-gray-900">{{ $value }}</div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-5 py-3">
        <div class="text-sm">
            <a href="#" class="font-medium text-indigo-700 hover:text-indigo-900">View all</a>
        </div>
    </div>
</div>
