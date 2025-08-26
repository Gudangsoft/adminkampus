<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $settingsCollection = Setting::all()->keyBy('key');
        
        return view('admin.settings.index', [
            'settings' => $settingsCollection
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon_file' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        try {
            foreach ($request->settings as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Handle logo upload
            if ($request->hasFile('site_logo_file')) {
                $logoPath = $request->file('site_logo_file')->store('settings', 'public');
                Setting::updateOrCreate(
                    ['key' => 'site_logo'],
                    ['value' => $logoPath]
                );
            }

            // Handle favicon upload
            if ($request->hasFile('site_favicon_file')) {
                $faviconPath = $request->file('site_favicon_file')->store('settings', 'public');
                Setting::updateOrCreate(
                    ['key' => 'site_favicon'],
                    ['value' => $faviconPath]
                );
            }

            return redirect()->route('admin.settings.index')
                           ->with('success', 'Pengaturan berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
