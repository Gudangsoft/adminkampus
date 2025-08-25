<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class ShareGlobalSettings
{
    public function handle(Request $request, Closure $next)
    {
        $globalSettings = [];
        
        try {
            if (class_exists('App\Models\Setting')) {
                $globalSettings = Setting::all()->pluck('value', 'key')->toArray();
            }
        } catch (\Exception $e) {
            // Handle if settings table doesn't exist
            $globalSettings = [
                'site_name' => 'G0-CAMPUS',
                'site_description' => 'Kampus modern untuk masa depan cemerlang',
                'site_keywords' => 'kampus, universitas, pendidikan, akademik'
            ];
        }
        
        View::share('globalSettings', $globalSettings);
        
        return $next($request);
    }
}
