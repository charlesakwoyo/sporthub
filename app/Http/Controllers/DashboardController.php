<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Blog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $user = Auth::user();
            \Log::info('Dashboard accessed by user: ' . $user->id);
            
            // If user is admin, redirect to admin dashboard
            if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                \Log::info('User is admin, redirecting to admin dashboard');
                return redirect()->route('admin.dashboard');
            }
            
            // For regular users, show the user dashboard
            $stats = [
                'total_events' => $user->events()->count(),
                'upcoming_events' => $user->events()->where('start_date', '>=', now())->count(),
                'total_blogs' => $user->blogs()->count(),
                'total_tickets' => $user->tickets()->count(),
            ];

            $recentEvents = $user->events()
                ->with('category')
                ->latest()
                ->take(5)
                ->get();

            $recentBlogs = $user->blogs()
                ->with('category')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.index', [
                'stats' => $stats,
                'recentEvents' => $recentEvents,
                'recentBlogs' => $recentBlogs
            ]);
            
        } catch (\Exception $e) {
            // Log the error with more context
            \Log::error('Dashboard Error for user ' . (Auth::check() ? Auth::id() : 'not logged in') . ': ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            \Log::error($e->getTraceAsString());
            
            // For debugging, show the error
            if (config('app.debug')) {
                return back()->with('error', 'Error in DashboardController: ' . $e->getMessage() . 
                    ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            }
            
            return back()->with('error', 'An error occurred while loading the dashboard. Please try again.');
        }
    }
}