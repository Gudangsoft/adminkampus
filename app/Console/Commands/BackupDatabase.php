<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database {--compress : Create compressed backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database backup...');
        
        // Get database configuration
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        $host = config("database.connections.{$connection}.host");
        $port = config("database.connections.{$connection}.port");
        $username = config("database.connections.{$connection}.username");
        $password = config("database.connections.{$connection}.password");
        
        // Generate timestamp
        $timestamp = Carbon::now()->format('Ymd_His');
        
        // Create backup directory if not exists
        $backupPath = storage_path('backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        // Generate backup filename
        $filename = "{$database}_backup_{$timestamp}.sql";
        $filepath = $backupPath . DIRECTORY_SEPARATOR . $filename;
        
        $this->info("Database: {$database}");
        $this->info("Timestamp: {$timestamp}");
        $this->info("Output: {$filepath}");
        
        // Build mysqldump command
        $command = "mysqldump";
        $command .= " -h {$host}";
        $command .= " --port={$port}";
        $command .= " -u {$username}";
        
        if (!empty($password)) {
            $command .= " -p{$password}";
        }
        
        $command .= " --single-transaction";
        $command .= " --routines";
        $command .= " --triggers";
        $command .= " {$database}";
        
        if ($this->option('compress')) {
            $filename .= '.gz';
            $filepath .= '.gz';
            $command .= " | gzip";
        }
        
        $command .= " > \"{$filepath}\"";
        
        $this->info('Creating backup...');
        
        // Execute backup command
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        
        if ($returnVar === 0 && file_exists($filepath)) {
            $fileSize = filesize($filepath);
            $fileSizeKB = round($fileSize / 1024, 2);
            
            $this->info("✓ Backup created successfully!");
            $this->info("File: {$filename}");
            $this->info("Size: {$fileSizeKB} KB");
            
            // Clean up old backups (keep last 10)
            $this->cleanupOldBackups($backupPath);
            
            $this->info('Database backup completed successfully!');
            return 0;
        } else {
            $this->error('❌ Backup failed!');
            if (!empty($output)) {
                $this->error('Error output: ' . implode("\n", $output));
            }
            return 1;
        }
    }
    
    /**
     * Clean up old backup files
     */
    private function cleanupOldBackups($backupPath)
    {
        $this->info('Cleaning up old backups...');
        
        $files = glob($backupPath . DIRECTORY_SEPARATOR . '*_backup_*.sql*');
        
        // Sort files by modification time (newest first)
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        // Keep only the 10 most recent backups
        $filesToDelete = array_slice($files, 10);
        
        foreach ($filesToDelete as $file) {
            if (unlink($file)) {
                $this->info("Removed old backup: " . basename($file));
            }
        }
        
        if (count($filesToDelete) > 0) {
            $this->info("✓ Cleaned up " . count($filesToDelete) . " old backup(s)");
        } else {
            $this->info("No old backups to clean up");
        }
    }
}
