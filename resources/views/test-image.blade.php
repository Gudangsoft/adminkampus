<!DOCTYPE html>
<html>
<head>
    <title>Test Gambar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Test Gambar</h1>
    
    @php
        $news = \App\Models\News::whereNotNull('featured_image')->first();
        $imagePath = 'news/1754717316_seminar-nasional-ai-dan-masa-depan-teknologi.jpeg';
        $storageUrl = Storage::url($imagePath);
        $assetUrl = asset('storage/' . $imagePath);
    @endphp
    
    <div class="row">
        <div class="col-md-6">
            <h3>Direct Image Test</h3>
            <p><strong>Path:</strong> {{ $imagePath }}</p>
            <p><strong>Storage::url():</strong> {{ $storageUrl }}</p>
            <p><strong>asset():</strong> {{ $assetUrl }}</p>
            <img src="{{ $storageUrl }}" class="img-fluid border" alt="Test Image via Storage::url()">
        </div>
        
        <div class="col-md-6">
            <h3>Asset URL Test</h3>
            <img src="{{ $assetUrl }}" class="img-fluid border" alt="Test Image via asset()">
        </div>
    </div>
    
    @if($news)
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>News Model Test</h3>
            <p><strong>News ID:</strong> {{ $news->id }}</p>
            <p><strong>Featured Image:</strong> {{ $news->featured_image }}</p>
            <p><strong>Featured Image URL:</strong> {{ $news->featured_image_url }}</p>
            <img src="{{ $news->featured_image_url }}" class="img-fluid border" alt="Test via Model">
        </div>
    </div>
    @endif
    
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>File System Check</h3>
            @php
                $fullPath = storage_path('app/public/news/1754717316_seminar-nasional-ai-dan-masa-depan-teknologi.jpeg');
                $fileExists = file_exists($fullPath);
                $fileSize = $fileExists ? filesize($fullPath) : 0;
            @endphp
            <p><strong>Full Path:</strong> {{ $fullPath }}</p>
            <p><strong>File Exists:</strong> {{ $fileExists ? 'Yes' : 'No' }}</p>
            <p><strong>File Size:</strong> {{ number_format($fileSize) }} bytes</p>
        </div>
    </div>
</div>
</body>
</html>
