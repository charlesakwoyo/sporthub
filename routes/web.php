<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;

// User Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// ----------------------------
// Public Routes
// ----------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/get-latest-content', [HomeController::class, 'getLatestContent'])->name('get.latest.content');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs/category/{category}', [BlogController::class, 'category'])->name('blogs.category');

// Contact
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Auth Routes
require __DIR__.'/auth.php';

// ----------------------------
// User Dashboard Routes
// ----------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard at root URL
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Other dashboard routes with prefix
    Route::prefix('dashboard')
        ->name('dashboard.')
        ->group(function () {
            // Profile
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // User Events
            Route::get('/events', [ProfileController::class, 'events'])->name('events');
            Route::get('/events/create', [ProfileController::class, 'createEvent'])->name('events.create');
            Route::post('/events', [ProfileController::class, 'storeEvent'])->name('events.store');

            // Tickets
            Route::get('/tickets', [ProfileController::class, 'tickets'])->name('tickets');

            // Notifications
            Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        });
});

// ----------------------------
// Admin Panel Routes
// ----------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin']) // Auth + admin
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::resource('users', AdminUserController::class);

        // Events
        Route::resource('events', AdminEventController::class);
        Route::patch('/events/{event}/toggle-status', [AdminEventController::class, 'toggleStatus'])
            ->name('events.toggle-status');

        // Blogs
        Route::resource('blogs', AdminBlogController::class);
        Route::patch('/blogs/{blog}/toggle-status', [AdminBlogController::class, 'toggleStatus'])
            ->name('blogs.toggle-status');

        // Settings
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');
    });
