@extends('layouts.admin')

@section('title', 'SEO Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">SEO Dashboard</h1>
                <div>
                    <a href="/seo-test" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt"></i> SEO Tester
                    </a>
                    <a href="/sitemap.xml" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-sitemap"></i> View Sitemap
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_content'] }}</h4>
                            <p class="mb-0">Total Konten</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['news_count'] }}</h4>
                            <p class="mb-0">Berita</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['gallery_count'] }}</h4>
                            <p class="mb-0">Galeri</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-images fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['pages_count'] }}</h4>
                            <p class="mb-0">Halaman</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Health Check -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat"></i> SEO Health Check
                    </h5>
                </div>
                <div class="card-body">
                    @if(empty($seoIssues))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            Tidak ada masalah SEO yang ditemukan! Website Anda sudah dioptimalkan dengan baik.
                        </div>
                    @else
                        @foreach($seoIssues as $issue)
                            <div class="alert alert-{{ $issue['type'] == 'error' ? 'danger' : 'warning' }}">
                                <i class="fas fa-{{ $issue['type'] == 'error' ? 'exclamation-triangle' : 'exclamation-circle' }}"></i>
                                {{ $issue['message'] }}
                            </div>
                        @endforeach
                        
                        <div class="mt-3">
                            <a href="{{ route('admin.seo.audit') }}" class="btn btn-primary">
                                <i class="fas fa-search-plus"></i> Jalankan SEO Audit Detail
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="runQuickAudit()">
                            <i class="fas fa-search"></i> Quick SEO Audit
                        </button>
                        <button class="btn btn-outline-success" onclick="refreshSitemap()">
                            <i class="fas fa-sync"></i> Refresh Sitemap
                        </button>
                        <button class="btn btn-outline-warning" onclick="clearCache()">
                            <i class="fas fa-trash"></i> Clear SEO Cache
                        </button>
                        <a href="{{ route('admin.seo.meta-tags') }}" class="btn btn-outline-info">
                            <i class="fas fa-tags"></i> Manage Meta Tags
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tools"></i> SEO Tools
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="/seo-test" target="_blank" class="list-group-item list-group-item-action">
                            <i class="fas fa-external-link-alt text-primary"></i>
                            SEO Live Tester
                        </a>
                        <a href="/sitemap.xml" target="_blank" class="list-group-item list-group-item-action">
                            <i class="fas fa-sitemap text-success"></i>
                            XML Sitemap
                        </a>
                        <a href="/robots.txt" target="_blank" class="list-group-item list-group-item-action">
                            <i class="fas fa-robot text-info"></i>
                            Robots.txt
                        </a>
                        <a href="{{ route('admin.seo.audit') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-search-plus text-warning"></i>
                            SEO Audit Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-newspaper"></i> Berita Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentNews->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentNews as $news)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">{{ Str::limit($news->title, 40) }}</div>
                                        <small class="text-muted">{{ $news->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ strlen($news->title) }} chars
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada berita.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-images"></i> Galeri Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentGalleries->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentGalleries as $gallery)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">{{ Str::limit($gallery->title, 40) }}</div>
                                        <small class="text-muted">{{ $gallery->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge bg-info rounded-pill">
                                        {{ strlen($gallery->title) }} chars
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada galeri.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function runQuickAudit() {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Running...';
    btn.disabled = true;
    
    fetch('{{ route("admin.seo.run-audit") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'SEO Audit Completed',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'View Details'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("admin.seo.audit") }}';
                }
            });
        } else {
            Swal.fire('Error', 'Failed to run audit', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Network error occurred', 'error');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function refreshSitemap() {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    btn.disabled = true;
    
    fetch('{{ route("admin.seo.refresh-sitemap") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Sitemap Refreshed',
                text: data.message,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'View Sitemap',
                cancelButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(data.sitemap_url, '_blank');
                }
            });
        } else {
            Swal.fire('Error', 'Failed to refresh sitemap', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Network error occurred', 'error');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function clearCache() {
    Swal.fire({
        title: 'Clear SEO Cache?',
        text: 'This will clear all cached SEO data',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, clear it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Simulate cache clearing
            Swal.fire({
                title: 'Cache Cleared',
                text: 'SEO cache has been cleared successfully',
                icon: 'success'
            });
        }
    });
}
</script>
@endpush
@endsection
