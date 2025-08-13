<?php
// Debug route untuk analytics

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AnalyticsController;

Route::get('/test-analytics-response', function() {
    try {
        echo "<h1>Analytics Response Debug</h1>";
        
        // Simulate authenticated request
        $user = \App\Models\User::first();
        if ($user) {
            auth()->login($user);
            echo "<p>✅ User authenticated: {$user->email}</p>";
        } else {
            echo "<p>❌ No user found</p>";
            return;
        }
        
        // Create controller instance and call index
        $controller = new AnalyticsController();
        
        echo "<h2>Calling Analytics Controller...</h2>";
        
        $response = $controller->index();
        
        echo "<h3>Response Type: " . get_class($response) . "</h3>";
        
        if ($response instanceof \Illuminate\View\View) {
            echo "<p>✅ View response received</p>";
            echo "<p>View name: " . $response->getName() . "</p>";
            
            $data = $response->getData();
            echo "<h3>View Data:</h3>";
            echo "<pre>";
            foreach ($data as $key => $value) {
                echo $key . " => ";
                if (is_array($value)) {
                    echo "Array with " . count($value) . " items\n";
                } elseif (is_object($value)) {
                    echo get_class($value) . "\n";
                } else {
                    echo $value . "\n";
                }
            }
            echo "</pre>";
            
            // Try to render the view
            echo "<h3>Attempting to render view...</h3>";
            try {
                $html = $response->render();
                echo "<p>✅ View rendered successfully</p>";
                echo "<p>HTML length: " . strlen($html) . " characters</p>";
                
                // Check if it contains expected content
                if (strpos($html, 'Analytics Dashboard') !== false) {
                    echo "<p>✅ Contains title</p>";
                } else {
                    echo "<p>❌ Missing title</p>";
                }
                
                if (strpos($html, 'Total Berita') !== false) {
                    echo "<p>✅ Contains stats cards</p>";
                } else {
                    echo "<p>❌ Missing stats cards</p>";
                }
                
                // Show first 500 characters
                echo "<h4>First 500 characters of rendered HTML:</h4>";
                echo "<textarea style='width:100%;height:200px;'>" . htmlspecialchars(substr($html, 0, 500)) . "</textarea>";
                
            } catch (Exception $e) {
                echo "<p style='color:red'>❌ Error rendering view: " . $e->getMessage() . "</p>";
                echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
            }
        } else {
            echo "<p>❌ Unexpected response type</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
});
