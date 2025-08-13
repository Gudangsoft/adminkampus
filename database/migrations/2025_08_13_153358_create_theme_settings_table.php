<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string'); // string, json, boolean, integer
            $table->string('group')->default('general'); // general, colors, layout, typography
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default theme settings
        $defaultSettings = [
            // Colors
            ['key' => 'primary_color', 'value' => '#667eea', 'type' => 'string', 'group' => 'colors', 'description' => 'Primary brand color'],
            ['key' => 'secondary_color', 'value' => '#764ba2', 'type' => 'string', 'group' => 'colors', 'description' => 'Secondary brand color'],
            ['key' => 'success_color', 'value' => '#1cc88a', 'type' => 'string', 'group' => 'colors', 'description' => 'Success state color'],
            ['key' => 'info_color', 'value' => '#36b9cc', 'type' => 'string', 'group' => 'colors', 'description' => 'Info state color'],
            ['key' => 'warning_color', 'value' => '#f6c23e', 'type' => 'string', 'group' => 'colors', 'description' => 'Warning state color'],
            ['key' => 'danger_color', 'value' => '#e74a3b', 'type' => 'string', 'group' => 'colors', 'description' => 'Danger state color'],
            ['key' => 'light_color', 'value' => '#f8f9fa', 'type' => 'string', 'group' => 'colors', 'description' => 'Light background color'],
            ['key' => 'dark_color', 'value' => '#5a5c69', 'type' => 'string', 'group' => 'colors', 'description' => 'Dark text color'],
            
            // Layout
            ['key' => 'sidebar_bg', 'value' => 'gradient', 'type' => 'string', 'group' => 'layout', 'description' => 'Sidebar background type'],
            ['key' => 'sidebar_variant', 'value' => 'dark', 'type' => 'string', 'group' => 'layout', 'description' => 'Sidebar color variant'],
            ['key' => 'topbar_variant', 'value' => 'light', 'type' => 'string', 'group' => 'layout', 'description' => 'Topbar color variant'],
            ['key' => 'border_radius', 'value' => '10px', 'type' => 'string', 'group' => 'layout', 'description' => 'Border radius for components'],
            ['key' => 'box_shadow', 'value' => 'default', 'type' => 'string', 'group' => 'layout', 'description' => 'Box shadow intensity'],
            
            // Typography
            ['key' => 'font_family', 'value' => 'Segoe UI', 'type' => 'string', 'group' => 'typography', 'description' => 'Primary font family'],
            ['key' => 'font_size', 'value' => '14px', 'type' => 'string', 'group' => 'typography', 'description' => 'Base font size'],
            
            // General
            ['key' => 'current_theme', 'value' => 'default', 'type' => 'string', 'group' => 'general', 'description' => 'Current active theme'],
            ['key' => 'animation_speed', 'value' => '0.3s', 'type' => 'string', 'group' => 'general', 'description' => 'Animation transition speed'],
            ['key' => 'dark_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'general', 'description' => 'Enable dark mode'],
        ];

        foreach ($defaultSettings as $setting) {
            \DB::table('theme_settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'group' => $setting['group'],
                'description' => $setting['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
