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
            
            $stats = [
                'total_events' => $user->organizedEvents()->count(),
                'upcoming_events' => $user->organizedEvents()->upcoming()->count(),
                'total_blogs' => $user->blogs()->count(),
                'total_tickets' => $user->tickets()->count(),
            ];

            $recentEvents = $user->organizedEvents()
                ->with('category')
                ->latest()
                ->take(5)
                ->get();

            $recentBlogs = $user->blogs()
                ->with('category')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.index', compact('stats', 'recentEvents', 'recentBlogs'));
            
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }
}