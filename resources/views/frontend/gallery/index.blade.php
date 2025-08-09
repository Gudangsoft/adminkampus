@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
<div class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Galeri Kampus</h1>
                <p class="lead">Dokumentasi kegiatan dan fasilitas kampus</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('gallery.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" 
                                            {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                    placeholder="Cari..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Gallery Section -->
    @if(isset($featuredGalleries) && $featuredGalleries->count() > 0 && !request()->hasAny(['category', 'type', 'search']))
    <div class="row mb-5">
        <div class="col-lg-12">
            <h2 class="mb-4">Galeri Unggulan</h2>
            <div class="row">
                @foreach($featuredGalleries->take(4) as $featured)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="gallery-item-wrapper position-relative">
                            @if($featured->type == 'image')
                                <img src="{{ $featured->image_url }}" 
                                     class="card-img-top gallery-image" 
                                     alt="{{ $featured->title }}"
                                     style="height: 200px; object-fit: cover;">
                                <div class="gallery-overlay">
                                    <i class="fas fa-image text-white fs-2"></i>
                                </div>
                            @else
                                <div class="video-thumbnail position-relative" style="height: 200px;">
                                    <img src="{{ $featured->youtube_thumbnail }}" 
                                         class="w-100 h-100" 
                                         style="object-fit: cover;" 
                                         alt="{{ $featured->title }}">
                                    <div class="gallery-overlay">
                                        <i class="fas fa-play-circle text-white fs-1"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($featured->title, 50) }}</h6>
                            <p class="card-text text-muted small">
                                <i class="fas fa-folder me-1"></i>{{ $featured->category->name }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('gallery.show', $featured->slug) }}" 
                               class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Gallery Grid -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="mb-4">
                @if(request('category'))
                    Kategori: {{ $categories->where('slug', request('category'))->first()->name ?? 'Tidak Ditemukan' }}
                @elseif(request('type'))
                    Jenis: {{ ucfirst(request('type')) }}
                @elseif(request('search'))
                    Hasil Pencarian: "{{ request('search') }}"
                @else
                    Semua Galeri
                @endif
            </h2>
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
                            <i class="fas fa-folder me-1"></i>{{ $gallery->category->name }}
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>{{ $gallery->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('gallery.show', $gallery->slug) }}" 
                           class="btn btn-primary btn-sm">Lihat Detail</a>
                        @if($gallery->type == 'video')
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ number_format($gallery->views) }}
                            </small>
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
                <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <a href="{{ route('gallery.index') }}" class="btn btn-primary">Lihat Semua Galeri</a>
            </div>
        </div>
    </div>
    @endif
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
</style>
@endpush
@endsection
