<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Event::with('category')
            ->where('end_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category')) {
            $query->where('event_category_id', $request->input('category'));
        }

        // Date filter
        if ($request->has('date')) {
            switch ($request->input('date')) {
                case 'today':
                    $query->whereDate('start_datetime', now()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('start_datetime', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'this_weekend':
                    $query->whereBetween('start_datetime', [
                        now()->nextWeekendDay()->startOfDay(),
                        now()->nextWeekendDay()->endOfDay()
                    ]);
                    break;
                case 'next_week':
                    $query->whereBetween('start_datetime', [
                        now()->addWeek()->startOfWeek(),
                        now()->addWeek()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('start_datetime', now()->month);
                    break;
            }
        }

        $events = $query->paginate(12);
        $categories = EventCategory::all();

        return view('events.index', [
            'events' => $events,
            'categories' => $categories,
            'filters' => [
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'date' => $request->input('date'),
            ]
        ]);
    }

    /**
     * Display the specified event.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $event = Event::with(['category', 'organizer'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related events (same category, excluding current event)
        $relatedEvents = Event::where('event_category_id', $event->event_category_id)
            ->where('id', '!=', $event->id)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        // Check if the authenticated user has already registered for this event
        $hasRegistered = auth()->check() 
            ? $event->registrations()->where('user_id', auth()->id())->exists()
            : false;

        return view('events.show', [
            'event' => $event,
            'relatedEvents' => $relatedEvents,
            'hasRegistered' => $hasRegistered,
        ]);
    }

    /**
     * Handle event registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $user = $request->user();

        // Check if already registered
        if ($event->registrations()->where('user_id', $user->id)->exists()) {
            return redirect()->back()
                ->with('error', 'You have already registered for this event.');
        }

        // Check if event is full
        if ($event->capacity !== null && $event->registrations()->count() >= $event->capacity) {
            return redirect()->back()
                ->with('error', 'This event has reached its maximum capacity.');
        }

        // Create registration
        $registration = $event->registrations()->create([
            'user_id' => $user->id,
            'registration_date' => now(),
            'status' => 'confirmed',
        ]);

        // In a real app, you would also:
        // 1. Generate a ticket
        // 2. Send confirmation email
        // 3. Process payment if required

        return redirect()->route('dashboard.tickets')
            ->with('success', 'You have successfully registered for ' . $event->title);
    }
}
