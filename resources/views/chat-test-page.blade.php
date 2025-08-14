@extends('layouts.app')

@section('title', 'Test Live Chat')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>🔧 Live Chat Test Page</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Halaman ini untuk menguji widget live chat
                    </div>
                    
                    <h5>✅ Checklist:</h5>
                    <ul>
                        <li>Layout app.blade.php dimuat</li>
                        <li>Alpine.js script dimuat</li>
                        <li>Component live-chat disertakan</li>
                        <li>CSS dengan z-index tinggi</li>
                    </ul>
                    
                    <div class="mt-4">
                        <button onclick="checkChatWidget()" class="btn btn-primary">
                            <i class="fas fa-search"></i> Check Chat Widget
                        </button>
                        
                        <button onclick="createTestWidget()" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create Test Widget
                        </button>
                    </div>
                    
                    <div id="test-results" class="mt-3"></div>
                    
                    <div style="height: 500px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); margin: 20px 0; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                        <div style="text-align: center;">
                            <h4>Test Content Area</h4>
                            <p>Periksa pojok kanan bawah untuk chat widget</p>
                            <p>Widget harus muncul dengan z-index tinggi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkChatWidget() {
    const results = document.getElementById('test-results');
    results.innerHTML = '';
    
    // Check Alpine.js
    if (window.Alpine) {
        results.innerHTML += '<div class="alert alert-success">✅ Alpine.js loaded</div>';
    } else {
        results.innerHTML += '<div class="alert alert-danger">❌ Alpine.js not loaded</div>';
    }
    
    // Check chat widget
    const chatWidget = document.querySelector('.chat-widget');
    if (chatWidget) {
        results.innerHTML += '<div class="alert alert-success">✅ Chat widget element found</div>';
        
        const computedStyle = window.getComputedStyle(chatWidget);
        results.innerHTML += `<div class="alert alert-info">
            📊 Widget styles:<br>
            - Position: ${computedStyle.position}<br>
            - Z-index: ${computedStyle.zIndex}<br>
            - Bottom: ${computedStyle.bottom}<br>
            - Right: ${computedStyle.right}<br>
            - Visibility: ${computedStyle.visibility}<br>
            - Display: ${computedStyle.display}
        </div>`;
        
        const toggleBtn = chatWidget.querySelector('.chat-toggle');
        if (toggleBtn) {
            results.innerHTML += '<div class="alert alert-success">✅ Chat toggle button found</div>';
            
            // Check if visible
            const rect = toggleBtn.getBoundingClientRect();
            if (rect.width > 0 && rect.height > 0) {
                results.innerHTML += '<div class="alert alert-success">✅ Toggle button is visible</div>';
            } else {
                results.innerHTML += '<div class="alert alert-warning">⚠️ Toggle button exists but not visible</div>';
            }
        } else {
            results.innerHTML += '<div class="alert alert-warning">⚠️ Chat toggle button not found</div>';
        }
    } else {
        results.innerHTML += '<div class="alert alert-danger">❌ Chat widget element not found</div>';
    }
}

function createTestWidget() {
    // Remove existing test widget
    const existing = document.getElementById('test-widget');
    if (existing) existing.remove();
    
    // Create test widget
    const testWidget = document.createElement('div');
    testWidget.id = 'test-widget';
    testWidget.innerHTML = `
        <div style="position: fixed; bottom: 20px; left: 20px; z-index: 9999; background: #28a745; color: white; padding: 15px; border-radius: 50px; cursor: pointer; box-shadow: 0 4px 20px rgba(40, 167, 69, 0.4);" onclick="this.parentElement.remove()">
            <i class="fas fa-check"></i> Test Widget - Click to Remove
        </div>
    `;
    document.body.appendChild(testWidget);
    
    const results = document.getElementById('test-results');
    results.innerHTML += '<div class="alert alert-success">✅ Test widget created on left side</div>';
}

// Auto-check on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        checkChatWidget();
    }, 2000);
});
</script>
@endsection
