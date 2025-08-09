@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
/* Hero News Styles */
.hero-news-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-height: 380px;
}

.hero-news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.hero-news-card .col-md-5 {
    position: relative;
    overflow: hidden;
}

.hero-news-card .col-md-5 img {
    transition: transform 0.3s ease;
}

.hero-news-card:hover .col-md-5 img {
    transform: scale(1.02);
}

.hero-news-title {
    font-size: 1.8rem;
    line-height: 1.3;
    color: #212529 !important;
    margin-bottom: 1rem;
}

.hero-news-excerpt {
    font-size: 1rem;
    line-height: 1.6;
    color: #6c757d;
}

.hero-news-meta .badge {
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    border-radius: 25px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* News Card Hover Effects */
.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px !important;
}

.news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.news-card:hover .card-img-top {
    transform: scale(1.05);
}

/* Section Styling */
.section-title {
    position: relative;
    padding-bottom: 15px;
    margin-bottom: 30px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #0056b3);
    border-radius: 2px;
}

/* Button Enhancements */
.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
}

.btn-outline-primary {
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-news-title {
        font-size: 1.5rem;
    }
    
    .hero-news-excerpt {
        font-size: 1rem;
    }
    
    .hero-news-card .row.g-0 > .col-md-5:first-child {
        order: 2;
    }
    
    .hero-news-card .row.g-0 > .col-md-7:last-child {
        order: 1;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Slider Section -->
@if($sliders && $sliders->count() > 0)
<div class="container-fluid p-0">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" style="height: 500px;">
        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach($sliders as $index => $slider)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                    class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        
        <!-- Slides -->
        <div class="carousel-inner h-100">
            @foreach($sliders as $index => $slider)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                <img src="{{ $slider->image_url }}" class="d-block w-100 h-100" alt="{{ $slider->title }}" style="object-fit: cover;">
                <div class="carousel-caption d-md-block">
                    <div class="container">
                        <h1 class="display-5 fw-bold text-white">{{ $slider->title }}</h1>
                        @if($slider->description)
                        <p class="lead text-white">{{ $slider->description }}</p>
                        @endif
                        @if($slider->link && $slider->button_text)
                        <a href="{{ $slider->link }}" target="{{ $slider->link_target }}" class="btn btn-primary btn-lg">
                            {{ $slider->button_text }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@else
<!-- Fallback if no sliders -->
<div class="container-fluid p-0">
    <div class="bg-primary text-white text-center py-5" style="min-height: 500px; display: flex; align-items: center;">
        <div class="container">
            <h1 class="display-4">Selamat Datang di {{ $globalSettings['site_name'] ?? 'MYCAMPUS' }}</h1>
            <p class="lead">Kampus Modern untuk Masa Depan Cemerlang</p>
        </div>
    </div>
</div>
@endif

<!-- Statistics Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_students']) }}</div>
                <p class="text-muted">Total Mahasiswa</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_lecturers']) }}</div>
                <p class="text-muted">Dosen</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_study_programs']) }}</div>
                <p class="text-muted">Program Studi</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_faculties']) }}</div>
                <p class="text-muted">Fakultas</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured News Section -->
@if($featuredNews->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Berita Terbaru</h2>
        
        <!-- Hero News - First News Item -->
        @if($featuredNews->first())
        <div class="row mb-5">
            <div class="col-12">
                <div class="card hero-news-card border-0 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5">
                            @if($featuredNews->first()->featured_image)
                                <img src="{{ $featuredNews->first()->featured_image_url }}" 
                                     class="img-fluid h-100 w-100" 
                                     alt="{{ $featuredNews->first()->title }}" 
                                     style="object-fit: cover; min-height: 300px; max-height: 350px;">
                            @else
                                <div class="bg-primary d-flex align-items-center justify-content-center h-100" style="min-height: 300px; max-height: 350px;">
                                    <i class="fas fa-newspaper fa-4x text-white opacity-25"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="card-body h-100 d-flex flex-column justify-content-center p-3 p-lg-4">
                                <div class="hero-news-meta mb-3">
                                    <span class="badge bg-primary px-3 py-2 mb-2">
                                        <i class="fas fa-star me-1"></i>BERITA UTAMA
                                    </span>
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $featuredNews->first()->published_at->format('d M Y') }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-tag me-2"></i>
                                        {{ $featuredNews->first()->category->name }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-eye me-2"></i>
                                        {{ number_format($featuredNews->first()->views ?? 0) }} views
                                    </div>
                                </div>
                                <h3 class="hero-news-title fw-bold mb-3 text-dark">
                                    {{ $featuredNews->first()->title }}
                                </h3>
                                <p class="hero-news-excerpt text-muted mb-4 lh-base">
                                    {{ Str::limit($featuredNews->first()->excerpt, 150) }}
                                </p>
                                <div class="hero-news-actions">
                                    <a href="{{ route('news.show', $featuredNews->first()->slug) }}" 
                                       class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Regular News Grid - Skip first news if exists -->
        @if($featuredNews->count() > 1)
        <div class="row">
            @foreach($featuredNews->skip(1) as $news)
            <div class="col-lg-4 mb-4">
                <div class="card news-card h-100 shadow-sm border-0">
                    @if($news->featured_image)
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $news->featured_image_url }}" 
                                 class="card-img-top" 
                                 alt="{{ $news->title }}" 
                                 style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                            <div class="card-img-overlay d-flex align-items-end p-0">
                                <div class="bg-dark bg-opacity-75 text-white p-2 w-100">
                                    <small>{{ $news->category->name }}</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="news-meta mb-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $news->published_at->format('d M Y') }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-eye me-1"></i>
                                {{ number_format($news->views ?? 0) }}
                            </small>
                        </div>
                        <h5 class="card-title fw-bold mb-2">{{ $news->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($news->excerpt, 100) }}</p>
                        <a href="{{ route('news.show', $news->slug) }}" 
                           class="btn btn-outline-primary btn-sm">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        <div class="text-center mt-4">
            <a href="{{ route('news.index') }}" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
@endif

<!-- Announcements Section -->
@if($urgentAnnouncements->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Pengumuman Penting</h2>
        <div class="row">
            @foreach($urgentAnnouncements as $announcement)
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-start border-danger border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-danger me-2">{{ strtoupper($announcement->priority) }}</span>
                            <small class="text-muted">{{ $announcement->published_at->format('d M Y') }}</small>
                        </div>
                        <h6 class="card-title">{{ $announcement->title }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($announcement->excerpt, 80) }}</p>
                        <a href="{{ route('announcements.show', $announcement->slug) }}" class="btn btn-outline-danger btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('announcements.index') }}" class="btn btn-danger">Lihat Semua Pengumuman</a>
        </div>
    </div>
</section>
@endif

<!-- Faculties Section -->
@if($faculties->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Fakultas</h2>
        <div class="row">
            @foreach($faculties as $faculty)
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            @if($faculty->logo)
                                <img src="{{ $faculty->logo_url }}" alt="{{ $faculty->name }}" class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-university"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="card-title">{{ $faculty->name }}</h5>
                                @if($faculty->dean_name)
                                    <p class="text-muted small mb-2">Dekan: {{ $faculty->dean_name }}</p>
                                @endif
                                <p class="card-text">{{ Str::limit($faculty->description, 120) }}</p>
                                <a href="{{ route('program-studi.faculty', $faculty->slug) }}" class="btn btn-outline-primary btn-sm">Lihat Program Studi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if($featuredGallery->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Galeri Kegiatan</h2>
        <div class="row">
            @foreach($featuredGallery as $gallery)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="{{ $gallery->thumbnail_url }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-1">{{ Str::limit($gallery->title, 50) }}</h6>
                        <small class="text-muted">{{ $gallery->category->name }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('gallery.index') }}" class="btn btn-primary">Lihat Semua Galeri</a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="h3 mb-3">Bergabunglah dengan {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</h2>
        <p class="lead mb-4">{{ $globalSettings['site_description'] ?? 'Wujudkan impian pendidikan tinggi Anda bersama kami' }}</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('program-studi.index') }}" class="btn btn-light btn-lg">
                <i class="fas fa-graduation-cap me-2"></i>Pilih Program Studi
            </a>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
/* Hero Slider Styles */
#heroCarousel {
    height: 500px;
}

#heroCarousel .carousel-item {
    height: 500px;
}

#heroCarousel .carousel-caption {
    background: rgba(0,0,0,0.5);
    padding: 2rem;
    border-radius: 10px;
    bottom: 20%;
}

#heroCarousel .carousel-indicators {
    bottom: 1rem;
}

#heroCarousel .carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.5);
}

#heroCarousel .carousel-indicators button.active {
    background-color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
    #heroCarousel {
        height: 400px;
    }
    
    #heroCarousel .carousel-item {
        height: 400px;
    }
    
    #heroCarousel .carousel-caption h1 {
        font-size: 1.5rem;
    }
    
    #heroCarousel .carousel-caption p {
        font-size: 0.9rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel) {
        new bootstrap.Carousel(heroCarousel, {
            interval: 5000,
            ride: 'carousel'
        });
    }
});
</script>
@endpush
