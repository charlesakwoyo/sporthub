<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Dashboard\StatCard as DashboardStatCard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Share common data with all views
        View::composer('*', function ($view) {
            $view->with('currentUser', auth()->user());
        });

        // Register blade components
        Blade::component('dashboard.stat-card', DashboardStatCard::class);
    }
}
