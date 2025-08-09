<?php

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     */
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

if (!function_exists('upload_path')) {
    /**
     * Get upload path for files
     */
    function upload_path($path = '')
    {
        return public_path('uploads/' . ltrim($path, '/'));
    }
}

if (!function_exists('format_file_size')) {
    /**
     * Format file size in human readable format
     */
    function format_file_size($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text and add ellipsis
     */
    function truncate_text($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $suffix;
    }
}

if (!function_exists('active_menu')) {
    /**
     * Check if current route matches menu item
     */
    function active_menu($route_name, $class = 'active')
    {
        return request()->routeIs($route_name) ? $class : '';
    }
}

if (!function_exists('format_number_short')) {
    /**
     * Format number in short format (1K, 1M, etc.)
     */
    function format_number_short($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        
        return number_format($number);
    }
}
