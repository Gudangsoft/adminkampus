<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Global Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-center mb-4">🔍 Test Global Search System</h1>
                
                <!-- Test Search Component -->
                @include('components.global-search')
                
                <!-- Test API Endpoints -->
                <div class="mt-5">
                    <h3>🧪 Test API Endpoints</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary w-100" onclick="testSearchAPI()">
                                Test Search API
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success w-100" onclick="testSuggestionsAPI()">
                                Test Suggestions API  
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h5>API Response:</h5>
                        <pre id="apiResponse" class="bg-light p-3" style="height: 300px; overflow-y: auto;">
Click a test button to see API response...
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function testSearchAPI() {
            const responseElement = document.getElementById('apiResponse');
            responseElement.textContent = 'Loading...';
            
            try {
                const response = await fetch('/api/search?q=kampus&type=all&limit=10');
                const data = await response.json();
                responseElement.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                responseElement.textContent = 'Error: ' + error.message;
            }
        }
        
        async function testSuggestionsAPI() {
            const responseElement = document.getElementById('apiResponse');
            responseElement.textContent = 'Loading...';
            
            try {
                const response = await fetch('/api/search/suggestions?q=berita');
                const data = await response.json();
                responseElement.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                responseElement.textContent = 'Error: ' + error.message;
            }
        }
    </script>
</body>
</html>
