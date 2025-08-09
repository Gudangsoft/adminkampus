@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.category', $gallery->category->slug) }}">{{ $gallery->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $gallery->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    @if($gallery->type == 'image')
                        <img src="{{ $gallery->image_url }}" 
                             class="w-100" 
                             alt="{{ $gallery->title }}"
                             style="max-height: 500px; object-fit: cover;">
                    @else
                        <!-- YouTube Video Embed -->
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $gallery->youtube_id }}" 
                                    title="{{ $gallery->title }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gallery Info -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="card-title h3 mb-2">{{ $gallery->title }}</h1>
                            <div class="d-flex flex-wrap gap-3 text-muted small">
                                <span><i class="fas fa-folder me-1"></i>{{ $gallery->category->name }}</span>
                                <span><i class="fas fa-calendar me-1"></i>{{ $gallery->created_at->format('d F Y') }}</span>
                                @if($gallery->type == 'video')
                                    <span><i class="fas fa-eye me-1"></i>{{ number_format($gallery->views) }} views</span>
                                @endif
                                <span><i class="fas fa-user me-1"></i>{{ $gallery->user->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                        @if($gallery->type == 'video')
                            <span class="badge bg-danger">
                                <i class="fab fa-youtube me-1"></i>Video YouTube
                            </span>
                        @else
                            <span class="badge bg-primary">
                                <i class="fas fa-image me-1"></i>Gambar
                            </span>
                        @endif
                    </div>
                    
                    @if($gallery->description)
                        <div class="gallery-description">
                            <h5>Deskripsi</h5>
                            <p class="text-muted">{{ $gallery->description }}</p>
                        </div>
                    @endif

                    @if($gallery->type == 'video' && $gallery->youtube_url)
                        <div class="mt-3">
                            <h6>Tonton di YouTube</h6>
                            <a href="{{ $gallery->youtube_url }}" 
                               target="_blank" 
                               class="btn btn-danger btn-sm">
                                <i class="fab fa-youtube me-1"></i>Buka di YouTube
                            </a>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="mb-3">Bagikan</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($gallery->title) }}" 
                               target="_blank" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($gallery->title . ' - ' . request()->fullUrl()) }}" 
                               target="_blank" 
                               class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                            <button type="button" 
                                    class="btn btn-outline-secondary btn-sm" 
                                    onclick="copyToClipboard('{{ request()->fullUrl() }}')">
                                <i class="fas fa-copy me-1"></i>Salin Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Gallery -->
            @if($relatedGalleries->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Galeri Terkait</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedGalleries as $related)
                    <div class="d-flex mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                        <div class="flex-shrink-0 me-3">
                            @if($related->type == 'image')
                                <img src="{{ $related->image_url }}" 
                                     class="rounded" 
                                     alt="{{ $related->title }}"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @else
                                <div class="position-relative">
                                    <img src="{{ $related->youtube_thumbnail }}" 
                                         class="rounded" 
                                         alt="{{ $related->title }}"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-play-circle text-white"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('gallery.show', $related->slug) }}" 
                                   class="text-decoration-none">
                                    {{ Str::limit($related->title, 40) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $related->created_at->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('gallery.category', $gallery->category->slug) }}" 
                       class="btn btn-sm btn-outline-primary w-100">
                        Lihat Semua dari {{ $gallery->category->name }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Navigation -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('gallery.index') }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Galeri
                        </a>
                        <a href="{{ route('gallery.category', $gallery->category->slug) }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-folder me-1"></i>{{ $gallery->category->name }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Gallery Stats (for videos) -->
            @if($gallery->type == 'video')
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Statistik Video</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ number_format($gallery->views) }}</h4>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $gallery->category->galleries_count ?? 0 }}</h4>
                            <small class="text-muted">Video di Kategori</small>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'toast position-fixed top-0 end-0 m-3';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Link berhasil disalin ke clipboard!
            </div>
        `;
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            document.body.removeChild(toast);
        });
    }).catch(function(err) {
        console.error('Gagal menyalin: ', err);
        alert('Gagal menyalin link. Silakan salin manual dari address bar.');
    });
}
</script>
@endpush
@endsection
