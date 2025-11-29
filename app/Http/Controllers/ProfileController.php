<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's dashboard.
     */
    public function dashboard(): View
    {
        $user = auth()->user();
        
        $upcomingEvents = $user->events()
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime')
            ->take(3)
            ->get();

        $recentBlogs = $user->blogs()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('dashboard.index', [
            'user' => $user,
            'upcomingEvents' => $upcomingEvents,
            'recentBlogs' => $recentBlogs
        ]);
    }

    /**
     * Display the user's events.
     */
    public function events(): View
    {
        $events = auth()->user()->events()->paginate(10);
        return view('dashboard.events', compact('events'));
    }

    /**
     * Display the user's tickets.
     */
    public function tickets(): View
    {
        $tickets = auth()->user()->tickets()->with('event')->paginate(10);
        return view('dashboard.tickets', compact('tickets'));
    }

    /**
     * Display the user's notifications.
     */
    public function notifications(): View
    {
        $notifications = auth()->user()->notifications()->paginate(15);
        return view('dashboard.notifications', compact('notifications'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function createEvent(): View
    {
        $categories = \App\Models\EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('events.create', compact('categories'));
    }
}