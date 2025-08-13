@extends('layouts.app')

@section('title', 'Pengumuman - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded">
                <h1 class="h2 mb-2">
                    <i class="fas fa-bullhorn me-2"></i>Pengumuman
                </h1>
                <p class="mb-0">Informasi terbaru dan pengumuman penting dari {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <form method="GET" action="{{ route('announcements.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari pengumuman..." value="{{ request('search') }}">
                <select name="priority" class="form-select" style="min-width: 150px;">
                    <option value="">Semua Prioritas</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request()->hasAny(['search', 'priority']))
                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="col-lg-4">
            <div class="d-flex justify-content-lg-end">
                <small class="text-muted align-self-center">
                    Menampilkan {{ $announcements->firstItem() ?? 0 }} - {{ $announcements->lastItem() ?? 0 }} 
                    dari {{ $announcements->total() }} pengumuman
                </small>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="row">
        @forelse($announcements as $announcement)
            <div class="col-12 mb-4">
                <div class="card h-100 shadow-sm border-0 
                    @if($announcement->is_featured) border-warning border-2 @endif
                    @if($announcement->priority == 'urgent') border-danger border-2 @endif">
                    
                    @if($announcement->is_featured || $announcement->priority == 'urgent')
                        <div class="card-header 
                            @if($announcement->priority == 'urgent') bg-danger text-white @else bg-warning text-dark @endif
                            py-2">
                            <small class="fw-bold">
                                @if($announcement->priority == 'urgent')
                                    <i class="fas fa-exclamation-triangle me-1"></i>MENDESAK
                                @elseif($announcement->is_featured)
                                    <i class="fas fa-star me-1"></i>UNGGULAN
                                @endif
                            </small>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="row">
                            @if($announcement->featured_image)
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <img src="{{ Storage::url($announcement->featured_image) }}" 
                                         alt="{{ $announcement->title }}" 
                                         class="img-fluid rounded" 
                                         style="height: 150px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                            @else
                                <div class="col-12">
                            @endif
                                <!-- Priority Badge -->
                                <div class="d-flex align-items-center mb-2">
                                    @if($announcement->priority == 'urgent')
                                        <span class="badge bg-danger me-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>Mendesak
                                        </span>
                                    @elseif($announcement->priority == 'high')
                                        <span class="badge bg-warning text-dark me-2">
                                            <i class="fas fa-exclamation me-1"></i>Penting
                                        </span>
                                    @elseif($announcement->priority == 'medium')
                                        <span class="badge bg-info me-2">
                                            <i class="fas fa-info-circle me-1"></i>Sedang
                                        </span>
                                    @else
                                        <span class="badge bg-secondary me-2">
                                            <i class="fas fa-info me-1"></i>Rendah
                                        </span>
                                    @endif
                                    
                                    <!-- Expires badge -->
                                    @if($announcement->expires_at && $announcement->expires_at->isFuture())
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-clock me-1"></i>
                                            Berakhir {{ $announcement->expires_at->format('d M Y') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Title -->
                                <h5 class="card-title">
                                    <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                       class="text-decoration-none text-dark fw-bold">
                                        {{ $announcement->title }}
                                    </a>
                                </h5>

                                <!-- Excerpt -->
                                <p class="text-muted mb-3">
                                    {{ Str::limit($announcement->excerpt, 150) }}
                                </p>

                                <!-- Meta Information -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        <i class="fas fa-user me-1"></i>{{ $announcement->user->name }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-calendar me-1"></i>{{ $announcement->start_date->format('d M Y') }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-eye me-1"></i>{{ number_format($announcement->views) }} views
                                    </div>
                                    <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-bullhorn fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">Tidak ada pengumuman</h5>
                    @if(request()->hasAny(['search', 'priority']))
                        <p class="text-muted mb-3">Tidak ditemukan pengumuman yang sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('announcements.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Lihat Semua Pengumuman
                        </a>
                    @else
                        <p class="text-muted">Belum ada pengumuman yang dipublikasikan.</p>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($announcements->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $announcements->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.btn-outline-primary:hover {
    transform: translateX(2px);
    transition: all 0.3s ease;
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
}
</style>
@endsection
