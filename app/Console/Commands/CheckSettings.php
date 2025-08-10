<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class CheckSettings extends Command
{
    protected $signature = 'check:settings';
    protected $description = 'Check settings data';

    public function handle()
    {
        try {
            $settings = Setting::all();
            $this->info("Settings count: " . $settings->count());
            
            if ($settings->count() > 0) {
                $this->info("Available settings:");
                $settings->each(function($setting) {
                    $this->line("- {$setting->key}: {$setting->value}");
                });
            } else {
                $this->warn("No settings found in database");
            }
        } catch (\Exception $e) {
            $this->error("Error accessing settings: " . $e->getMessage());
        }
    }
}
