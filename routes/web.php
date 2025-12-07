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
// Admin Panel Routes (must come before user dashboard routes)
// ----------------------------
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', \App\Http\Middleware\Admin::class])
    ->group(function () {
        // Dashboard
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

        // Contact Messages
        Route::prefix('contact-messages')->name('contact-messages.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('index');
            Route::get('/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('show');
            Route::delete('/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('destroy');
            Route::post('/{contactMessage}/mark-as-read', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsRead'])->name('mark-as-read');
            Route::post('/{contactMessage}/mark-as-unread', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsUnread'])->name('mark-as-unread');
            Route::post('/mark-all-read', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAllAsRead'])->name('mark-all-read');
        });
    });

// ----------------------------
// User Dashboard Routes
// ----------------------------
Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Other user dashboard routes with prefix
    Route::prefix('dashboard')
        ->name('dashboard.')
        ->group(function () {
            // Profile
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            
            // Events
            Route::resource('events', \App\Http\Controllers\EventController::class)
                ->except(['index', 'show']);
            
            // Add other user dashboard routes here as needed
        });
});
