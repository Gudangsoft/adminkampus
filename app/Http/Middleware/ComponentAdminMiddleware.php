<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComponentAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('component.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user has component admin access (admin only for component management)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin komponen yang dapat mengakses halaman ini.');
        }

        // Check if user is active
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('component.login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        return $next($request);
    }
}
