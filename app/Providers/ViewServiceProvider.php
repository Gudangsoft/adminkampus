<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings with all views
        View::composer('*', function ($view) {
            try {
                $settings = Setting::all()->pluck('value', 'key');
                $view->with('globalSettings', $settings);
            } catch (\Exception $e) {
                // In case database is not ready
                $view->with('globalSettings', collect());
            }
        });
    }
}
