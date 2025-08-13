<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SEOService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SEOService::class, function ($app) {
            return new SEOService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
