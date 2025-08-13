<?php

use Illuminate\Support\Facades\Route;

// Debug route untuk analytics - tambahkan sementara di web.php
Route::get('/debug-analytics', function() {
    try {
        // Test basic Laravel functionality
        echo "<h1>Debug Analytics</h1>";
        
        // Test controller exists
        if (class_exists('App\Http\Controllers\Admin\AnalyticsController')) {
            echo "<p>✅ AnalyticsController exists</p>";
        } else {
            echo "<p>❌ AnalyticsController missing</p>";
        }
        
        // Test models exist
        $models = [
            'App\Models\News',
            'App\Models\Announcement', 
            'App\Models\Gallery',
            'App\Models\Faculty',
            'App\Models\StudyProgram',
            'App\Models\Student',
            'App\Models\Lecturer',
            'App\Models\User'
        ];
        
        foreach ($models as $model) {
            if (class_exists($model)) {
                try {
                    $count = $model::count();
                    echo "<p>✅ {$model}: {$count} records</p>";
                } catch (Exception $e) {
                    echo "<p>⚠️ {$model}: Error - {$e->getMessage()}</p>";
                }
            } else {
                echo "<p>❌ {$model}: Missing</p>";
            }
        }
        
        // Test analytics controller directly
        echo "<h2>Testing Analytics Controller</h2>";
        $controller = new App\Http\Controllers\Admin\AnalyticsController();
        
        // Call private method through reflection
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod('getBasicStats');
        $method->setAccessible(true);
        
        $stats = $method->invoke($controller);
        echo "<pre>" . print_r($stats, true) . "</pre>";
        
        // Test view exists
        if (view()->exists('admin.analytics.index')) {
            echo "<p>✅ Analytics view exists</p>";
        } else {
            echo "<p>❌ Analytics view missing</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
});
