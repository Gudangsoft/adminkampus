<?php

/**
 * Global helper functions for G0-CAMPUS application
 */

if (!function_exists('setting')) {
    /**
     * Get setting value by key with caching
     */
    function setting($key, $default = null)
    {
        try {
            // Use Laravel cache to avoid multiple DB queries
            $cacheKey = 'settings_' . $key;
            return \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($key, $default) {
                $setting = \App\Models\Setting::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            });
        } catch (\Exception $e) {
            // Return default if any error occurs
            return $default;
        }
    }
}

if (!function_exists('get_all_settings')) {
    /**
     * Get all settings as array
     */
    function get_all_settings()
    {
        try {
            return \Illuminate\Support\Facades\Cache::remember('all_settings', 3600, function () {
                return \App\Models\Setting::pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            return [];
        }
    }
}
