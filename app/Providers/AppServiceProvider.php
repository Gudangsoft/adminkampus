<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Set default pagination view for better UI
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.bootstrap-4');
        \Illuminate\Pagination\Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');
        
        // Register helper functions
        if (!function_exists('setting')) {
            function setting($key, $default = null)
            {
                try {
                    static $settings = null;
                    
                    if ($settings === null) {
                        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
                    }
                    
                    return $settings[$key] ?? $default;
                } catch (\Exception $e) {
                    return $default;
                }
            }
        }
    }
}
