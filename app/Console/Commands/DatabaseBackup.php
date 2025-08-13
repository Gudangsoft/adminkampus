<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup 
                            {--compress : Compress the backup file}
                            {--tables=* : Specific tables to backup}
                            {--path= : Custom backup path}';

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

        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $dbName = config('database.connections.mysql.database');
            $fileName = "backup_{$dbName}_{$timestamp}.sql";
            
            if ($this->option('compress')) {
                $fileName .= '.gz';
            }

            $backupPath = $this->option('path') ?: storage_path('app/backups');
            
            // Create backup directory if it doesn't exist
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $fullPath = $backupPath . '/' . $fileName;

            // Get database configuration
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s --routines --triggers %s',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($dbName)
            );

            // Add specific tables if provided
            $tables = $this->option('tables');
            if (!empty($tables)) {
                $command .= ' ' . implode(' ', array_map('escapeshellarg', $tables));
            }

            // Add compression if requested
            if ($this->option('compress')) {
                $command .= ' | gzip';
            }

            $command .= ' > ' . escapeshellarg($fullPath);

            // Execute backup command
            $result = null;
            $output = [];
            exec($command, $output, $result);

            if ($result === 0) {
                $fileSize = $this->formatBytes(filesize($fullPath));
                
                $this->info("✅ Backup completed successfully!");
                $this->info("📁 File: {$fileName}");
                $this->info("📏 Size: {$fileSize}");
                $this->info("📍 Location: {$fullPath}");

                // Log backup
                $this->logBackup($fileName, $fullPath, filesize($fullPath));

                // Clean old backups
                $this->cleanOldBackups($backupPath);

                return Command::SUCCESS;
            } else {
                $this->error("❌ Backup failed!");
                $this->error("Output: " . implode("\n", $output));
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $this->error("❌ Backup failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Log backup information
     */
    private function logBackup($fileName, $filePath, $fileSize)
    {
        $logData = [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'filename' => $fileName,
            'path' => $filePath,
            'size' => $fileSize,
            'database' => config('database.connections.mysql.database'),
        ];

        $logFile = storage_path('app/backups/backup_log.json');
        $logs = [];

        if (file_exists($logFile)) {
            $logs = json_decode(file_get_contents($logFile), true) ?? [];
        }

        $logs[] = $logData;

        // Keep only last 50 backup logs
        $logs = array_slice($logs, -50);

        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }

    /**
     * Clean old backup files
     */
    private function cleanOldBackups($backupPath)
    {
        $retentionDays = config('backup.retention_days', 30);
        $cutoffDate = Carbon::now()->subDays($retentionDays);
        
        $files = glob($backupPath . '/backup_*.sql*');
        $deletedCount = 0;

        foreach ($files as $file) {
            $fileDate = Carbon::createFromTimestamp(filemtime($file));
            
            if ($fileDate->lt($cutoffDate)) {
                unlink($file);
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            $this->info("🧹 Cleaned {$deletedCount} old backup files");
        }
    }

    /**
     * Format file size
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
