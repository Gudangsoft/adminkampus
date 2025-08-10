@extends('layouts.app')
@section('title', 'Homepage - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@push('styles')
<style>
    .section-content {
        line-height: 1.6;
    }
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 60vh;
    }
    .card-section {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .card-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    
    /* Slider Styles */
    .slider-container {
        position: relative;
        height: 500px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .slider-item {
        height: 500px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .slider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
        display: flex;
        align-items: center;
    }
    .slider-content {
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .slider-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .slider-description {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .slider-btn {
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    .slider-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 60px;
        height: 60px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        color: #333;
    }
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: rgba(255,255,255,1);
        color: #000;
    }
    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 4px;
        background-color: rgba(255,255,255,0.6);
        border: none;
    }
    .carousel-indicators .active {
        background-color: #fff;
    }
</style>
@endpush



@section('content')

<!-- Hero Section -->
<section class="hero-section text-white d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">{{ $globalSettings['site_name'] ?? 'KESOSI' }}</h1>
                <p class="lead mb-4">{{ $globalSettings['site_description'] ?? 'Kampus Kesehatan Modern' }}</p>
                <div class="d-flex gap-3">
                    <a href="#sections" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-down me-2"></i>Jelajahi
                    </a>
                    <a href="/admin/sections" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Kelola Sections
                    </a>
                </div>
            </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-university fa-5x opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Slider -->
    @if(isset($sliders) && $sliders->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Sorotan Kampus</h2>
                <p class="text-muted">Informasi dan berita terkini dari {{ $globalSettings['site_name'] ?? 'KESOSI' }}</p>
            </div>
            
            <div id="campusSlider" class="carousel slide slider-container" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    @foreach($sliders as $index => $slider)
                        <button type="button" data-bs-target="#campusSlider" data-bs-slide-to="{{ $index }}" 
                                class="{{ $index === 0 ? 'active' : '' }}" 
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                
                <!-- Carousel Inner -->
                <div class="carousel-inner">
                    @foreach($sliders as $index => $slider)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="slider-item" style="background-image: url('{{ $slider->image_url }}')">
                                <div class="slider-overlay">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-10">
                                                <div class="slider-content">
                                                    <h2 class="slider-title">{{ $slider->title }}</h2>
                                                    @if($slider->description)
                                                        <p class="slider-description">{{ $slider->description }}</p>
                                                    @endif
                                                    @if($slider->link && $slider->button_text)
                                                        <a href="{{ $slider->link }}" 
                                                           class="btn btn-light btn-lg slider-btn"
                                                           target="{{ $slider->link_target === '_blank' ? '_blank' : '_self' }}">
                                                            {{ $slider->button_text }}
                                                            <i class="fas fa-arrow-right ms-2"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#campusSlider" data-bs-slide="prev">
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#campusSlider" data-bs-slide="next">
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    @endif

  
  
  
    <!-- Featured News Section -->
   
    





    <!-- Dynamic Sections -->
    <section id="sections" class="py-5">
        <div class="container">
            @if($sections->count() > 0)
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Sections Dinamis</h2>
                    <p class="text-muted">{{ $sections->count() }} sections aktif yang dapat dikelola melalui admin</p>
                </div>
                
                <div class="row">
                    @foreach($sections as $section)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card card-section h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-bookmark me-2"></i>
                                        {{ $section->title }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="section-content">
                                        {!! nl2br(e($section->content)) !!}
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <small class="text-muted">
                                        <i class="fas fa-sort me-1"></i>Urutan: {{ $section->order }}
                                        <span class="float-end">
                                            <i class="fas fa-{{ $section->is_active ? 'check text-success' : 'times text-danger' }}"></i>
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Management Link -->
                <div class="text-center mt-5">
                    <a href="/admin/sections" class="btn btn-primary btn-lg">
                        <i class="fas fa-edit me-2"></i>Kelola Sections
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                    <h3>Belum Ada Sections</h3>
                    <p class="text-muted mb-4">Mulai membuat sections untuk mengisi halaman homepage</p>
                    <a href="/admin/sections" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Buat Section Pertama
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<!-- Smooth scroll untuk navigasi -->
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>

<!-- Slider functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize carousel
        const carousel = document.querySelector('#campusSlider');
        if (carousel) {
            // Auto-play functionality (already handled by data-bs-ride="carousel")
            
            // Pause on hover
            carousel.addEventListener('mouseenter', function() {
                const bsCarousel = bootstrap.Carousel.getInstance(this) || new bootstrap.Carousel(this);
                bsCarousel.pause();
            });
            
            // Resume on mouse leave
            carousel.addEventListener('mouseleave', function() {
                const bsCarousel = bootstrap.Carousel.getInstance(this) || new bootstrap.Carousel(this);
                bsCarousel.cycle();
            });
            
            // Touch/swipe support untuk mobile
            let touchStartX = 0;
            let touchEndX = 0;
            
            carousel.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });
            
            carousel.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });
            
            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel) || new bootstrap.Carousel(carousel);
                    
                    if (diff > 0) {
                        // Swipe left - next slide
                        bsCarousel.next();
                    } else {
                        // Swipe right - previous slide
                        bsCarousel.prev();
                    }
                }
            }
        }
    });
</script>
@endpush
