<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalAuthController extends Controller
{
    /**
     * Handle global logout
     */
    public function logout(Request $request)
    {
        // Determine which login to redirect to based on current route or referer
        $redirectRoute = 'home';
        
        if ($request->header('referer')) {
            $referer = $request->header('referer');
            
            if (str_contains($referer, '/admin/components') || str_contains($referer, '/component/')) {
                $redirectRoute = 'component.login';
            } elseif (str_contains($referer, '/admin/')) {
                $redirectRoute = 'admin.login';
            }
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirectRoute)->with('success', 'Anda telah berhasil logout.');
    }
}
