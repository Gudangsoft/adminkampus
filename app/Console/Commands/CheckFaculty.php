<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Faculty;

class CheckFaculty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:faculty {slug?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check faculty data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $slug = $this->argument('slug');
        
        if ($slug) {
            $faculty = Faculty::where('slug', $slug)->first();
            if ($faculty) {
                $this->info("Faculty found: " . $faculty->name);
                $this->info("Slug: " . $faculty->slug);
                $this->info("Status: " . ($faculty->is_active ? 'Active' : 'Inactive'));
            } else {
                $this->error("Faculty with slug '$slug' not found");
                $this->info("Available faculties:");
                Faculty::all()->each(function($faculty) {
                    $this->line("- " . $faculty->name . " (slug: " . $faculty->slug . ")");
                });
            }
        } else {
            $this->info("All faculties:");
            Faculty::all()->each(function($faculty) {
                $this->line("- " . $faculty->name . " (slug: " . $faculty->slug . ", active: " . ($faculty->is_active ? 'yes' : 'no') . ")");
            });
        }
    }
}
