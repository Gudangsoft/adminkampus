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
        <button onclick="testChatWidget()" class="btn" style="background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Test Chat Widget
        </button>
        
        <div id="test-result" style="margin-top: 15px;"></div>
        
        <h2>📱 Content untuk Test Chat:</h2>
        <p>Ini adalah halaman test dengan konten dummy untuk melihat chat widget.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        
    </div>
    
    <!-- Include Live Chat Component -->
    <?php
    // Manual include of live chat component for testing
    $config = [
        'enabled' => true,
        'position' => 'right',
        'title' => 'Butuh Bantuan?',
        'button_text' => 'Butuh Bantuan?',
        'welcome_message' => 'Halo! Ada yang bisa kami bantu? 😊',
        'auto_responses' => [],
        'fallback_response' => 'Terima kasih atas pertanyaan Anda.',
        'contact_info' => []
    ];
    $isEnabled = $config['enabled'] ?? true;
    $position = $config['position'] ?? 'right';
    $title = $config['title'] ?? 'Butuh Bantuan?';
    $welcomeMessage = $config['welcome_message'] ?? 'Halo! Ada yang bisa kami bantu?';
    $autoResponses = $config['auto_responses'] ?? [];
    $fallbackResponse = $config['fallback_response'] ?? 'Terima kasih atas pertanyaan Anda.';
    $contactInfo = $config['contact_info'] ?? [];
    ?>
    
    <?php if($isEnabled): ?>
    <!-- Live Chat Widget -->
    <div class="chat-widget" 
         data-position="<?php echo $position; ?>"
         x-data="chatWidget(<?php echo json_encode([
             'title' => $title,
             'welcomeMessage' => $welcomeMessage,
             'autoResponses' => $autoResponses,
             'fallbackResponse' => $fallbackResponse,
             'contactInfo' => $contactInfo
         ]); ?>)" 
         x-init="init()">
        <!-- Chat Toggle Button -->
        <div class="chat-toggle" 
             :class="{ 'active': isOpen }"
             @click="toggleChat()"
             x-show="!isOpen"
             style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 50px; padding: 15px 25px; cursor: pointer; box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);">
            <div class="chat-toggle-content" style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-comments"></i>
                <span class="chat-toggle-text">Butuh Bantuan?</span>
            </div>
        </div>
        
        <!-- Simple Chat Window -->
        <div class="chat-window" 
             x-show="isOpen"
             style="position: fixed; bottom: 20px; right: 20px; width: 350px; height: 500px; background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); z-index: 1001; display: none;"
             x-transition>
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border-radius: 15px 15px 0 0;">
                <h6 style="margin: 0;">Asisten Virtual</h6>
                <button @click="closeChat()" style="position: absolute; top: 10px; right: 15px; background: none; border: none; color: white; font-size: 20px; cursor: pointer;">×</button>
            </div>
            <div style="padding: 15px; height: 400px; overflow-y: auto;">
                <p>Halo! Ada yang bisa kami bantu? 😊</p>
            </div>
            <div style="padding: 15px; border-top: 1px solid #eee;">
                <input type="text" placeholder="Ketik pesan..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 25px;">
            </div>
        </div>
    </div>
    
    <script>
    function chatWidget(config = {}) {
        return {
            isOpen: false,
            messages: [],
            currentMessage: '',
            
            init() {
                console.log('Chat widget initialized with config:', config);
            },
            
            toggleChat() {
                this.isOpen = !this.isOpen;
                console.log('Chat toggled, isOpen:', this.isOpen);
            },
            
            closeChat() {
                this.isOpen = false;
                console.log('Chat closed');
            }
        }
    }
    </script>
    <?php endif; ?>
    
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
            
            // Check if chat widget element exists
            const chatWidget = document.querySelector('.chat-widget');
            if (chatWidget) {
                resultDiv.innerHTML = '<div class="status success">✅ Chat widget element found in DOM</div>';
                
                // Try to find the toggle button
                const toggleButton = document.querySelector('.chat-toggle');
                if (toggleButton) {
                    resultDiv.innerHTML += '<div class="status success">✅ Chat toggle button found</div>';
                    
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
        
        // Log any errors to console
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
        });
    </script>
</body>
</html>
