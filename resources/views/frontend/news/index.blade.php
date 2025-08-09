@extends('layouts.app')

@section('title', 'Berita - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded">
                <h1 class="h2 mb-2">
                    <i class="fas fa-newspaper me-2"></i>Berita Terkini
                </h1>
                <p class="mb-0">Informasi terbaru dan berita terkini dari {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <form method="GET" action="{{ route('news.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                <select name="category" class="form-select" style="min-width: 180px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="col-lg-4">
            <div class="d-flex justify-content-lg-end">
                <small class="text-muted align-self-center">
                    Menampilkan {{ $news->firstItem() ?? 0 }} - {{ $news->lastItem() ?? 0 }} 
                    dari {{ $news->total() }} berita
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Featured News Section -->
            @if($featuredNews->count() > 0 && !request()->hasAny(['search', 'category']))
                <div class="mb-5">
                    <h3 class="h5 mb-3 text-primary fw-bold">
                        <i class="fas fa-star me-2"></i>Berita Unggulan
                    </h3>
                    <div class="row">
                        @foreach($featuredNews->take(3) as $featured)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-0 shadow-sm featured-card">
                                    @if($featured->featured_image)
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($featured->featured_image) }}" 
                                                 alt="{{ $featured->title }}" 
                                                 class="card-img-top" 
                                                 style="height: 180px; object-fit: cover;">
                                            <div class="position-absolute top-0 start-0 m-2">
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star me-1"></i>Unggulan
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="badge bg-primary text-white">{{ $featured->category->name }}</span>
                                            <small class="text-muted ms-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $featured->published_at->format('d M Y') }}
                                            </small>
                                        </div>
                                        <h6 class="card-title">
                                            <a href="{{ route('news.show', $featured->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($featured->title, 60) }}
                                            </a>
                                        </h6>
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($featured->excerpt, 80) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="my-4">
                </div>
            @endif

            <!-- News Grid -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0 text-primary fw-bold">
                    @if(request('category'))
                        <i class="fas fa-folder me-2"></i>
                        Berita: {{ $categories->where('slug', request('category'))->first()->name ?? 'Kategori' }}
                    @elseif(request('search'))
                        <i class="fas fa-search me-2"></i>
                        Hasil Pencarian: "{{ request('search') }}"
                    @else
                        <i class="fas fa-newspaper me-2"></i>Semua Berita
                    @endif
                </h3>
                
                <!-- Sort Options -->
                <div class="btn-group btn-group-sm" role="group">
                    <input type="radio" class="btn-check" name="sort" id="sort-latest" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="sort-latest">
                        <i class="fas fa-clock me-1"></i>Terbaru
                    </label>
                    <input type="radio" class="btn-check" name="sort" id="sort-popular" autocomplete="off">
                    <label class="btn btn-outline-primary" for="sort-popular">
                        <i class="fas fa-fire me-1"></i>Populer
                    </label>
                </div>
            </div>

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
                                    <!-- Category and Date -->
                                    <div class="mb-2">
                                        <a href="{{ route('news.category', $item->category->slug) }}" 
                                           class="badge bg-primary text-decoration-none">
                                            {{ $item->category->name }}
                                        </a>
                                        <small class="text-muted ms-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $item->published_at->format('d F Y') }}
                                        </small>
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
                                                <i class="fas fa-comments me-1"></i>{{ $item->comments_count }} komentar
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
                        <i class="fas fa-newspaper fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">Tidak ada berita</h5>
                    @if(request()->hasAny(['search', 'category']))
                        <p class="text-muted mb-3">Tidak ditemukan berita yang sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('news.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Lihat Semua Berita
                        </a>
                    @else
                        <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
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
            <!-- Categories -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-folder me-2"></i>Kategori Berita
                    </h6>
                </div>
                <div class="card-body p-0">
                    @foreach($categories as $category)
                        <a href="{{ route('news.category', $category->slug) }}" 
                           class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center {{ request('category') == $category->slug ? 'active' : '' }}">
                            <span>
                                <i class="fas fa-folder-open me-2"></i>{{ $category->name }}
                            </span>
                            <span class="badge bg-light text-dark">{{ $category->news_count ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Latest News -->
            @if($featuredNews->count() > 3)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>Berita Terbaru
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @foreach($featuredNews->skip(3)->take(5) as $latest)
                            <div class="border-bottom p-3 {{ $loop->last ? '' : 'border-bottom' }}">
                                <div class="d-flex">
                                    @if($latest->featured_image)
                                        <img src="{{ Storage::url($latest->featured_image) }}" 
                                             alt="{{ $latest->title }}" 
                                             class="me-3 rounded" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('news.show', $latest->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($latest->title, 70) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $latest->published_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Newsletter Subscribe -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-envelope me-2"></i>Newsletter
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Berlangganan newsletter untuk mendapatkan berita terbaru langsung di email Anda.
                    </p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email Anda" required>
                        </div>
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-paper-plane me-2"></i>Berlangganan
                        </button>
                    </form>
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

.featured-card {
    transition: all 0.3s ease;
}

.featured-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
}

.btn-outline-primary:hover {
    transform: translateX(2px);
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa !important;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .d-flex.gap-2 .form-control,
    .d-flex.gap-2 .form-select,
    .d-flex.gap-2 .btn {
        width: 100%;
    }
    
    .btn-group-sm {
        width: 100%;
    }
    
    .btn-group-sm .btn {
        flex: 1;
    }
}
</style>
@endsection
