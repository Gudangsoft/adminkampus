@extends('layouts.app')

@section('title', 'Beranda')

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
        <div class="row">
            @foreach($featuredNews as $news)
            <div class="col-lg-4 mb-4">
                <div class="card news-card h-100">
                    @if($news->featured_image)
                        <img src="{{ $news->featured_image_url }}" class="card-img-top" alt="{{ $news->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="news-meta">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $news->published_at->format('d M Y') }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-tag me-1"></i>
                            {{ $news->category->name }}
                        </div>
                        <h5 class="card-title">{{ $news->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($news->excerpt, 100) }}</p>
                        <a href="{{ route('news.show', $news->slug) }}" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('news.index') }}" class="btn btn-primary">Lihat Semua Berita</a>
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
                                <a href="{{ route('study-programs.faculty', $faculty->slug) }}" class="btn btn-outline-primary btn-sm">Lihat Program Studi</a>
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
