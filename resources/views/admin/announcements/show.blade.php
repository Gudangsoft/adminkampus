@extends('layouts.admin')

@section('title', 'Detail Pengumuman - ' . $announcement->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Detail Pengumuman</h3>
                    <div>
                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="mb-3">{{ $announcement->title }}</h1>
                            
                            <div class="announcement-meta mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i> 
                                            Dibuat oleh: {{ $announcement->user->name ?? 'Unknown' }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> 
                                            {{ $announcement->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                                @if($announcement->published_at && $announcement->published_at != $announcement->created_at)
                                <div class="row mt-1">
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-check"></i> 
                                            Dipublikasi: {{ $announcement->published_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Excerpt -->
                            <div class="announcement-excerpt mb-4 p-3 bg-light rounded">
                                <h6 class="text-muted mb-2">Ringkasan:</h6>
                                <p class="mb-0">{{ $announcement->excerpt }}</p>
                            </div>

                            <!-- Content -->
                            <div class="announcement-content">
                                <h6 class="text-muted mb-3">Konten:</h6>
                                <div class="content-body">
                                    {!! $announcement->content !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="announcement-sidebar">
                                <!-- Status Card -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Status Pengumuman</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="fw-bold">Status:</label>
                                            @if($announcement->status == 'published')
                                                <span class="badge bg-success ms-2">Dipublikasi</span>
                                            @elseif($announcement->status == 'draft')
                                                <span class="badge bg-warning ms-2">Draft</span>
                                            @else
                                                <span class="badge bg-secondary ms-2">Diarsipkan</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="fw-bold">Prioritas:</label>
                                            @if($announcement->priority == 'urgent')
                                                <span class="badge bg-danger ms-2">Urgent</span>
                                            @elseif($announcement->priority == 'high')
                                                <span class="badge bg-warning ms-2">Tinggi</span>
                                            @elseif($announcement->priority == 'medium')
                                                <span class="badge bg-info ms-2">Sedang</span>
                                            @else
                                                <span class="badge bg-secondary ms-2">Rendah</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="fw-bold">Pin Status:</label>
                                            @if($announcement->is_pinned)
                                                <span class="badge bg-primary ms-2">
                                                    <i class="fas fa-thumbtack"></i> Dipinned
                                                </span>
                                            @else
                                                <span class="text-muted ms-2">Tidak dipinned</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-0">
                                            <label class="fw-bold">Views:</label>
                                            <span class="ms-2">{{ number_format($announcement->views) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Info -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Informasi SEO</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="fw-bold">Slug:</label>
                                            <code class="d-block">{{ $announcement->slug }}</code>
                                        </div>
                                        
                                        @if($announcement->status == 'published')
                                        <div class="mb-0">
                                            <label class="fw-bold">URL Publik:</label>
                                            <a href="{{ route('announcements.show', $announcement->slug) }}" 
                                               target="_blank" class="btn btn-sm btn-outline-primary d-block">
                                                <i class="fas fa-external-link-alt"></i> Lihat di Frontend
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.announcement-content .content-body {
    line-height: 1.8;
}

.announcement-content .content-body h1,
.announcement-content .content-body h2,
.announcement-content .content-body h3,
.announcement-content .content-body h4,
.announcement-content .content-body h5,
.announcement-content .content-body h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.announcement-content .content-body p {
    margin-bottom: 1rem;
}

.announcement-content .content-body ul,
.announcement-content .content-body ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.announcement-content .content-body blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin-left: 0;
    font-style: italic;
    color: #6c757d;
}
</style>
@endsection
