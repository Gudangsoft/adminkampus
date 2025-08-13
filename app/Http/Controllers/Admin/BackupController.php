<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    protected $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
        
        // Ensure backup directory exists
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    public function index()
    {
        $backups = collect(File::files($this->backupPath))
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'created_at' => \Carbon\Carbon::createFromTimestamp($file->getMTime()),
                    'formatted_size' => $this->formatBytes($file->getSize())
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        $totalBackups = $backups->count();
        $totalSize = $backups->sum('size');
        $latestBackup = $backups->first();

        // Database info
        $databaseName = config('database.connections.mysql.database');
        $databaseSizeBytes = $this->getDatabaseSizeBytes();
        $databaseSize = $this->formatBytes($databaseSizeBytes);

        // Create stats array for view
        $stats = [
            'total_backups' => $totalBackups,
            'total_size' => $this->formatBytes($totalSize),
            'latest_backup' => $latestBackup,
            'database_name' => $databaseName,
            'database_size' => $databaseSize
        ];

        return view('admin.backups.index', compact(
            'backups',
            'stats',
            'databaseName'
        ));
    }

    public function create(Request $request)
    {
        $request->validate([
            'compress' => 'boolean'
        ]);

        try {
            $compress = $request->boolean('compress', true);
            
            // Run the backup command
            Artisan::call('db:backup', [
                '--compress' => $compress
            ]);
            
            $output = Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Database backup created successfully',
                'output' => trim($output)
            ]);

        } catch (\Exception $e) {
            \Log::error('Backup creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download($filename)
    {
        $filePath = $this->backupPath . '/' . $filename;
        
        if (!File::exists($filePath)) {
            return redirect()->route('admin.backups.index')
                           ->with('error', 'Backup file not found');
        }
        
        return response()->download($filePath);
    }

    public function destroy($filename)
    {
        try {
            $filePath = $this->backupPath . '/' . $filename;
            
            if (!File::exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Backup file not found'
                ], 404);
            }
            
            File::delete($filePath);
            
            return response()->json([
                'success' => true,
                'message' => 'Backup deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete backup: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function formatBytes($size, $precision = 2)
    {
        // Ensure we have a numeric value
        if (!is_numeric($size) || $size == 0) {
            return '0 B';
        }
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    protected function getDatabaseSizeBytes()
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            
            $result = \DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length), 0) AS DB_SIZE_BYTES
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [$databaseName]);
            
            return (int) ($result[0]->DB_SIZE_BYTES ?? 0);
            
        } catch (\Exception $e) {
            return 0;
        }
    }

    protected function getDatabaseSize()
    {
        $bytes = $this->getDatabaseSizeBytes();
        return $this->formatBytes($bytes);
    }
}
