<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Get featured events (6 upcoming events)
            $featuredEvents = Event::with(['category', 'likes'])
                ->where('start_datetime', '>=', now())
                ->where('is_approved', true)
                ->withCount('likes')
                ->orderBy('start_datetime', 'asc')
                ->take(6)
                ->get()
                ->map(function($event) {
                    $event->image_url = $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1517649763962-0c623066013b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                    return $event;
                });

            // Get latest blog posts
            $latestBlogs = Blog::with(['author', 'comments'])
                ->where('is_published', true)
                ->withCount('comments')
                ->latest()
                ->take(3)
                ->get()
                ->map(function($blog) {
                    $blog->image_url = $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1542435503-956c469947f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                    return $blog;
                });

            // Latest sports highlights with embed format
            $featuredVideos = [
                [
                    'title' => 'NBA Top 10 Plays 2024',
                    'video_id' => '1tyfhe-K61M',
                    'thumbnail_url' => 'https://img.youtube.com/vi/1tyfhe-K61M/maxresdefault.jpg',
                    'views' => 1500000,
                    'published_at' => now()->subDays(1),
                    'duration' => '9:15'
                ],
                [
                    'title' => 'UEFA Champions League Highlights',
                    'video_id' => '1tyfhe-K61M',
                    'thumbnail_url' => 'https://img.youtube.com/vi/1tyfhe-K61M/maxresdefault.jpg',
                    'views' => 2800000,
                    'published_at' => now()->subDays(2),
                    'duration' => '14:22'
                ],
                [
                    'title' => 'Premier League Best Goals 2024',
                    'video_id' => '1tyfhe-K61M',
                    'thumbnail_url' => 'https://img.youtube.com/vi/1tyfhe-K61M/maxresdefault.jpg',
                    'views' => 2100000,
                    'published_at' => now()->subDays(3),
                    'duration' => '11:45'
                ]
            ];

            // Use sample testimonials
            $testimonials = collect([
                (object)[
                    'content' => 'This platform has completely transformed how I find and attend sports events. Highly recommended!',
                    'rating' => 5,
                    'user' => (object)[
                        'name' => 'Alex Johnson',
                        'profile_photo_url' => 'https://ui-avatars.com/api/?name=Alex+Johnson&background=random'
                    ]
                ],
                (object)[
                    'content' => 'Great selection of events and easy to use interface. Will definitely be using this service again!',
                    'rating' => 4,
                    'user' => (object)[
                        'name' => 'Sarah Williams',
                        'profile_photo_url' => 'https://ui-avatars.com/api/?name=Sarah+Williams&background=random'
                    ]
                ],
                (object)[
                    'content' => 'The best sports event platform I\'ve used so far. Customer support is excellent!',
                    'rating' => 5,
                    'user' => (object)[
                        'name' => 'Michael Brown',
                        'profile_photo_url' => 'https://ui-avatars.com/api/?name=Michael+Brown&background=random'
                    ]
                ]
            ]);

            // Get categories with event counts
            $categories = \App\Models\Category::withCount(['events' => function($query) {
                $query->where('is_approved', true);
            }])->get();

            return view('home', [
                'featuredEvents' => $featuredEvents,
                'latestBlogs' => $latestBlogs,
                'featuredVideos' => $featuredVideos,
                'testimonials' => $testimonials,
                'categories' => $categories
            ]);

        } catch (\Exception $e) {
            \Log::error('Error loading home page: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->view('errors.500', [
                'message' => 'We encountered an error while loading the home page. Please try again later. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        // Team members data - in a real app, this would come from a database
        $teamMembers = [
            [
                'name' => 'John Memia',
                'position' => 'CEO & Founder',
                'bio' => 'Passionate about sports and community building.',
                'image' => 'https://ui-avatars.com/api/?name=John+Doe&background=random',
                'social' => [
                    'twitter' => '#',
                    'linkedin' => '#',
                    'facebook' => '#',
                ]
            ],
            // Add more team members as needed
        ];

        $coreValues = [
            [
                'title' => 'Excellence',
                'description' => 'We strive for excellence in all our events and services.',
                'icon' => 'medal'
            ],
            [
                'title' => 'Community',
                'description' => 'Building strong communities through sports and shared experiences.',
                'icon' => 'users'
            ],
            [
                'title' => 'Innovation',
                'description' => 'Constantly innovating to provide the best experience.',
                'icon' => 'lightbulb'
            ],
            [
                'title' => 'Integrity',
                'description' => 'We conduct our business with the highest level of integrity.',
                'icon' => 'shield'
            ]
        ];

        return view('about', [
            'teamMembers' => $teamMembers,
            'coreValues' => $coreValues,
        ]);
    }

    /**
     * Get latest content for AJAX updates
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestContent()
    {
        try {
            $featuredEvents = Event::with(['category', 'likes'])
                ->where('start_datetime', '>=', now())
                ->where('is_approved', true)
                ->withCount('likes')
                ->orderBy('start_datetime', 'asc')
                ->take(6)
                ->get()
                ->map(function($event) {
                    $event->image_url = $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1517649763962-0c623066013b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                    return $event;
                });

            $latestBlogs = Blog::with(['author', 'comments'])
                ->where('is_published', true)
                ->withCount('comments')
                ->latest()
                ->take(3)
                ->get()
                ->map(function($blog) {
                    $blog->image_url = $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1542435503-956c469947f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
                    return $blog;
                });

            return response()->json([
                'success' => true,
                'events' => view('partials.events-list', ['featuredEvents' => $featuredEvents])->render(),
                'blogs' => view('partials.blogs-list', ['latestBlogs' => $latestBlogs])->render()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching latest content: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load latest content'
            ], 500);
        }
    }
}
