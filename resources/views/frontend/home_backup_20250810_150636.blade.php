@extends('layouts.app')

@section('title', 'Beranda - ' . ($globalSettings['site_name'] ?? 'KESOSI'))

@section('content')
<div class="container mt-4">
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-5 rounded">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h1 mb-3">Selamat Datang di Kampus Kesehatan Modern</h1>
                        <p class="lead mb-4">Membentuk tenaga kesehatan profesional untuk masa depan yang lebih sehat melalui pendidikan berkualitas dan inovasi terdepan.</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#tentang" class="btn btn-light btn-lg">
                                <i class="fas fa-info-circle me-2"></i>Tentang Kami
                            </a>
                            <a href="{{ route('fakultas.index') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-graduation-cap me-2"></i>Program Studi
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <i class="fas fa-hospital fa-5x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Section -->
    <div class="row mb-5" id="tentang">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="h2 mb-3">Mengapa Memilih Kampus Kesehatan Kami?</h2>
                <p class="lead text-muted">Pendidikan kesehatan berkualitas tinggi dengan fasilitas modern dan tenaga pengajar berpengalaman</p>
            </div>
        </div>
    </div>

    <!-- Features Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3">
                        <i class="fas fa-stethoscope fa-3x"></i>
                    </div>
                    <h5 class="card-title">Pendidikan Klinis Terpadu</h5>
                    <p class="card-text">Program pembelajaran yang mengintegrasikan teori dan praktik klinis dengan standar internasional.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3">
                        <i class="fas fa-microscope fa-3x"></i>
                    </div>
                    <h5 class="card-title">Laboratorium Modern</h5>
                    <p class="card-text">Fasilitas laboratorium dengan peralatan canggih untuk mendukung penelitian dan pembelajaran.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3">
                        <i class="fas fa-user-md fa-3x"></i>
                    </div>
                    <h5 class="card-title">Dosen Berpengalaman</h5>
                    <p class="card-text">Tenaga pengajar profesional dengan pengalaman klinis dan akademis yang komprehensif.</p>
                </div>
            </div>
        </div>
    </div>

    @if(isset($sliders) && $sliders->count() > 0)
    <!-- Slider Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h3 mb-4 text-center">Sorotan Kampus</h2>
            <div id="campusSlider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($sliders as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{ $slider->image_url }}" 
                         alt="{{ $slider->title }}" 
                         class="img-fluid rounded shadow">
                    </div>
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <h3 class="h4 mb-3">{{ $slider->title }}</h3>
                                    <p class="lead">{{ $slider->description }}</p>
                                    @if($slider->link)
                                    <a href="{{ $slider->link }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i>Selengkapnya
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#campusSlider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#campusSlider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Berita Terbaru -->
    @if(isset($news) && $news->count() > 0)
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h3 mb-4">Berita Terbaru</h2>
            <div class="row g-4">
                @foreach($news->take(3) as $article)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             alt="{{ $article->title }}" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::limit($article->title, 60) }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($article->content, 100) }}</p>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $article->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ route('news.show', $article->slug) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-right me-1"></i>Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-primary">
                    <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Program Studi -->
    @if(isset($faculties) && $faculties->count() > 0)
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h3 mb-4">Program Studi</h2>
            <div class="row g-4">
                @foreach($faculties->take(3) as $faculty)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($faculty->image)
                        <img src="{{ asset('storage/' . $faculty->image) }}" 
                             alt="{{ $faculty->name }}" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $faculty->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($faculty->description, 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ route('fakultas.show', $faculty->slug) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-graduation-cap me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('fakultas.index') }}" class="btn btn-primary">
                    <i class="fas fa-university me-2"></i>Lihat Semua Program
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Call to Action -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-light p-5 rounded text-center">
                <h2 class="h3 mb-3">Siap Bergabung dengan Kami?</h2>
                <p class="lead mb-4">Mulai perjalanan pendidikan kesehatan Anda bersama institusi terpercaya dengan fasilitas modern dan kurikulum terkini.</p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
