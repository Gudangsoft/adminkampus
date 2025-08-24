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
    
    /* Slider Section Isolation */
    .slider-section {
        position: relative;
        z-index: 10;
        margin: 0;
        padding: 0;
        background: #ffffff;
        border-bottom: 2px solid #e2e8f0;
        width: 100%;
        overflow: hidden;
    }
    
    .slider-section::after {
        content: '';
        display: block;
        clear: both;
        height: 0;
    }
    
    /* Slider Styles */
    .slider-container {
        position: relative;
        height: 500px;
        overflow: hidden;
        border-radius: 0;
        box-shadow: none;
        margin: 0;
        width: 100%;
    }
    .slider-item {
        height: 500px;
        background-size: cover;
        background-position: center;
        position: relative;
        width: 100%;
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
        width: 100%;
        height: 100%;
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
    
    /* News Section Isolation */
    .news-section {
        position: relative;
        z-index: 5;
        background: #f8f9fa !important;
        margin-top: 0;
        padding-top: 60px !important;
        clear: both;
        width: 100%;
    }
    
    .news-section::before {
        content: '';
        display: block;
        height: 20px;
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        margin-bottom: 40px;
    }
    
    /* Section Spacer */
    .section-spacer {
        clear: both;
        position: relative;
        z-index: 1;
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    }
    
    /* News Section Styles */
    .news-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
        background: white;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        text-decoration: none;
        color: inherit;
    }
    .news-image {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    .news-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 50%);
        transition: background 0.3s ease;
    }
    .news-card:hover .news-image::before {
        background: linear-gradient(45deg, rgba(102, 126, 234,0.2) 0%, rgba(118, 75, 162,0.1) 50%);
    }
    .news-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(102, 126, 234, 0.95);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .news-date {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(255,255,255,0.95);
        color: #333;
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }
    .news-content {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .news-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.4;
        color: #2d3748;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }
    .news-card:hover .news-title {
        color: #667eea;
    }
    .news-excerpt {
        font-size: 0.95rem;
        color: #718096;
        line-height: 1.6;
        margin-bottom: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    .news-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #a0aec0;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #f7fafc;
    }
    .read-more-btn {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .read-more-btn:hover {
        color: #764ba2;
        text-decoration: none;
        transform: translateX(3px);
    }
    .news-author {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* Featured News Hero Layout */
    .featured-news-hero {
        height: 500px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        transition: all 0.4s ease;
    }
    .featured-news-hero:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.25);
    }
    .featured-news-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: transform 0.4s ease;
    }
    .featured-news-hero:hover .featured-news-bg {
        transform: scale(1.05);
    }
    .featured-news-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.6) 100%);
        display: flex;
        align-items: flex-end;
    }
    .featured-news-content {
        width: 100%;
    }
    .featured-news-title {
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        transition: color 0.3s ease;
    }
    .featured-news-title:hover {
        color: #f8f9fa !important;
    }
    .featured-news-excerpt {
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }
    .featured-news-meta {
        font-size: 0.95rem;
        opacity: 0.9;
    }
    
    /* News Grid Cards */
    .news-card-grid {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    .news-card-grid:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        border-color: #667eea;
    }
    .news-card-image {
        height: 200px;
        overflow: hidden;
    }
    .news-card-image img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .news-card-grid:hover .news-card-image img {
        transform: scale(1.1);
    }
    .news-card-category {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .news-card-content {
        background: white;
    }
    .news-card-meta {
        color: #6c757d !important;
        font-size: 0.85rem;
    }
    .news-card-title {
        color: #2d3748;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    .news-card-grid:hover .news-card-title {
        color: #667eea;
    }
    .news-card-excerpt {
        color: #6c757d;
        line-height: 1.6;
        font-size: 0.9rem;
    }
    .news-card-footer {
        border-top: 1px solid #f8f9fa;
        padding-top: 15px;
        margin-top: 15px;
    }
    .small-news-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        background: white;
    }
    .small-news-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .small-news-image {
        height: 120px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .small-news-category {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(102, 126, 234, 0.9);
        color: white;
        padding: 4px 8px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    .small-news-content {
        padding: 15px;
    }
    .small-news-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 8px;
        line-height: 1.4;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .small-news-excerpt {
        font-size: 0.8rem;
        color: #666;
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .small-news-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: #999;
    }
    
    /* Mini News Cards - Horizontal Layout */
    .mini-news-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border-radius: 12px;
        overflow: hidden;
        height: 120px;
        background: white;
        display: flex;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    .mini-news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        text-decoration: none;
        color: inherit;
    }
    .mini-news-image {
        width: 140px;
        height: 120px;
        background-size: cover;
        background-position: center;
        position: relative;
        flex-shrink: 0;
        overflow: hidden;
    }
    .mini-news-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 50%);
        transition: background 0.3s ease;
    }
    .mini-news-card:hover .mini-news-image::before {
        background: linear-gradient(45deg, rgba(102, 126, 234,0.3) 0%, rgba(118, 75, 162,0.1) 50%);
    }
    .mini-news-category {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(102, 126, 234, 0.95);
        color: white;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .mini-news-content {
        padding: 15px 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
        min-width: 0;
    }
    .mini-news-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 8px;
        line-height: 1.3;
        color: #2d3748;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }
    .mini-news-card:hover .mini-news-title {
        color: #667eea;
    }
    .mini-news-excerpt {
        font-size: 0.8rem;
        color: #718096;
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    .mini-news-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: #a0aec0;
        gap: 10px;
    }
    .mini-news-date {
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }
    .mini-news-views {
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }
    
    /* Study Program (Prodi) Section Styles */
    .prodi-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        background: white;
    }
    .prodi-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.1) !important;
    }
    .prodi-image {
        position: relative;
        overflow: hidden;
    }
    .prodi-image img {
        transition: transform 0.3s ease;
    }
    .prodi-card:hover .prodi-image img {
        transform: scale(1.1);
    }
    .prodi-overlay {
        background: rgba(102, 126, 234, 0.9);
        opacity: 0;
        transition: all 0.3s ease;
    }
    .prodi-card:hover .prodi-overlay {
        opacity: 1;
    }
    .prodi-btn {
        transform: translateY(20px);
        transition: all 0.3s ease;
        border-radius: 25px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .prodi-card:hover .prodi-btn {
        transform: translateY(0);
    }
    .prodi-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    /* Info Terkini Section Styles */
    .hover-transform {
        transition: all 0.3s ease;
    }
    .hover-transform:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
    }
    .hover-bg-white-10 {
        transition: all 0.3s ease;
    }
    .hover-bg-white-10:hover {
        background-color: rgba(255,255,255,0.1) !important;
    }
    .hover-text-light:hover {
        color: rgba(255,255,255,0.8) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .backdrop-blur {
        backdrop-filter: blur(10px);
    }
    
    /* Animation untuk badge urgent */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .animate__animated.animate__pulse {
        animation: pulse 2s infinite;
    }
</style>
@endpush



@section('content')



    <!-- Slider Section -->
    @if(isset($sliders) && $sliders->count() > 0)
    <section id="slider-section" class="slider-section">
        <div class="container-fluid px-0">
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

    <!-- Spacer untuk pemisahan -->
    <div class="section-spacer" style="height: 50px; background: #f8f9fa;"></div>

    <!-- Featured News Section -->
    @if(isset($latestNews) && $latestNews->count() > 0)
    <section id="news-section" class="news-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Berita Terbaru</h2>
                <p class="text-muted fs-5">Informasi dan perkembangan terkini dari {{ $globalSettings['site_name'] ?? 'KESOSI' }}</p>
                <div class="mx-auto" style="width: 60px; height: 4px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 2px;"></div>
            </div>
            
            @if($latestNews->count() > 0)
                <!-- Featured Main News - Full Width Hero -->
                <div class="row mb-5">
                    <div class="col-12">
                        @php $mainNews = $latestNews->first(); @endphp
                        <div class="featured-news-hero position-relative">
                            <div class="featured-news-bg" style="background-image: url('{{ $mainNews->featured_image_url }}')"></div>
                            <div class="featured-news-overlay">
                                <div class="container">
                                    <div class="row h-100 align-items-end">
                                        <div class="col-lg-8">
                                            <div class="featured-news-content text-white p-5">
                                                @if($mainNews->category)
                                                    <span class="featured-news-category badge bg-primary mb-3">{{ $mainNews->category->name }}</span>
                                                @endif
                                                <h1 class="featured-news-title display-4 fw-bold mb-3">
                                                    <a href="{{ route('news.show', $mainNews->slug) }}" class="text-white text-decoration-none">
                                                        {{ $mainNews->title }}
                                                    </a>
                                                </h1>
                                                @if($mainNews->excerpt)
                                                    <p class="featured-news-excerpt fs-5 mb-4 opacity-90">{{ Str::limit($mainNews->excerpt, 200) }}</p>
                                                @else
                                                    <p class="featured-news-excerpt fs-5 mb-4 opacity-90">{{ Str::limit(strip_tags($mainNews->content), 200) }}</p>
                                                @endif
                                                <div class="featured-news-meta d-flex align-items-center gap-3">
                                                    <span><i class="fas fa-calendar-alt me-2"></i>{{ $mainNews->published_at->format('d M Y') }}</span>
                                                    <span><i class="fas fa-user me-2"></i>{{ $mainNews->user->name ?? 'Admin' }}</span>
                                                    <span><i class="fas fa-eye me-2"></i>{{ number_format($mainNews->views ?? 0) }} views</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Other News Grid -->
                @if($latestNews->count() > 1)
                <div class="row">
                    <div class="col-12">
                        <div class="row g-4">
                            @foreach($latestNews->skip(1)->take(3) as $news)
                                <div class="col-lg-4 col-md-6">
                                    <div class="news-card-grid h-100">
                                        <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark">
                                            <div class="news-card-image position-relative">
                                                <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="w-100">
                                                @if($news->category)
                                                    <span class="news-card-category position-absolute top-0 start-0 m-3 badge bg-warning text-dark">
                                                        <i class="fas fa-star me-1"></i>{{ $news->category->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="news-card-content p-4">
                                                <div class="news-card-meta text-muted small mb-2">
                                                    <span><i class="fas fa-calendar-alt me-1"></i>{{ $news->published_at->format('d M Y') }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span><i class="fas fa-user me-1"></i>{{ $news->user->name ?? 'Admin' }}</span>
                                                </div>
                                                <h3 class="news-card-title h5 fw-bold mb-3">{{ $news->title }}</h3>
                                                @if($news->excerpt)
                                                    <p class="news-card-excerpt text-muted mb-3">{{ Str::limit($news->excerpt, 120) }}</p>
                                                @else
                                                    <p class="news-card-excerpt text-muted mb-3">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                                @endif
                                                <div class="news-card-footer d-flex justify-content-between align-items-center">
                                                    <span class="text-primary fw-semibold">Baca Selengkapnya</span>
                                                    <span class="text-muted small">
                                                        <i class="fas fa-eye me-1"></i>{{ number_format($news->views ?? 0) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endif
            
            <!-- View All News Button -->
            <div class="text-center mt-5">
                <a href="{{ route('news.index') }}" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Info Terkini / Announcements Section -->
    @if($latestAnnouncements->count() > 0)
    <section id="announcements" class="py-5 position-relative overflow-hidden">
        <!-- Background dengan gradient yang lebih menarik -->
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 50%, #9b59b6 100%);"></div>
        
        <!-- Pattern overlay untuk texture -->
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 2px),
                                     radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 1px, transparent 1px);
                    background-size: 50px 50px; opacity: 0.3;"></div>
        
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="announcement-content text-white">
                        <!-- Header yang lebih menarik -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="announcement-icon bg-white bg-opacity-20 rounded-circle p-4 me-4 
                                        d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px; backdrop-filter: blur(10px);">
                                <i class="fas fa-bullhorn text-white fa-2x"></i>
                            </div>
                            <div>
                                <h2 class="display-6 fw-bold mb-2">Info Terkini</h2>
                                <p class="mb-0 opacity-90 fs-5">Pengumuman & informasi penting</p>
                            </div>
                        </div>
                        
                        <!-- Konten utama dengan styling yang lebih baik -->
                        <div class="announcement-text bg-white bg-opacity-10 rounded-4 p-4 mb-4"
                             style="backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                            <h3 class="h4 fw-bold mb-3 text-white">{{ $latestAnnouncements->first()->title }}</h3>
                            <p class="lead mb-4 opacity-90 text-white" style="line-height: 1.6;">
                                {{ Str::limit(strip_tags($latestAnnouncements->first()->content), 150) }}
                            </p>
                            
                            <!-- Badge yang lebih menarik -->
                            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                                <span class="badge bg-white text-primary px-4 py-2 rounded-pill fs-6 fw-semibold">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    @if($latestAnnouncements->first()->start_date)
                                        {{ $latestAnnouncements->first()->start_date->format('d M Y') }}
                                    @else
                                        {{ $latestAnnouncements->first()->created_at->format('d M Y') }}
                                    @endif
                                </span>
                                @if($latestAnnouncements->first()->priority === 'urgent')
                                <span class="badge bg-danger px-4 py-2 rounded-pill fs-6 fw-semibold animate__animated animate__pulse">
                                    <i class="fas fa-exclamation-triangle me-2"></i>URGENT
                                </span>
                                @elseif($latestAnnouncements->first()->priority === 'high')
                                <span class="badge bg-warning text-dark px-4 py-2 rounded-pill fs-6 fw-semibold">
                                    <i class="fas fa-star me-2"></i>PENTING
                                </span>
                                @endif
                            </div>
                            
                            <!-- Button yang lebih menarik -->
                            <a href="{{ route('announcements.show', $latestAnnouncements->first()->slug) }}" 
                               class="btn btn-light btn-lg px-5 py-3 fw-semibold rounded-pill 
                                      shadow-lg hover-transform">
                                <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="announcement-list">
                        <!-- Card dengan styling yang lebih modern -->
                        <div class="card bg-white bg-opacity-15 backdrop-blur border-0 rounded-4 shadow-lg"
                             style="backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2);">
                            <div class="card-header bg-transparent border-0 text-white p-4">
                                <h5 class="mb-0 fw-bold fs-4">
                                    <i class="fas fa-list-ul me-3"></i>Pengumuman Lainnya
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach($latestAnnouncements->skip(1) as $announcement)
                                <div class="announcement-item border-bottom border-white border-opacity-20 p-4 
                                           hover-bg-white-10 transition-all">
                                    <div class="d-flex align-items-start">
                                        <div class="announcement-item-icon me-3 mt-2">
                                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px; 
                                                        background: rgba(255,255,255,0.2); 
                                                        backdrop-filter: blur(10px);">
                                                @if($announcement->priority === 'urgent')
                                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                                @elseif($announcement->priority === 'high')
                                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                                @else
                                                    <i class="fas fa-info-circle text-info"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="announcement-item-content flex-grow-1">
                                            <h6 class="text-white fw-semibold mb-2 fs-6">
                                                <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                                   class="text-white text-decoration-none hover-text-light">
                                                    {{ $announcement->title }}
                                                </a>
                                            </h6>
                                            <p class="text-white-50 small mb-3" style="line-height: 1.5;">
                                                {{ Str::limit(strip_tags($announcement->content), 80) }}
                                            </p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="text-white-50 small">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    @if($announcement->start_date)
                                                        {{ $announcement->start_date->format('d M Y') }}
                                                    @else
                                                        {{ $announcement->created_at->format('d M Y') }}
                                                    @endif
                                                </span>
                                                <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                                   class="btn btn-sm btn-outline-light rounded-pill px-3 hover-transform">
                                                    <i class="fas fa-arrow-right me-1"></i>Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                <div class="text-center p-4">
                                    <a href="{{ route('announcements.index') }}" 
                                       class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-semibold hover-transform">
                                        <i class="fas fa-list me-2"></i>Lihat Semua Pengumuman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif


    <!-- Study Programs (Prodi) Section -->
    <section id="study-programs" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-primary">Program Studi</h2>
                <p class="lead text-muted">Temukan program studi unggulan untuk masa depan gemilang Anda</p>
                <div class="d-flex justify-content-center">
                    <div class="border-bottom border-primary" style="width: 100px; height: 3px;"></div>
                </div>
            </div>

            @if($studyPrograms->count() > 0)
                <div class="row g-4">
                    @foreach($studyPrograms as $prodi)
                        <div class="col-lg-4 col-md-6">
                            <div class="card prodi-card h-100 border-0 shadow-sm">
                                <div class="prodi-image position-relative">
                                    @if($prodi->image)
                                        <img src="{{ asset('storage/' . $prodi->image) }}" alt="{{ $prodi->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fas fa-graduation-cap text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="prodi-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                        @if($prodi->slug)
                                            <a href="{{ route('program-studi.show', $prodi->slug) }}" class="btn btn-light btn-lg prodi-btn">
                                                <i class="fas fa-eye me-2"></i>Lihat Detail
                                            </a>
                                        @else
                                            <span class="btn btn-light btn-lg prodi-btn disabled"><i class="fas fa-eye me-2"></i>Lihat Detail</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $prodi->full_name ?? $prodi->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($prodi->description, 100) }}</p>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="fw-bold text-primary h5">{{ $prodi->students ? $prodi->students->count() : 0 }}</div>
                                            <small class="text-muted">Mahasiswa</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="fw-bold text-success h5">{{ $prodi->lecturers ? $prodi->lecturers->count() : 0 }}</div>
                                            <small class="text-muted">Dosen</small>
                                        </div>
                                    </div>
                                    @if($prodi->faculty && $prodi->faculty->name)
                                        <div class="mt-3">
                                            <span class="badge bg-secondary">{{ $prodi->faculty->name }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    @if($prodi->slug)
                                        <a href="{{ route('program-studi.show', $prodi->slug) }}" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-arrow-right me-2"></i>Pelajari Lebih Lanjut
                                        </a>
                                    @else
                                        <span class="btn btn-outline-primary w-100 disabled">
                                            <i class="fas fa-arrow-right me-2"></i>Pelajari Lebih Lanjut
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Study Programs Button -->
                <div class="text-center mt-5">
                    <a href="{{ route('program-studi.index') }}" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="fas fa-graduation-cap me-2"></i>Lihat Semua Prodi
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-graduation-cap fa-5x text-muted mb-4"></i>
                    <h3>Belum Ada Program Studi</h3>
                    <p class="text-muted">Program studi akan segera tersedia</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Gallery Section -->
    @if(isset($featuredGalleries) && $featuredGalleries->count() > 0)
    <section id="gallery-section" class="gallery-section py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Galeri Foto & Video</h2>
                <p class="text-muted fs-5">Dokumentasi kegiatan dan momen berharga di {{ $globalSettings['site_name'] ?? 'KESOSI' }}</p>
                <div class="mx-auto" style="width: 60px; height: 4px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 2px;"></div>
            </div>
            <!-- Featured Gallery Grid -->
            <div class="row g-3">
                @foreach($featuredGalleries->take(9) as $index => $gallery)
                    @if($index == 0)
                        <!-- Main Featured Item - Large -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="gallery-item gallery-featured position-relative overflow-hidden rounded-3 shadow-lg h-100">
                                @if($gallery->type === 'video')
                                    <div class="gallery-video-container position-relative">
                                        <img src="{{ $gallery->youtube_thumbnail ?: $gallery->thumbnail_url }}" alt="{{ $gallery->title }}" class="gallery-image w-100 h-100 object-cover">
                                        <div class="gallery-play-btn position-absolute top-50 start-50 translate-middle">
                                            <button class="btn btn-light btn-lg rounded-circle shadow-lg" data-bs-toggle="modal" data-bs-target="#videoModal{{ $gallery->id }}">
                                                <i class="fas fa-play text-primary"></i>
                                            </button>
                                        </div>
                                        <span class="gallery-type-badge position-absolute top-0 end-0 m-3 badge bg-danger">
                                            <i class="fas fa-video me-1"></i>Video
                                        </span>
                                    </div>
                                @else
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="gallery-image w-100 h-100 object-cover">
                                    <span class="gallery-type-badge position-absolute top-0 end-0 m-3 badge bg-success">
                                        <i class="fas fa-image me-1"></i>Foto
                                    </span>
                                @endif
                                <div class="gallery-overlay position-absolute bottom-0 start-0 w-100 p-4 text-white">
                                    <div class="gallery-gradient position-absolute top-0 start-0 w-100 h-100"></div>
                                    <div class="position-relative">
                                        <h4 class="gallery-title fw-bold mb-2">{{ $gallery->title }}</h4>
                                        @if($gallery->category)
                                            <span class="gallery-category badge bg-primary mb-2">{{ $gallery->category->name }}</span>
                                        @endif
                                        @if($gallery->description)
                                            <p class="gallery-description mb-2 opacity-90">{{ Str::limit($gallery->description, 100) }}</p>
                                        @endif
                                        <div class="gallery-meta small opacity-75">
                                            <span><i class="fas fa-calendar-alt me-1"></i>{{ $gallery->created_at->format('d M Y') }}</span>
                                            @if($gallery->photographer)
                                                <span class="ms-3"><i class="fas fa-camera me-1"></i>{{ $gallery->photographer }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('gallery.show', $gallery->slug) }}" class="gallery-link position-absolute top-0 start-0 w-100 h-100"></a>
                            </div>
                        </div>
                        <!-- Small Grid Container for Other Items -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row g-2 h-100">
                    @else
                        <!-- Small Compact Items -->
                        <div class="col-6">
                            <div class="gallery-item gallery-compact position-relative overflow-hidden rounded-2 shadow h-100">
                                @if($gallery->type === 'video')
                                    <div class="gallery-video-container position-relative">
                                        <img src="{{ $gallery->youtube_thumbnail ?: $gallery->thumbnail_url }}" alt="{{ $gallery->title }}" class="gallery-image w-100 h-100 object-cover">
                                        <div class="gallery-play-btn-compact position-absolute top-50 start-50 translate-middle">
                                            <button class="btn btn-light btn-sm rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#videoModal{{ $gallery->id }}">
                                                <i class="fas fa-play text-primary small"></i>
                                            </button>
                                        </div>
                                        <span class="gallery-type-badge-compact position-absolute top-0 end-0 m-1 badge bg-danger">
                                            <i class="fas fa-video small"></i>
                                        </span>
                                    </div>
                                @else
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="gallery-image w-100 h-100 object-cover">
                                    <span class="gallery-type-badge-compact position-absolute top-0 end-0 m-1 badge bg-success">
                                        <i class="fas fa-image small"></i>
                                    </span>
                                @endif
                                <div class="gallery-overlay-compact position-absolute bottom-0 start-0 w-100 p-2 text-white">
                                    <div class="gallery-gradient-compact position-absolute top-0 start-0 w-100 h-100"></div>
                                    <div class="position-relative">
                                        <h6 class="gallery-title-compact fw-bold mb-0 small">{{ Str::limit($gallery->title, 25) }}</h6>
                                        @if($gallery->category)
                                            <span class="gallery-category-compact badge bg-primary mt-1" style="font-size: 0.6rem;">{{ $gallery->category->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('gallery.show', $gallery->slug) }}" class="gallery-link position-absolute top-0 start-0 w-100 h-100"></a>
                            </div>
                        </div>
                        @if($index == 8 || $loop->last)
                            </div> <!-- Close row for small grid -->
                        </div> <!-- Close col for small grid container -->
                        @endif
                    @endif
                @endforeach
            </div>
            <!-- View All Gallery Button -->
            <div class="text-center mt-5">
                <a href="{{ route('gallery.index') }}" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-images me-2"></i>Lihat Semua Galeri
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Dynamic Sections -->
    <!-- Dynamic Sections (empty state dihilangkan) -->
    <section id="sections" class="py-5 bg-white">
        <div class="container">
            @if($sections->count() > 0)
                <!-- Section content here -->
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
        
        // News card click tracking
        document.querySelectorAll('.news-card, .featured-news-main, .mini-news-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Analytics tracking bisa ditambahkan di sini
                console.log('News card clicked:', this.getAttribute('href'));
            });
        });
        
        // Smooth animations untuk loading
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        // Observe news cards for smooth loading animation
        document.querySelectorAll('.news-card, .mini-news-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    });
</script>
@endpush
