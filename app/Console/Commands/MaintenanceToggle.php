<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class MaintenanceToggle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:toggle {status=toggle : on, off, or toggle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Toggle maintenance mode on/off';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $status = $this->argument('status');
        $currentStatus = Setting::where('key', 'maintenance_mode')->first();
        $currentValue = $currentStatus ? $currentStatus->value : '0';

        switch ($status) {
            case 'on':
                $newValue = '1';
                break;
            case 'off':
                $newValue = '0';
                break;
            case 'toggle':
            default:
                $newValue = $currentValue == '1' ? '0' : '1';
                break;
        }

        Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $newValue]);

        $statusText = $newValue == '1' ? 'ON' : 'OFF';
        $this->info("Maintenance mode is now: {$statusText}");
        
        if ($newValue == '1') {
            $this->comment("Website is now in maintenance mode for visitors.");
            $this->comment("Admin can still access: " . url('/admin'));
        } else {
            $this->comment("Website is now accessible to all users.");
        }

        return 0;
    }
}
