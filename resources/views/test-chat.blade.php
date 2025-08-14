<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Live Chat Widget</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f8f9fa;
        }
        .test-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn {
            background: #667eea; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🔧 Test Live Chat Widget</h1>
        <p>Halaman ini untuk menguji apakah widget chat muncul dengan benar.</p>
        
        <div class="status success">
            ✅ Alpine.js loaded: <span id="alpine-status">Checking...</span>
        </div>
        
        <div class="status warning">
            ⚠️ Lihat pojok kanan bawah untuk widget chat
        </div>
        
        <div class="status warning">
            💡 Jika chat tidak muncul, buka Developer Tools (F12) dan cek Console untuk error
        </div>
        
        <hr style="margin: 30px 0;">
        
        <h2>📋 Test Checklist:</h2>
        <ul>
            <li>✅ Config live-chat sudah enabled</li>
            <li>✅ Component live-chat.blade.php ada</li>
            <li>✅ Layout app.blade.php include component</li>
            <li>✅ Alpine.js script loaded</li>
            <li>❓ Chat widget visible (check bottom-right)</li>
        </ul>
        
        <hr style="margin: 30px 0;">
        
        <h2>🎯 Manual Test:</h2>
        <button onclick="testChatWidget()" class="btn">
            Test Chat Widget
        </button>
        
        <button onclick="showChatManually()" class="btn">
            Force Show Chat
        </button>
        
        <a href="{{ url('/') }}" class="btn" style="background: #28a745; text-decoration: none; display: inline-block;">
            Go to Homepage
        </a>
        
        <div id="test-result" style="margin-top: 15px;"></div>
        
        <h2>📱 Content untuk Test Chat:</h2>
        <p>Ini adalah halaman test dengan konten dummy untuk melihat chat widget.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        
        <div style="height: 800px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); margin: 20px 0; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
            <div style="text-align: center;">
                <h3>Scroll Test Area</h3>
                <p>Area ini untuk test scroll dan melihat posisi chat widget</p>
                <p>Chat widget harus tetap terlihat di pojok kanan bawah</p>
            </div>
        </div>
        
    </div>
    
    <!-- Include Live Chat Component -->
    @include('components.live-chat')
    
    <script>
        // Check if Alpine.js is loaded
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alpineStatus = document.getElementById('alpine-status');
                if (window.Alpine) {
                    alpineStatus.textContent = '✅ Yes';
                    alpineStatus.style.color = 'green';
                } else {
                    alpineStatus.textContent = '❌ No';
                    alpineStatus.style.color = 'red';
                }
            }, 1000);
        });
        
        function testChatWidget() {
            const resultDiv = document.getElementById('test-result');
            resultDiv.innerHTML = ''; // Clear previous results
            
            // Check if chat widget element exists
            const chatWidget = document.querySelector('.chat-widget');
            if (chatWidget) {
                resultDiv.innerHTML += '<div class="status success">✅ Chat widget element found in DOM</div>';
                
                // Try to find the toggle button
                const toggleButton = document.querySelector('.chat-toggle');
                if (toggleButton) {
                    resultDiv.innerHTML += '<div class="status success">✅ Chat toggle button found</div>';
                    
                    // Check if button is visible
                    const rect = toggleButton.getBoundingClientRect();
                    if (rect.width > 0 && rect.height > 0) {
                        resultDiv.innerHTML += '<div class="status success">✅ Chat toggle button is visible</div>';
                    } else {
                        resultDiv.innerHTML += '<div class="status warning">⚠️ Chat toggle button exists but not visible</div>';
                    }
                    
                    // Try to trigger click
                    try {
                        toggleButton.click();
                        resultDiv.innerHTML += '<div class="status success">✅ Chat toggle clicked - check if chat opens</div>';
                    } catch (e) {
                        resultDiv.innerHTML += '<div class="status error">❌ Error clicking chat toggle: ' + e.message + '</div>';
                    }
                } else {
                    resultDiv.innerHTML += '<div class="status warning">⚠️ Chat toggle button not found</div>';
                }
            } else {
                resultDiv.innerHTML = '<div class="status error">❌ Chat widget element not found in DOM</div>';
            }
        }
        
        function showChatManually() {
            // Create a manual chat widget for testing
            const existingManual = document.getElementById('manual-chat');
            if (existingManual) {
                existingManual.remove();
            }
            
            const manualChat = document.createElement('div');
            manualChat.id = 'manual-chat';
            manualChat.innerHTML = `
                <div style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 50px; padding: 15px 25px; cursor: pointer; box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);" onclick="this.parentElement.remove()">
                    <i class="fas fa-comments" style="margin-right: 10px;"></i>
                    Manual Test Chat - Click to Remove
                </div>
            `;
            document.body.appendChild(manualChat);
            
            const resultDiv = document.getElementById('test-result');
            resultDiv.innerHTML += '<div class="status success">✅ Manual chat widget created - look at bottom right</div>';
        }
        
        // Log any errors to console
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
        });
        
        // Log Alpine.js events
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized');
        });
    </script>
</body>
</html>
