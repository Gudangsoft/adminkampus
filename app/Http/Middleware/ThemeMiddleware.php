<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ThemeSetting;
use Illuminate\Support\Facades\View;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get all theme settings
        $themeSettings = ThemeSetting::getAllGrouped();
        
        // Generate dynamic CSS
        $dynamicCSS = $this->generateDynamicCSS($themeSettings);
        
        // Share theme settings and CSS with all views
        View::share('themeSettings', $themeSettings);
        View::share('dynamicCSS', $dynamicCSS);
        View::share('currentTheme', ThemeSetting::get('current_theme', 'default'));
        
        return $next($request);
    }

    /**
     * Generate dynamic CSS from theme settings
     */
    private function generateDynamicCSS($settings)
    {
        $css = ":root {\n";
        
        // Colors
        if (isset($settings['colors'])) {
            foreach ($settings['colors'] as $key => $setting) {
                $cssVar = '--' . str_replace('_', '-', $key);
                $css .= "  {$cssVar}: {$setting['value']};\n";
            }
        }
        
        // Typography
        if (isset($settings['typography'])) {
            foreach ($settings['typography'] as $key => $setting) {
                $cssVar = '--' . str_replace('_', '-', $key);
                $css .= "  {$cssVar}: {$setting['value']};\n";
            }
        }
        
        // Layout
        if (isset($settings['layout'])) {
            foreach ($settings['layout'] as $key => $setting) {
                $cssVar = '--' . str_replace('_', '-', $key);
                $css .= "  {$cssVar}: {$setting['value']};\n";
            }
        }
        
        // General
        if (isset($settings['general'])) {
            foreach ($settings['general'] as $key => $setting) {
                if ($key !== 'current_theme') {
                    $cssVar = '--' . str_replace('_', '-', $key);
                    $css .= "  {$cssVar}: {$setting['value']};\n";
                }
            }
        }
        
        $css .= "}\n\n";
        
        // Apply theme-specific styles
        $css .= $this->getThemeSpecificCSS($settings);
        
        return $css;
    }

    /**
     * Get theme-specific CSS rules
     */
    private function getThemeSpecificCSS($settings)
    {
        $css = "";
        
        // Sidebar styling
        $css .= ".sidebar {\n";
        $css .= "  background: var(--primary-color);\n";
        if (isset($settings['layout']['sidebar_bg']) && $settings['layout']['sidebar_bg']['value'] === 'gradient') {
            $css .= "  background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);\n";
        }
        $css .= "}\n\n";
        
        // Card styling
        $css .= ".card {\n";
        $css .= "  border-radius: var(--border-radius);\n";
        $css .= "  box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);\n";
        $css .= "}\n\n";
        
        // Button styling
        $css .= ".btn-primary {\n";
        $css .= "  background-color: var(--primary-color);\n";
        $css .= "  border-color: var(--primary-color);\n";
        $css .= "}\n\n";
        
        $css .= ".btn-primary:hover {\n";
        $css .= "  background-color: var(--secondary-color);\n";
        $css .= "  border-color: var(--secondary-color);\n";
        $css .= "}\n\n";
        
        // Text colors
        $css .= ".text-primary {\n";
        $css .= "  color: var(--primary-color) !important;\n";
        $css .= "}\n\n";
        
        // Navbar styling
        $css .= ".navbar {\n";
        $css .= "  background-color: var(--light-color);\n";
        $css .= "}\n\n";
        
        // Dark mode handling
        if (isset($settings['general']['dark_mode']) && $settings['general']['dark_mode']['value']) {
            $css .= $this->getDarkModeCSS();
        }
        
        return $css;
    }

    /**
     * Get dark mode specific CSS
     */
    private function getDarkModeCSS()
    {
        return "
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }
        
        .card {
            background-color: #2d2d2d;
            color: #ffffff;
        }
        
        .navbar {
            background-color: #2d2d2d !important;
        }
        
        .sidebar {
            background-color: #1a1a1a !important;
        }
        ";
    }
}
