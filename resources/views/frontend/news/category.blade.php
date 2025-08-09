@extends('layouts.app')

@section('title', 'Kategori: ' . $category->name . ' - Berita - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))
@section('meta_description', 'Berita kategori ' . $category->name . ' dari ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient text-white p-4 rounded position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <!-- Background Pattern -->
                <div class="position-absolute top-0 end-0 opacity-25">
                    <i class="fas fa-newspaper" style="font-size: 8rem; color: white;"></i>
                </div>
                
                <div class="position-relative">
                    <h1 class="h2 mb-3">
                        <i class="fas fa-folder-open me-2"></i>
                        Kategori: {{ $category->name }}
                    </h1>
                    @if($category->description)
                        <p class="mb-3 opacity-90">{{ $category->description }}</p>
                    @endif
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark me-3">
                            <i class="fas fa-newspaper me-1"></i>
                            {{ $news->total() }} Berita
                        </span>
                        <small class="opacity-75">
                            <i class="fas fa-calendar me-1"></i>
                            Diperbarui {{ $category->updated_at->format('d F Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Sort -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <form method="GET" action="{{ route('news.category', $category->slug) }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari dalam kategori {{ $category->name }}..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('news.category', $category->slug) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="col-lg-4">
            <div class="d-flex justify-content-lg-end align-items-center">
                <!-- Sort Options -->
                <div class="btn-group btn-group-sm me-3" role="group">
                    <input type="radio" class="btn-check" name="sort" id="sort-latest" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="sort-latest">
                        <i class="fas fa-clock me-1"></i>Terbaru
                    </label>
                    <input type="radio" class="btn-check" name="sort" id="sort-popular" autocomplete="off">
                    <label class="btn btn-outline-primary" for="sort-popular">
                        <i class="fas fa-fire me-1"></i>Populer
                    </label>
                </div>
                
                <small class="text-muted">
                    {{ $news->firstItem() ?? 0 }} - {{ $news->lastItem() ?? 0 }} 
                    dari {{ $news->total() }}
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Search Results Info -->
            @if(request('search'))
                <div class="alert alert-info mb-4">
                    <i class="fas fa-search me-2"></i>
                    Hasil pencarian "<strong>{{ request('search') }}</strong>" dalam kategori <strong>{{ $category->name }}</strong>
                    ({{ $news->total() }} berita ditemukan)
                </div>
            @endif

            <!-- News List -->
            @forelse($news as $item)
                <div class="card mb-4 border-0 shadow-sm news-card">
                    <div class="row g-0">
                        @if($item->featured_image)
                            <div class="col-md-4">
                                <div class="position-relative">
                                    <img src="{{ Storage::url($item->featured_image) }}" 
                                         alt="{{ $item->title }}" 
                                         class="img-fluid rounded-start h-100" 
                                         style="object-fit: cover; min-height: 200px;">
                                    @if($item->is_featured)
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star me-1"></i>Unggulan
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8">
                        @else
                            <div class="col-12">
                        @endif
                                <div class="card-body h-100 d-flex flex-column">
                                    <!-- Date and Badge -->
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $category->name }}</span>
                                        <small class="text-muted ms-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $item->published_at->format('d F Y') }}
                                        </small>
                                        @if($item->is_featured)
                                            <span class="badge bg-warning text-dark ms-2">
                                                <i class="fas fa-star me-1"></i>Unggulan
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Title -->
                                    <h5 class="card-title mb-3">
                                        <a href="{{ route('news.show', $item->slug) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ $item->title }}
                                        </a>
                                    </h5>

                                    <!-- Excerpt -->
                                    <p class="card-text text-muted mb-3 flex-grow-1">
                                        {{ Str::limit($item->excerpt, 150) }}
                                    </p>

                                    <!-- Meta Info -->
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="text-muted small">
                                            <i class="fas fa-user me-1"></i>{{ $item->user->name }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye me-1"></i>{{ number_format($item->views) }} views
                                            @if($item->comments_count > 0)
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-comments me-1"></i>{{ $item->comments_count }}
                                            @endif
                                        </div>
                                        <a href="{{ route('news.show', $item->slug) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-folder-open fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">Tidak ada berita</h5>
                    @if(request('search'))
                        <p class="text-muted mb-3">
                            Tidak ditemukan berita yang sesuai dengan pencarian "<strong>{{ request('search') }}</strong>" 
                            dalam kategori {{ $category->name }}.
                        </p>
                        <a href="{{ route('news.category', $category->slug) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Lihat Semua Berita {{ $category->name }}
                        </a>
                    @else
                        <p class="text-muted mb-3">Belum ada berita dalam kategori {{ $category->name }}.</p>
                        <a href="{{ route('news.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Lihat Semua Berita
                        </a>
                    @endif
                </div>
            @endforelse

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Category Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Kategori
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 text-primary fw-bold">{{ $news->total() }}</div>
                            <small class="text-muted">Total Berita</small>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-success fw-bold">
                                {{ $featuredNews->where('category_id', $category->id)->count() }}
                            </div>
                            <small class="text-muted">Berita Unggulan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured News in Category -->
            @if($featuredNews->where('category_id', $category->id)->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-star me-2"></i>Berita Unggulan {{ $category->name }}
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @foreach($featuredNews->where('category_id', $category->id)->take(3) as $featured)
                            <div class="border-bottom p-3 {{ $loop->last ? '' : 'border-bottom' }}">
                                <div class="d-flex">
                                    @if($featured->featured_image)
                                        <img src="{{ Storage::url($featured->featured_image) }}" 
                                             alt="{{ $featured->title }}" 
                                             class="me-3 rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('news.show', $featured->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($featured->title, 60) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $featured->published_at->format('d M Y') }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye me-1"></i>
                                            {{ number_format($featured->views) }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Other Categories -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-folder me-2"></i>Kategori Lainnya
                    </h6>
                </div>
                <div class="card-body p-0">
                    <a href="{{ route('news.index') }}" 
                       class="list-group-item list-group-item-action border-0">
                        <i class="fas fa-newspaper me-2"></i>Semua Berita
                        <span class="badge bg-light text-dark float-end">Semua</span>
                    </a>
                    
                    @php
                        $otherCategories = \App\Models\NewsCategory::active()
                            ->where('id', '!=', $category->id)
                            ->withCount('news')
                            ->orderBy('name')
                            ->get();
                    @endphp
                    
                    @foreach($otherCategories as $otherCategory)
                        <a href="{{ route('news.category', $otherCategory->slug) }}" 
                           class="list-group-item list-group-item-action border-0">
                            <i class="fas fa-folder-open me-2"></i>{{ $otherCategory->name }}
                            <span class="badge bg-light text-dark float-end">{{ $otherCategory->news_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Back to All News -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">Jelajahi Semua Berita</h6>
                    <p class="card-text text-muted small">
                        Lihat berita dari semua kategori dan temukan informasi terbaru lainnya.
                    </p>
                    <a href="{{ route('news.index') }}" class="btn btn-primary">
                        <i class="fas fa-newspaper me-2"></i>Semua Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.news-card {
    transition: all 0.3s ease;
}

.news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.btn-outline-primary:hover {
    transform: translateX(2px);
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa !important;
}

.bg-gradient {
    position: relative;
    overflow: hidden;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .d-flex.gap-2 .form-control,
    .d-flex.gap-2 .btn {
        width: 100%;
    }
    
    .btn-group-sm {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .btn-group-sm .btn {
        flex: 1;
    }
}

.badge.float-end {
    float: right !important;
}
</style>
@endsection
