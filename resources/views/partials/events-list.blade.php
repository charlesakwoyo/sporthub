@forelse($featuredEvents as $event)
<div class="event-card bg-white rounded-xl overflow-hidden shadow-md">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $event->image_url }}" 
             alt="{{ $event->title }}" 
             class="w-full h-full object-cover">
        <div class="absolute top-4 right-4">
            <span class="bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full">
                {{ $event->category->name ?? 'Event' }}
            </span>
        </div>
        <div class="absolute bottom-4 left-4">
            <div class="bg-white text-gray-900 font-bold text-center p-2 rounded-lg">
                <div class="text-sm">{{ $event->start_datetime->format('M') }}</div>
                <div class="text-xl">{{ $event->start_datetime->format('d') }}</div>
            </div>
        </div>
    </div>
    <div class="p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-bold mb-2">
                    <a href="{{ route('events.show', $event) }}" class="hover:text-blue-600">{{ $event->title }}</a>
                </h3>
                <div class="flex items-center text-gray-600 text-sm">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $event->venue }}</span>
                </div>
            </div>
            @if(isset($event->tickets_remaining))
            <div class="text-right">
                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                    {{ $event->tickets_remaining }} spots left
                </span>
            </div>
            @endif
        </div>
        <div class="flex justify-between items-center mt-4">
            <span class="text-xl font-bold text-gray-900">
                ${{ number_format($event->price, 2) }}
            </span>
            <button class="like-button" data-event-id="{{ $event->id }}">
                <i class="far fa-heart text-gray-400 hover:text-red-500"></i>
                <span class="like-count ml-1">{{ $event->likes_count ?? 0 }}</span>
            </button>
        </div>
    </div>
</div>
@empty
<div class="col-span-3 text-center py-10">
    <p class="text-gray-500">No upcoming events at the moment. Check back later!</p>
</div>
@endforelse
