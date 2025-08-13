<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user has admin role
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // Check if user is active
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        return $next($request);
    }
}
