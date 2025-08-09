<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_editable'
    ];

    protected $casts = [
        'is_editable' => 'boolean'
    ];

    protected $attributes = [
        'type' => 'text',
        'group' => 'general',
        'label' => '',
        'is_editable' => true
    ];

    public static function get($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        Cache::forget("setting.{$key}");
        return $setting;
    }

    public static function getGroup($group)
    {
        return Cache::remember("settings.group.{$group}", 3600, function () use ($group) {
            return static::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }

    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'json':
                return json_decode($value, true);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            default:
                return $value;
        }
    }

    public function setValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                $this->attributes['value'] = $value ? '1' : '0';
                break;
            case 'json':
                $this->attributes['value'] = json_encode($value);
                break;
            default:
                $this->attributes['value'] = $value;
        }
    }

    protected static function boot()
    {
        parent::boot();
        
        static::saved(function ($model) {
            Cache::forget("setting.{$model->key}");
            Cache::forget("settings.group.{$model->group}");
        });
        
        static::deleted(function ($model) {
            Cache::forget("setting.{$model->key}");
            Cache::forget("settings.group.{$model->group}");
        });
    }
}
