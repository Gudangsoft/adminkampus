@extends('layouts.app')

@section('title', $announcement->title . ' - Pengumuman - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))
@section('meta_description', Str::limit(strip_tags($announcement->excerpt), 160))
@section('meta_keywords', 'pengumuman, ' . ($globalSettings['site_keywords'] ?? 'kampus, universitas'))

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Pengumuman</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($announcement->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm">
                <!-- Priority Alert -->
                @if($announcement->priority == 'urgent')
                    <div class="alert alert-danger mb-0 rounded-top" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>PENGUMUMAN MENDESAK</strong> - Mohon perhatian khusus untuk pengumuman ini
                    </div>
                @elseif($announcement->is_pinned)
                    <div class="alert alert-warning mb-0 rounded-top" role="alert">
                        <i class="fas fa-thumbtack me-2"></i>
                        <strong>PENGUMUMAN PENTING</strong> - Disematkan oleh admin
                    </div>
                @endif

                <!-- Featured Image -->
                @if($announcement->featured_image)
                    <div class="card-img-top" style="height: 300px; overflow: hidden;">
                        <img src="{{ Storage::url($announcement->featured_image) }}" 
                             alt="{{ $announcement->title }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover;">
                    </div>
                @endif

                <div class="card-body">
                    <!-- Title and Meta -->
                    <header class="mb-4">
                        <h1 class="h2 fw-bold mb-3">{{ $announcement->title }}</h1>
                        
                        <!-- Badges -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($announcement->priority == 'urgent')
                                <span class="badge bg-danger">
                                    <i class="fas fa-exclamation-circle me-1"></i>Mendesak
                                </span>
                            @elseif($announcement->priority == 'high')
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation me-1"></i>Penting
                                </span>
                            @elseif($announcement->priority == 'medium')
                                <span class="badge bg-info">
                                    <i class="fas fa-info-circle me-1"></i>Sedang
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-info me-1"></i>Rendah
                                </span>
                            @endif
                            
                            @if($announcement->is_pinned)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-thumbtack me-1"></i>Disematkan
                                </span>
                            @endif
                            
                            @if($announcement->expires_at && $announcement->expires_at->isFuture())
                                <span class="badge bg-secondary">
                                    <i class="fas fa-clock me-1"></i>
                                    Berakhir {{ $announcement->expires_at->format('d M Y, H:i') }}
                                </span>
                            @endif
                        </div>

                        <!-- Meta Information -->
                        <div class="row text-muted small mb-3">
                            <div class="col-md-6">
                                <i class="fas fa-user me-1"></i>Ditulis oleh: <strong>{{ $announcement->user->name }}</strong>
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-calendar me-1"></i>{{ $announcement->published_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-eye me-1"></i>{{ number_format($announcement->views) }} kali dilihat
                            </div>
                            <div class="col-md-6">
                                @if($announcement->updated_at != $announcement->created_at)
                                    <i class="fas fa-edit me-1"></i>Diperbarui: {{ $announcement->updated_at->format('d M Y, H:i') }}
                                @endif
                            </div>
                        </div>
                    </header>

                    <!-- Excerpt -->
                    @if($announcement->excerpt)
                        <div class="alert alert-light border-start border-primary border-3 mb-4">
                            <h6 class="fw-bold mb-2">Ringkasan:</h6>
                            <p class="mb-0 text-muted">{{ $announcement->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="announcement-content">
                        {!! $announcement->content !!}
                    </div>

                    <!-- Expiry Notice -->
                    @if($announcement->expires_at)
                        <div class="alert alert-info mt-4" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Pengumuman ini berlaku hingga 
                            <strong>{{ $announcement->expires_at->format('d F Y, H:i') }} WIB</strong>
                            @if($announcement->expires_at->isPast())
                                <span class="text-danger">(Sudah berakhir)</span>
                            @else
                                ({{ $announcement->expires_at->diffForHumans() }})
                            @endif
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3">Bagikan:</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($announcement->title) }}" 
                               target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($announcement->title . ' - ' . request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                                <i class="fas fa-link me-1"></i>Salin Link
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Navigation -->
            <div class="row mt-4">
                <div class="col-md-6">
                    @if($previousAnnouncement)
                        <a href="{{ route('announcements.show', $previousAnnouncement->slug) }}" 
                           class="btn btn-outline-primary w-100 text-start">
                            <i class="fas fa-arrow-left me-2"></i>
                            <small class="d-block text-muted">Sebelumnya</small>
                            {{ Str::limit($previousAnnouncement->title, 50) }}
                        </a>
                    @endif
                </div>
                <div class="col-md-6">
                    @if($nextAnnouncement)
                        <a href="{{ route('announcements.show', $nextAnnouncement->slug) }}" 
                           class="btn btn-outline-primary w-100 text-end">
                            <i class="fas fa-arrow-right ms-2"></i>
                            <small class="d-block text-muted">Selanjutnya</small>
                            {{ Str::limit($nextAnnouncement->title, 50) }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recent Announcements -->
            @if($recentAnnouncements->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-bullhorn me-2"></i>Pengumuman Terbaru
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @foreach($recentAnnouncements as $recent)
                            <div class="border-bottom p-3 {{ $loop->last ? '' : 'border-bottom' }}">
                                <h6 class="mb-2">
                                    <a href="{{ route('announcements.show', $recent->slug) }}" 
                                       class="text-decoration-none">
                                        {{ Str::limit($recent->title, 60) }}
                                    </a>
                                </h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $recent->published_at->format('d M Y') }}
                                    </small>
                                    @if($recent->priority == 'urgent')
                                        <span class="badge bg-danger badge-sm">Mendesak</span>
                                    @elseif($recent->priority == 'high')
                                        <span class="badge bg-warning text-dark badge-sm">Penting</span>
                                    @elseif($recent->priority == 'medium')
                                        <span class="badge bg-info badge-sm">Sedang</span>
                                    @elseif($recent->priority == 'low')
                                        <span class="badge bg-secondary badge-sm">Rendah</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('announcements.index') }}" class="btn btn-link btn-sm">
                            Lihat Semua Pengumuman <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Contact Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Kontak
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Jika Anda memiliki pertanyaan terkait pengumuman ini, silakan hubungi kami:
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
                                WhatsApp
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.announcement-content {
    line-height: 1.8;
}

.announcement-content h1,
.announcement-content h2,
.announcement-content h3,
.announcement-content h4,
.announcement-content h5,
.announcement-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.announcement-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.announcement-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.announcement-content ul,
.announcement-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.announcement-content li {
    margin-bottom: 0.5rem;
}

.announcement-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 2rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0 8px 8px 0;
}

.badge-sm {
    font-size: 0.7rem;
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
    });
}
</script>
@endsection
