<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ComponentController extends Controller
{
    public function index()
    {
        return view('admin.components.index');
    }

    public function quickAccess()
    {
        $config = config('quick-access');
        return view('admin.components.quick-access', compact('config'));
    }

    public function updateQuickAccess(Request $request)
    {
        $validated = $request->validate([
            'services' => 'required|array',
            'services.*.title' => 'required|string',
            'services.*.url' => 'required|string',
            'services.*.icon' => 'required|string',
            'services.*.external' => 'boolean'
        ]);

        // Update config file
        $configContent = "<?php\n\nreturn " . var_export($validated, true) . ";\n";
        file_put_contents(config_path('quick-access.php'), $configContent);

        return redirect()->back()->with('success', 'Quick Access configuration updated successfully!');
    }

    public function liveChat()
    {
        $config = config('live-chat');
        return view('admin.components.live-chat', compact('config'));
    }

    public function updateLiveChat(Request $request)
    {
        $validated = $request->validate([
            'welcome_message' => 'required|string',
            'auto_responses' => 'required|array',
            'contact' => 'required|array',
            'contact.whatsapp' => 'required|string',
            'contact.email' => 'required|email',
            'contact.phone' => 'required|string'
        ]);

        // Update config file
        $configContent = "<?php\n\nreturn " . var_export($validated, true) . ";\n";
        file_put_contents(config_path('live-chat.php'), $configContent);

        return redirect()->back()->with('success', 'Live Chat configuration updated successfully!');
    }
}
