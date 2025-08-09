<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        try {
            $setting = \App\Models\Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('formatFileSize')) {
    /**
     * Format file size in human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function formatFileSize($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('slugify')) {
    /**
     * Generate URL slug from string
     *
     * @param string $text
     * @return string
     */
    function slugify($text)
    {
        // Replace non-alphanumeric characters with hyphens
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        
        // Replace multiple spaces with single hyphen
        $text = preg_replace('/\s+/', '-', trim($text));
        
        return strtolower($text);
    }
}

if (!function_exists('excerpt')) {
    /**
     * Generate excerpt from text
     *
     * @param string $text
     * @param int $limit
     * @return string
     */
    function excerpt($text, $limit = 150)
    {
        $text = strip_tags($text);
        if (strlen($text) <= $limit) {
            return $text;
        }
        
        return substr($text, 0, $limit) . '...';
    }
}

if (!function_exists('timeAgo')) {
    /**
     * Convert datetime to time ago format
     *
     * @param string|Carbon $datetime
     * @return string
     */
    function timeAgo($datetime)
    {
        if (is_string($datetime)) {
            $datetime = \Carbon\Carbon::parse($datetime);
        }
        
        return $datetime->diffForHumans();
    }
}

if (!function_exists('socialShare')) {
    /**
     * Generate social media share URLs
     *
     * @param string $url
     * @param string $title
     * @param string $platform
     * @return string
     */
    function socialShare($url, $title, $platform = 'facebook')
    {
        $encodedUrl = urlencode($url);
        $encodedTitle = urlencode($title);
        
        switch ($platform) {
            case 'facebook':
                return "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}";
            case 'twitter':
                return "https://twitter.com/intent/tweet?url={$encodedUrl}&text={$encodedTitle}";
            case 'whatsapp':
                return "https://wa.me/?text={$encodedTitle} {$encodedUrl}";
            case 'telegram':
                return "https://t.me/share/url?url={$encodedUrl}&text={$encodedTitle}";
            default:
                return $url;
        }
    }
}
