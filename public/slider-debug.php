<!DOCTYPE html>
<html>
<head>
    <title>Slider Debug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Slider Debug Test</h1>
        
        <?php
        // Simulate Laravel environment
        require_once __DIR__ . '/../vendor/autoload.php';
        
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        
        use App\Models\Slider;
        
        $sliders = Slider::active()->ordered()->get();
        ?>
        
        <p>Total Active Sliders: <?= $sliders->count() ?></p>
        
        <?php if($sliders->count() > 0): ?>
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach($sliders as $index => $slider): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <img src="<?= $slider->image_url ?>" class="d-block w-100" alt="<?= $slider->title ?>" style="height: 400px; object-fit: cover;">
                    <div class="carousel-caption d-md-block">
                        <h5><?= $slider->title ?></h5>
                        <p><?= $slider->description ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
        
        <div class="mt-4">
            <h3>Slider Details:</h3>
            <?php foreach($sliders as $slider): ?>
            <div class="card mb-2">
                <div class="card-body">
                    <h6>ID: <?= $slider->id ?> - <?= $slider->title ?></h6>
                    <p>Image: <?= $slider->image ?></p>
                    <p>Image URL: <a href="<?= $slider->image_url ?>" target="_blank"><?= $slider->image_url ?></a></p>
                    <p>Active: <?= $slider->is_active ? 'Yes' : 'No' ?></p>
                    <p>Sort: <?= $slider->sort_order ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php else: ?>
        <div class="alert alert-warning">No active sliders found!</div>
        <?php endif; ?>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
