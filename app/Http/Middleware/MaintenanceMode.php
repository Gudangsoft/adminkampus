<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Always skip maintenance mode for admin routes and auth routes
        if ($request->is('admin/*') || $request->is('admin') || 
            $request->is('login') || $request->is('logout') || 
            $request->is('register') || $request->is('password/*')) {
            return $next($request);
        }

        // Skip for authenticated users (admin atau user yang sudah login)
        if (Auth::check()) {
            return $next($request);
        }

        // Skip for API routes atau resource files
        if ($request->is('api/*') || 
            $request->is('storage/*') || 
            $request->is('css/*') || 
            $request->is('js/*') || 
            $request->is('images/*')) {
            return $next($request);
        }

        try {
            $maintenanceMode = Setting::where('key', 'maintenance_mode')->first();
            
            if ($maintenanceMode && $maintenanceMode->value == '1') {
                // Get maintenance settings
                $title = Setting::where('key', 'maintenance_title')->first()->value ?? 'Website Sedang Dalam Perbaikan';
                $message = Setting::where('key', 'maintenance_message')->first()->value ?? 'Mohon maaf, website sedang dalam perbaikan. Silakan kembali lagi nanti.';
                $estimatedTime = Setting::where('key', 'maintenance_estimated_time')->first()->value ?? null;
                
                // Return maintenance view
                return response()->view('maintenance', compact('title', 'message', 'estimatedTime'), 503);
            }
        } catch (\Exception $e) {
            // If database is not available, continue normally
            \Log::error('MaintenanceMode middleware error: ' . $e->getMessage());
        }

        return $next($request);
    }
}
