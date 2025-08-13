<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class PerformanceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Cache view composers
        View::composer('layouts.app', function ($view) {
            $globalSettings = Cache::remember('global_settings', 3600, function () {
                return \App\Models\Setting::all()->pluck('value', 'key');
            });
            
            $view->with('globalSettings', $globalSettings);
        });
        
        // Optimize images
        if (function_exists('imagewebp') && extension_loaded('gd')) {
            $this->app->singleton('image.optimizer', function () {
                return new \App\Services\ImageOptimizer();
            });
        }
    }
}
