<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Blog;
use App\Models\ContactMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalEvents' => Event::count(),
            'totalBlogs' => Blog::published()->count(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
        ];

        // Get recent users
        $recentUsers = User::latest()->take(5)->get();

        // Get upcoming events
        $upcomingEvents = Event::with('category')
            ->where('start_datetime', '>=', now())
            ->orderBy('start_datetime', 'asc')
            ->take(5)
            ->get();

        // Get recent blog posts
        $recentBlogs = Blog::with('author')
            ->latest()
            ->take(5)
            ->get();

        // Get recent messages
        $recentMessages = ContactMessage::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get user registration stats for the last 30 days
        $userStats = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Get event registration stats for the last 30 days
        $eventStats = Event::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'upcomingEvents' => $upcomingEvents,
            'recentBlogs' => $recentBlogs,
            'recentMessages' => $recentMessages,
            'userStats' => $userStats,
            'eventStats' => $eventStats,
        ]);
    }

    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('admin.settings', [
            'settings' => [
                'site_name' => config('app.name'),
                'site_email' => config('mail.from.address'),
                'site_description' => config('app.description'),
                'timezone' => config('app.timezone'),
                'date_format' => config('app.date_format'),
                'time_format' => config('app.time_format'),
                'items_per_page' => config('app.items_per_page'),
                'allow_registrations' => config('auth.registration_enabled'),
                'require_email_verification' => config('auth.must_verify_email'),
                'enable_recaptcha' => config('services.recaptcha.enabled'),
            ]
        ]);
    }

    /**
     * Update the application settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_description' => 'nullable|string|max:500',
            'timezone' => 'required|timezone',
            'date_format' => 'required|string|max:50',
            'time_format' => 'required|string|max:50',
            'items_per_page' => 'required|integer|min:5|max:100',
            'allow_registrations' => 'boolean',
            'require_email_verification' => 'boolean',
            'enable_recaptcha' => 'boolean',
        ]);

        // In a real app, you would save these to a settings table or config file
        // For now, we'll just store them in the session for demonstration
        $request->session()->put('app_settings', $validated);

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully!');
    }
}
