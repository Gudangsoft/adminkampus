@extends('layouts.app')

@section('title', $category->name . ' - Galeri')

@section('content')
<div class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="lead">{{ $category->description }}</p>
                @endif
                <p class="mb-0">{{ $galleries->total() }} item ditemukan</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('gallery.category', $category->slug) }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select name="type" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="sort" class="form-select">
                                    <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                                    @if(request('type') == 'video')
                                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('gallery.category', $category->slug) }}" 
                                   class="btn btn-outline-secondary w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($galleries->count() > 0)
    <div class="row">
        @foreach($galleries as $gallery)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm gallery-card">
                <div class="gallery-item-wrapper position-relative">
                    @if($gallery->type == 'image')
                        <img src="{{ $gallery->image_url }}" 
                             class="card-img-top gallery-image" 
                             alt="{{ $gallery->title }}"
                             style="height: 250px; object-fit: cover;">
                        <div class="gallery-overlay">
                            <i class="fas fa-image text-white fs-2"></i>
                        </div>
                    @else
                        <div class="video-thumbnail position-relative" style="height: 250px;">
                            <img src="{{ $gallery->youtube_thumbnail }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;" 
                                 alt="{{ $gallery->title }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-play-circle text-white fs-1"></i>
                            </div>
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                <i class="fab fa-youtube me-1"></i>Video
                            </span>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ Str::limit($gallery->title, 60) }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($gallery->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>{{ $gallery->created_at->format('d M Y') }}
                        </small>
                        @if($gallery->type == 'video')
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ number_format($gallery->views) }}
                            </small>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('gallery.show', $gallery->slug) }}" 
                           class="btn btn-primary btn-sm">Lihat Detail</a>
                        @if($gallery->type == 'video')
                            <a href="{{ $gallery->youtube_url }}" 
                               target="_blank" 
                               class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-lg-12">
            {{ $galleries->withQueryString()->links() }}
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center py-5">
                <i class="fas fa-images text-muted mb-3" style="font-size: 4rem;"></i>
                <h4 class="text-muted">Tidak ada galeri ditemukan</h4>
                <p class="text-muted">Belum ada item dalam kategori {{ $category->name }}.</p>
                <a href="{{ route('gallery.index') }}" class="btn btn-primary">Lihat Semua Galeri</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Category Navigation -->
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Kategori Lainnya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $allCategories = \App\Models\GalleryCategory::active()->orderBy('sort_order')->get();
                        @endphp
                        @foreach($allCategories as $cat)
                            @if($cat->id != $category->id)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <a href="{{ route('gallery.category', $cat->slug) }}" 
                                   class="card text-decoration-none category-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-folder-open text-primary fs-2 mb-2"></i>
                                        <h6 class="card-title">{{ $cat->name }}</h6>
                                        <small class="text-muted">{{ $cat->galleries_count ?? 0 }} item</small>
                                    </div>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.gallery-card {
    transition: transform 0.3s ease;
}

.gallery-card:hover {
    transform: translateY(-5px);
}

.gallery-item-wrapper {
    overflow: hidden;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item-wrapper:hover .gallery-overlay {
    opacity: 1;
}

.gallery-image {
    transition: transform 0.3s ease;
}

.gallery-item-wrapper:hover .gallery-image {
    transform: scale(1.1);
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.category-card {
    transition: transform 0.3s ease;
    border: 1px solid #dee2e6;
}

.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #007bff;
}
</style>
@endpush
@endsection
