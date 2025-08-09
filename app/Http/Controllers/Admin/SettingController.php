<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Debug: Log request data
        \Log::info('Settings Update Request', [
            'has_logo_file' => $request->hasFile('site_logo_file'),
            'has_favicon_file' => $request->hasFile('site_favicon_file'),
            'files' => $request->allFiles(),
            'settings' => $request->input('settings')
        ]);

        $request->validate([
            'settings' => 'required|array',
            'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon_file' => 'nullable|image|mimes:ico,png,jpg|max:1024',
        ]);

        try {
            // Handle logo upload
            if ($request->hasFile('site_logo_file')) {
                $logoFile = $request->file('site_logo_file');
                \Log::info('Processing logo upload', ['filename' => $logoFile->getClientOriginalName()]);
                
                // Delete old logo if exists
                $oldLogo = Setting::where('key', 'site_logo')->first();
                if ($oldLogo && $oldLogo->value) {
                    Storage::disk('public')->delete($oldLogo->value);
                    // Also delete from public storage
                    if (file_exists(public_path('storage/' . $oldLogo->value))) {
                        unlink(public_path('storage/' . $oldLogo->value));
                    }
                    \Log::info('Deleted old logo', ['path' => $oldLogo->value]);
                }
                
                $logoPath = $logoFile->store('images/logos', 'public');
                // Copy to public storage as well
                $publicPath = public_path('storage/' . $logoPath);
                $privatePath = storage_path('app/public/' . $logoPath);
                if (!file_exists(dirname($publicPath))) {
                    mkdir(dirname($publicPath), 0755, true);
                }
                copy($privatePath, $publicPath);
                
                \Log::info('Stored new logo', ['path' => $logoPath]);
                $request->merge(['settings' => array_merge($request->settings, ['site_logo' => $logoPath])]);
            }

            // Handle favicon upload
            if ($request->hasFile('site_favicon_file')) {
                $faviconFile = $request->file('site_favicon_file');
                \Log::info('Processing favicon upload', ['filename' => $faviconFile->getClientOriginalName()]);
                
                // Delete old favicon if exists
                $oldFavicon = Setting::where('key', 'site_favicon')->first();
                if ($oldFavicon && $oldFavicon->value) {
                    Storage::disk('public')->delete($oldFavicon->value);
                    // Also delete from public storage
                    if (file_exists(public_path('storage/' . $oldFavicon->value))) {
                        unlink(public_path('storage/' . $oldFavicon->value));
                    }
                    \Log::info('Deleted old favicon', ['path' => $oldFavicon->value]);
                }
                
                $faviconPath = $faviconFile->store('images/favicons', 'public');
                // Copy to public storage as well
                $publicPath = public_path('storage/' . $faviconPath);
                $privatePath = storage_path('app/public/' . $faviconPath);
                if (!file_exists(dirname($publicPath))) {
                    mkdir(dirname($publicPath), 0755, true);
                }
                copy($privatePath, $publicPath);
                
                \Log::info('Stored new favicon', ['path' => $faviconPath]);
                $request->merge(['settings' => array_merge($request->settings, ['site_favicon' => $faviconPath])]);
            }

            foreach ($request->settings as $key => $value) {
                // First try to find existing setting
                $setting = Setting::where('key', $key)->first();
                
                if ($setting) {
                    // Update existing setting
                    $setting->update(['value' => $value]);
                    \Log::info('Updated setting', ['key' => $key, 'value' => $value]);
                } else {
                    // Create new setting with all required fields
                    Setting::create([
                        'key' => $key,
                        'value' => $value,
                        'label' => ucwords(str_replace('_', ' ', $key)),
                        'type' => 'text',
                        'group' => 'general',
                        'description' => null,
                        'is_editable' => true
                    ]);
                    \Log::info('Created new setting', ['key' => $key, 'value' => $value]);
                }
            }

            // Clear settings cache after update
            \Cache::forget('all_settings');
            foreach ($request->settings as $key => $value) {
                \Cache::forget('settings_' . $key);
            }

            return redirect()->route('admin.settings.index')
                            ->with('success', 'Pengaturan berhasil disimpan');
                            
        } catch (\Exception $e) {
            \Log::error('Settings update error', ['error' => $e->getMessage()]);
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage())
                            ->withInput();
        }
    }

    public function general()
    {
        $settings = Setting::where('group', 'general')->get()->keyBy('key');
        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_favicon' => 'nullable|image|mimes:png,ico|max:1024',
        ]);

        $settings = [
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'site_keywords' => $request->site_keywords,
            'maintenance_mode' => $request->has('maintenance_mode') ? '1' : '0',
        ];

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $filename = 'logo.' . $logo->getClientOriginalExtension();
            $path = 'settings/' . $filename;
            
            $img = Image::make($logo)->resize(200, 80, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Storage::disk('public')->put($path, $img->encode());
            $settings['site_logo'] = $path;
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $favicon = $request->file('site_favicon');
            $filename = 'favicon.' . $favicon->getClientOriginalExtension();
            $path = 'settings/' . $filename;
            
            $img = Image::make($favicon)->resize(32, 32);
            Storage::disk('public')->put($path, $img->encode());
            $settings['site_favicon'] = $path;
        }

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => 'general',
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'type' => in_array($key, ['site_logo', 'site_favicon']) ? 'image' : 'text'
                ]
            );
        }

        return redirect()->back()->with('success', 'General settings updated successfully.');
    }

    public function contact()
    {
        $settings = Setting::where('group', 'contact')->get()->keyBy('key');
        return view('admin.settings.contact', compact('settings'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
            'contact_fax' => 'nullable|string',
            'contact_website' => 'nullable|url',
        ]);

        $settings = [
            'contact_address' => $request->contact_address,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'contact_fax' => $request->contact_fax,
            'contact_website' => $request->contact_website,
            'contact_map_latitude' => $request->contact_map_latitude,
            'contact_map_longitude' => $request->contact_map_longitude,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => 'contact',
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'type' => 'text'
                ]
            );
        }

        return redirect()->back()->with('success', 'Contact settings updated successfully.');
    }

    public function social()
    {
        $settings = Setting::where('group', 'social')->get()->keyBy('key');
        return view('admin.settings.social', compact('settings'));
    }

    public function updateSocial(Request $request)
    {
        $settings = [
            'social_facebook' => $request->social_facebook,
            'social_twitter' => $request->social_twitter,
            'social_instagram' => $request->social_instagram,
            'social_youtube' => $request->social_youtube,
            'social_linkedin' => $request->social_linkedin,
            'social_tiktok' => $request->social_tiktok,
        ];

        foreach ($settings as $key => $value) {
            if ($value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $value,
                        'group' => 'social',
                        'label' => ucwords(str_replace(['social_', '_'], ['', ' '], $key)),
                        'type' => 'url'
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Social media settings updated successfully.');
    }

    public function about()
    {
        $settings = Setting::where('group', 'about')->get()->keyBy('key');
        return view('admin.settings.about', compact('settings'));
    }

    public function updateAbout(Request $request)
    {
        $settings = [
            'about_history' => $request->about_history,
            'about_vision' => $request->about_vision,
            'about_mission' => $request->about_mission,
            'about_rector_name' => $request->about_rector_name,
            'about_rector_message' => $request->about_rector_message,
            'about_established_year' => $request->about_established_year,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => 'about',
                    'label' => ucwords(str_replace(['about_', '_'], ['', ' '], $key)),
                    'type' => in_array($key, ['about_history', 'about_rector_message']) ? 'textarea' : 'text'
                ]
            );
        }

        return redirect()->back()->with('success', 'About settings updated successfully.');
    }
}
