<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== TESTING DEGREE DROPDOWN SYNCHRONIZATION ===\n\n";

// Test create page
echo "1. Testing CREATE page dropdown options...\n";
$createResponse = $kernel->handle(
    $createRequest = Illuminate\Http\Request::create('/admin/study-programs/create', 'GET')
);

if ($createResponse->getStatusCode() === 200) {
    echo "✓ Create page loads successfully\n";
    $createContent = $createResponse->getContent();
    
    // Extract degree options from create page
    $createOptions = [];
    if (preg_match_all('/<option value="([^"]*)"[^>]*>([^<]+)<\/option>/', $createContent, $matches)) {
        for ($i = 0; $i < count($matches[1]); $i++) {
            $value = $matches[1][$i];
            $text = $matches[2][$i];
            if (!empty($value)) {
                $createOptions[$value] = $text;
            }
        }
    }
    
    echo "CREATE page degree options:\n";
    foreach ($createOptions as $value => $text) {
        echo "  - $value: $text\n";
    }
} else {
    echo "✗ Create page failed to load\n";
}

echo "\n2. Testing EDIT page dropdown options...\n";

// We need to test with an existing study program
// Let's check what study programs exist first
try {
    $studyPrograms = \App\Models\StudyProgram::limit(1)->get();
    
    if ($studyPrograms->count() > 0) {
        $studyProgram = $studyPrograms->first();
        $editResponse = $kernel->handle(
            $editRequest = Illuminate\Http\Request::create('/admin/study-programs/' . $studyProgram->slug . '/edit', 'GET')
        );
        
        if ($editResponse->getStatusCode() === 200) {
            echo "✓ Edit page loads successfully\n";
            $editContent = $editResponse->getContent();
            
            // Extract degree options from edit page
            $editOptions = [];
            if (preg_match_all('/<option value="([^"]*)"[^>]*>([^<]+)<\/option>/', $editContent, $matches)) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $value = $matches[1][$i];
                    $text = $matches[2][$i];
                    if (!empty($value)) {
                        $editOptions[$value] = $text;
                    }
                }
            }
            
            echo "EDIT page degree options:\n";
            foreach ($editOptions as $value => $text) {
                echo "  - $value: $text\n";
            }
            
            echo "\n3. Comparing options...\n";
            
            // Compare options
            $createKeys = array_keys($createOptions);
            $editKeys = array_keys($editOptions);
            
            $missingInEdit = array_diff($createKeys, $editKeys);
            $missingInCreate = array_diff($editKeys, $createKeys);
            
            if (empty($missingInEdit) && empty($missingInCreate)) {
                echo "✓ All degree options are synchronized!\n";
            } else {
                echo "✗ Degree options are NOT synchronized:\n";
                
                if (!empty($missingInEdit)) {
                    echo "  Missing in EDIT:\n";
                    foreach ($missingInEdit as $key) {
                        echo "    - $key: " . $createOptions[$key] . "\n";
                    }
                }
                
                if (!empty($missingInCreate)) {
                    echo "  Missing in CREATE:\n";
                    foreach ($missingInCreate as $key) {
                        echo "    - $key: " . $editOptions[$key] . "\n";
                    }
                }
            }
            
            // Check text consistency
            echo "\n4. Checking text format consistency...\n";
            $textInconsistent = false;
            
            foreach ($createOptions as $value => $createText) {
                if (isset($editOptions[$value])) {
                    if ($createText !== $editOptions[$value]) {
                        echo "✗ Text mismatch for $value:\n";
                        echo "  CREATE: $createText\n";
                        echo "  EDIT:   " . $editOptions[$value] . "\n";
                        $textInconsistent = true;
                    }
                }
            }
            
            if (!$textInconsistent) {
                echo "✓ All option texts are consistent!\n";
            }
            
        } else {
            echo "✗ Edit page failed to load\n";
        }
    } else {
        echo "! No study programs found in database\n";
    }
} catch (Exception $e) {
    echo "! Error: " . $e->getMessage() . "\n";
}

echo "\n=== DEGREE DROPDOWN SYNCHRONIZATION TEST COMPLETED ===\n";
echo "📋 The degree dropdown options should now be identical between CREATE and EDIT pages.\n";

if (isset($createRequest)) $kernel->terminate($createRequest, $createResponse);
if (isset($editRequest)) $kernel->terminate($editRequest, $editResponse);
