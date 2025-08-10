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
                            @foreach($latestNews->skip(1)->take(6) as $news)
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

    <!-- Dynamic Sections -->
    <section id="sections" class="py-5 bg-white">
        <div class="container">
            @if($sections->count() > 0)
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">Informasi Kampus</h2>
                    <p class="text-muted fs-5">{{ $sections->count() }} informasi penting yang dapat dikelola melalui admin</p>
                    <div class="mx-auto" style="width: 60px; height: 4px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 2px;"></div>
                </div>
                
                <div class="row">
                    @foreach($sections as $section)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card card-section h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white border-0">
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
                                <div class="card-footer bg-light border-0">
                                    <small class="text-muted">
                                        <i class="fas fa-sort me-1"></i>Urutan: {{ $section->order }}
                                        <span class="float-end">
                                            <i class="fas fa-{{ $section->is_active ? 'check text-success' : 'times text-danger' }}"></i>
                                            {{ $section->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Management Link -->
                <div class="text-center mt-5">
                    <a href="/admin/sections" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-edit me-2"></i>Kelola Informasi Kampus
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                    <h3>Belum Ada Informasi</h3>
                    <p class="text-muted mb-4">Mulai membuat informasi untuk mengisi halaman homepage</p>
                    <a href="/admin/sections" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Buat Informasi Pertama
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
