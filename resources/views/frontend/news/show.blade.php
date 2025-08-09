@extends('layouts.app')

@section('title', $news->title . ' - Berita - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))
@section('meta_description', Str::limit(strip_tags($news->excerpt), 160))
@section('meta_keywords', $news->category->name . ', berita, ' . ($globalSettings['site_keywords'] ?? 'kampus, universitas'))

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Berita</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news.category', $news->category->slug) }}">{{ $news->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($news->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm">
                <!-- Featured Badge -->
                @if($news->is_featured)
                    <div class="alert alert-warning mb-0 rounded-top" role="alert">
                        <i class="fas fa-star me-2"></i>
                        <strong>BERITA UNGGULAN</strong> - Artikel pilihan editor
                    </div>
                @endif

                <!-- Featured Image -->
                @if($news->featured_image)
                    <div class="card-img-top position-relative" style="height: 400px; overflow: hidden;">
                        <img src="{{ Storage::url($news->featured_image) }}" 
                             alt="{{ $news->title }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-primary fs-6">
                                {{ $news->category->name }}
                            </span>
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    <!-- Title and Meta -->
                    <header class="mb-4">
                        <h1 class="h2 fw-bold mb-3">{{ $news->title }}</h1>
                        
                        <!-- Meta Information -->
                        <div class="row text-muted small mb-3">
                            <div class="col-md-6">
                                <i class="fas fa-user me-1"></i>Ditulis oleh: <strong>{{ $news->user->name }}</strong>
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-calendar me-1"></i>{{ $news->published_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-eye me-1"></i>{{ number_format($news->views) }} kali dibaca
                            </div>
                            <div class="col-md-6">
                                @if($news->updated_at != $news->created_at)
                                    <i class="fas fa-edit me-1"></i>Diperbarui: {{ $news->updated_at->format('d M Y, H:i') }}
                                @endif
                            </div>
                        </div>
                    </header>

                    <!-- Excerpt -->
                    @if($news->excerpt)
                        <div class="alert alert-light border-start border-primary border-3 mb-4">
                            <h6 class="fw-bold mb-2">Ringkasan:</h6>
                            <p class="mb-0 text-muted">{{ $news->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="news-content">
                        {!! $news->content !!}
                    </div>

                    <!-- Tags -->
                    @if($news->tags && count($news->tags) > 0)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="fw-bold mb-3">Tags:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($news->tags as $tag)
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-tag me-1"></i>{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3">Bagikan Artikel:</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}" 
                               target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-dark btn-sm">
                                <i class="fab fa-linkedin me-1"></i>LinkedIn
                            </a>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                                <i class="fas fa-link me-1"></i>Salin Link
                            </button>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $news->user->name }}</h6>
                                <p class="text-muted small mb-0">
                                    Penulis di {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related News -->
            @if($relatedNews->count() > 0)
                <div class="mt-5">
                    <h4 class="fw-bold mb-4">Berita Terkait</h4>
                    <div class="row">
                        @foreach($relatedNews as $related)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    @if($related->featured_image)
                                        <img src="{{ Storage::url($related->featured_image) }}" 
                                             alt="{{ $related->title }}" 
                                             class="card-img-top" 
                                             style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-2">
                                            <span class="badge bg-primary">{{ $related->category->name }}</span>
                                            <small class="text-muted ms-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $related->published_at->format('d M Y') }}
                                            </small>
                                        </div>
                                        <h6 class="card-title flex-grow-1">
                                            <a href="{{ route('news.show', $related->slug) }}" 
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($related->title, 80) }}
                                            </a>
                                        </h6>
                                        <div class="mt-auto">
                                            <a href="{{ route('news.show', $related->slug) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Latest News -->
            @if($latestNews->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-newspaper me-2"></i>Berita Terbaru
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @foreach($latestNews as $latest)
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
                                                {{ Str::limit($latest->title, 60) }}
                                            </a>
                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $latest->published_at->format('d M Y') }}
                                            </small>
                                            <span class="badge bg-primary badge-sm">{{ $latest->category->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('news.index') }}" class="btn btn-link btn-sm">
                            Lihat Semua Berita <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Category Navigation -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-folder me-2"></i>Kategori Lainnya
                    </h6>
                </div>
                <div class="card-body p-0">
                    <a href="{{ route('news.category', $news->category->slug) }}" 
                       class="list-group-item list-group-item-action border-0 active">
                        <i class="fas fa-folder-open me-2"></i>{{ $news->category->name }}
                        <span class="badge bg-light text-dark float-end">Kategori Ini</span>
                    </a>
                    <a href="{{ route('news.index') }}" 
                       class="list-group-item list-group-item-action border-0">
                        <i class="fas fa-newspaper me-2"></i>Semua Berita
                    </a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Redaksi
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Ada pertanyaan atau saran untuk redaksi? Silakan hubungi kami:
                    </p>
                    @if($globalSettings['contact_email'] ?? false)
                        <div class="mb-2">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            <a href="mailto:{{ $globalSettings['contact_email'] }}" class="text-decoration-none">
                                {{ $globalSettings['contact_email'] }}
                            </a>
                        </div>
                    @endif
                    @if($globalSettings['contact_phone'] ?? false)
                        <div class="mb-2">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <a href="tel:{{ $globalSettings['contact_phone'] }}" class="text-decoration-none">
                                {{ $globalSettings['contact_phone'] }}
                            </a>
                        </div>
                    @endif
                    @if($globalSettings['contact_whatsapp'] ?? false)
                        <div class="mb-2">
                            <i class="fab fa-whatsapp text-success me-2"></i>
                            <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $globalSettings['contact_whatsapp']) }}" 
                               target="_blank" class="text-decoration-none">
                                WhatsApp Redaksi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.news-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.news-content h1,
.news-content h2,
.news-content h3,
.news-content h4,
.news-content h5,
.news-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.news-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.news-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.news-content ul,
.news-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.news-content li {
    margin-bottom: 0.5rem;
}

.news-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 2rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0 8px 8px 0;
}

.news-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}

.news-content th,
.news-content td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.news-content th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.badge-sm {
    font-size: 0.7rem;
}

.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .news-content {
        font-size: 1rem;
    }
}
</style>

<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Tersalin!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin link');
    });
}
</script>
@endsection
