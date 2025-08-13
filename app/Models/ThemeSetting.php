<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ThemeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description'
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $cacheKey = "theme_setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            if (!$setting) {
                return $default;
            }
            
            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description
            ]
        );

        Cache::forget("theme_setting_{$key}");
        Cache::forget('all_theme_settings');
        
        return $setting;
    }

    /**
     * Get all settings grouped by group
     */
    public static function getAllGrouped()
    {
        return Cache::remember('all_theme_settings', 3600, function () {
            $settings = static::all();
            $grouped = [];
            
            foreach ($settings as $setting) {
                $grouped[$setting->group][$setting->key] = [
                    'value' => static::castValue($setting->value, $setting->type),
                    'type' => $setting->type,
                    'description' => $setting->description
                ];
            }
            
            return $grouped;
        });
    }

    /**
     * Cast value to appropriate type
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            case 'string':
            default:
                return $value;
        }
    }

    /**
     * Clear all cache
     */
    public static function clearCache()
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("theme_setting_{$setting->key}");
        }
        Cache::forget('all_theme_settings');
    }
}
