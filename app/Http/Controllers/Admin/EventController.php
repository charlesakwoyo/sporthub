<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $events = Event::with(['category', 'venue'])
            ->latest()
            ->paginate(15);

        return view('admin.events.index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new event.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = EventCategory::all();
        $venues = Venue::all();

        return view('admin.events.create', [
            'categories' => $categories,
            'venues' => $venues,
        ]);
    }

    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'event_category_id' => 'required|exists:event_categories,id',
            'venue_id' => 'nullable|exists:venues,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'registration_start_date' => 'nullable|date|before_or_equal:start_date',
            'registration_end_date' => 'nullable|date|after_or_equal:registration_start_date|before_or_equal:start_date',
            'capacity' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|lt:price',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Generate slug from title
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['organizer_id'] = auth()->id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('events/featured', 'public');
        }

        // Create the event
        $event = Event::create($validated);

        // Handle additional images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('events/gallery', 'public');
                $images[] = ['image_path' => $path];
            }
            $event->images()->createMany($images);
        }

        return redirect()->route('admin.events.show', $event->id)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $event = Event::with(['category', 'venue', 'organizer', 'images', 'registrations.user'])
            ->findOrFail($id);

        return view('admin.events.show', [
            'event' => $event,
        ]);
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = EventCategory::all();
        $venues = Venue::all();

        return view('admin.events.edit', [
            'event' => $event,
            'categories' => $categories,
            'venues' => $venues,
        ]);
    }

    /**
     * Update the specified event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'event_category_id' => 'required|exists:event_categories,id',
            'venue_id' => 'nullable|exists:venues,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'registration_start_date' => 'nullable|date|before_or_equal:start_date',
            'registration_end_date' => 'nullable|date|after_or_equal:registration_start_date|before_or_equal:start_date',
            'capacity' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|lt:price',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Generate slug from title if it has changed
        if ($event->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $event->id);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($event->featured_image) {
                Storage::disk('public')->delete($event->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('events/featured', 'public');
        }

        // Update the event
        $event->update($validated);

        // Handle additional images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('events/gallery', 'public');
                $images[] = ['image_path' => $path];
            }
            $event->images()->createMany($images);
        }

        return redirect()->route('admin.events.show', $event->id)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Delete featured image
        if ($event->featured_image) {
            Storage::disk('public')->delete($event->featured_image);
        }

        // Delete gallery images
        foreach ($event->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }

    /**
     * Generate a unique slug for the event.
     *
     * @param  string  $title
     * @param  int|null  $id
     * @return string
     */
    protected function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = 1;
        $originalSlug = $slug;

        while (Event::where('slug', $slug)
            ->when($id, function($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Toggle event status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);
        $event->is_active = !$event->is_active;
        $event->save();

        return response()->json([
            'success' => true,
            'is_active' => $event->is_active,
            'message' => 'Event status updated successfully!'
        ]);
    }
}
