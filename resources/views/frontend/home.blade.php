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
    
    /* News Section Styles */
    .news-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    .news-image {
        height: 200px;
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
    }
    .news-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(102, 126, 234, 0.9);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        backdrop-filter: blur(10px);
    }
    .news-date {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(255,255,255,0.9);
        color: #333;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .news-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .news-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-excerpt {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 15px;
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
        font-size: 0.8rem;
        color: #999;
        margin-top: auto;
    }
    .read-more-btn {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    .read-more-btn:hover {
        color: #764ba2;
        text-decoration: none;
    }
    
    /* Featured News Layout Styles */
    .featured-news-main {
        position: relative;
        height: 400px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transition: transform 0.3s ease;
    }
    .featured-news-main:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.18);
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
    }
    .featured-news-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.6) 100%);
        display: flex;
        align-items: flex-end;
    }
    .featured-news-content {
        padding: 30px;
        color: white;
        width: 100%;
    }
    .featured-news-category {
        display: inline-block;
        background: rgba(102, 126, 234, 0.9);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 15px;
        backdrop-filter: blur(10px);
    }
    .featured-news-title {
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 15px;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    }
    .featured-news-excerpt {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 20px;
        color: rgba(255,255,255,0.9);
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .featured-news-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.8);
    }
    .featured-news-date {
        display: flex;
        align-items: center;
        gap: 5px;
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-radius: 8px;
        overflow: hidden;
        height: 100px;
        background: white;
        display: flex;
    }
    .mini-news-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }
    .mini-news-image {
        width: 120px;
        height: 100px;
        background-size: cover;
        background-position: center;
        position: relative;
        flex-shrink: 0;
    }
    .mini-news-category {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(102, 126, 234, 0.9);
        color: white;
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 0.65rem;
        font-weight: 500;
    }
    .mini-news-content {
        padding: 12px 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
        min-width: 0;
    }
    .mini-news-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 6px;
        line-height: 1.3;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .mini-news-excerpt {
        font-size: 0.75rem;
        color: #666;
        line-height: 1.3;
        margin-bottom: 8px;
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
        font-size: 0.7rem;
        color: #999;
    }
</style>
@endpush



@section('content')



    <!-- Slider -->
    @if(isset($sliders) && $sliders->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
           
            
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
    @if(isset($latestNews) && $latestNews->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Berita Terbaru</h2>
                <p class="text-muted">Informasi dan perkembangan terkini dari {{ $globalSettings['site_name'] ?? 'KESOSI' }}</p>
            </div>
            
            @if($latestNews->count() > 0)
                <!-- Featured Main News -->
                <div class="row mb-5">
                    <div class="col-12">
                        @php $mainNews = $latestNews->first(); @endphp
                        <article class="featured-news-main">
                            <div class="featured-news-bg" style="background-image: url('{{ $mainNews->featured_image_url }}')"></div>
                            <div class="featured-news-overlay">
                                <div class="featured-news-content">
                                    @if($mainNews->category)
                                        <span class="featured-news-category">{{ $mainNews->category->name }}</span>
                                    @endif
                                    <h2 class="featured-news-title">
                                        <a href="{{ route('news.show', $mainNews->slug) }}" class="text-decoration-none text-white">
                                            {{ $mainNews->title }}
                                        </a>
                                    </h2>
                                    @if($mainNews->excerpt)
                                        <p class="featured-news-excerpt">{{ $mainNews->excerpt }}</p>
                                    @else
                                        <p class="featured-news-excerpt">{{ Str::limit(strip_tags($mainNews->content), 200) }}</p>
                                    @endif
                                    <div class="featured-news-meta">
                                        <div class="featured-news-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>{{ $mainNews->published_at->format('d M Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-user"></i>
                                            <span>{{ $mainNews->user->name ?? 'Admin' }}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $mainNews->views ?? 0 }} views</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                
                <!-- Other News - Mini Cards Grid -->
                @if($latestNews->count() > 1)
                <div class="row">
                    <div class="col-12">
                        <h4 class="fw-bold mb-4">Berita Lainnya</h4>
                        <div class="row g-3">
                            @foreach($latestNews->skip(1)->take(8) as $news)
                                <div class="col-lg-6 col-md-6">
                                    <article class="card mini-news-card">
                                        <div class="mini-news-image" style="background-image: url('{{ $news->featured_image_url }}')">
                                            @if($news->category)
                                                <span class="mini-news-category">{{ $news->category->name }}</span>
                                            @endif
                                        </div>
                                        <div class="mini-news-content">
                                            <div>
                                                <h3 class="mini-news-title">
                                                    <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark">
                                                        {{ $news->title }}
                                                    </a>
                                                </h3>
                                                @if($news->excerpt)
                                                    <p class="mini-news-excerpt">{{ Str::limit($news->excerpt, 100) }}</p>
                                                @else
                                                    <p class="mini-news-excerpt">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                                                @endif
                                            </div>
                                            <div class="mini-news-meta">
                                                <span>
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $news->published_at->format('d M') }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-eye me-1"></i>
                                                    {{ $news->views ?? 0 }}
                                                </span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endif
            
            <!-- View All News Button -->
            <div class="text-center mt-5">
                <a href="{{ route('news.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>
    @endif

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
