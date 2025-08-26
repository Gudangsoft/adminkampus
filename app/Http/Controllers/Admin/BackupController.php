<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function create()
    {
        return view('admin.backup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:database,files,full'
        ]);

        try {
            $backupPath = $this->createBackup($request->type, $request->name);
            
            return redirect()->route('admin.backup.index')
                           ->with('success', 'Backup berhasil dibuat: ' . basename($backupPath));
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan.');
        }

        return response()->download($path);
    }

    public function destroy($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (file_exists($path)) {
            unlink($path);
            return redirect()->back()->with('success', 'Backup berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'File backup tidak ditemukan.');
    }

    private function createBackup($type, $name)
    {
        $timestamp = date('Y-m-d_H-i-s');
        $backupDir = storage_path('app/backups');
        
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename = "{$name}_{$type}_{$timestamp}.backup";
        $filepath = $backupDir . '/' . $filename;

        // Create a simple backup file
        file_put_contents($filepath, json_encode([
            'type' => $type,
            'name' => $name,
            'created_at' => now(),
            'data' => 'Backup created successfully'
        ]));

        return $filepath;
    }
}
