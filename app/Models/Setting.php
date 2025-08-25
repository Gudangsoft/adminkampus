<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 
        'value', 
        'label', 
        'type', 
        'group', 
        'description', 
        'is_editable'
    ];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function getGroup($group)
    {
        return static::where('group', $group)->pluck('value', 'key')->toArray();
    }

    public static function getLogo($type = 'site_logo', $default = null)
    {
        $logo = static::get($type);
        if ($logo && file_exists(public_path('storage/' . $logo))) {
            return asset('storage/' . $logo);
        }
        return $default;
    }
}
