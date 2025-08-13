@extends('layouts.admin')

@section('title', 'Sitemap Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Sitemap Management</h1>
                <div>
                    <a href="/sitemap.xml" target="_blank" class="btn btn-success">
                        <i class="fas fa-external-link-alt"></i> View XML Sitemap
                    </a>
                    <button class="btn btn-primary" onclick="refreshSitemap()">
                        <i class="fas fa-sync"></i> Refresh Sitemap
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sitemap Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-sitemap"></i> Sitemap Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-3">
                                XML Sitemap membantu search engine menemukan dan mengindeks halaman-halaman di website Anda. 
                                Sitemap secara otomatis diperbarui ketika konten baru ditambahkan.
                            </p>
                            <div class="alert alert-info">
                                <strong>Sitemap URL:</strong> 
                                <a href="/sitemap.xml" target="_blank" class="alert-link">/sitemap.xml</a>
                            </div>
                            <div class="alert alert-success">
                                <strong>Robots.txt URL:</strong> 
                                <a href="/robots.txt" target="_blank" class="alert-link">/robots.txt</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="text-primary">{{ count($urls) }}</h4>
                                    <p class="mb-0">Total URLs in Sitemap</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- URL Statistics -->
    <div class="row mb-4">
        @php
            $urlsByType = collect($urls)->groupBy('type');
        @endphp
        
        @foreach($urlsByType as $type => $typeUrls)
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-{{ $type === 'Homepage' ? 'primary' : ($type === 'News' ? 'success' : ($type === 'Gallery' ? 'info' : 'warning')) }} text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $typeUrls->count() }}</h4>
                            <p class="mb-0">{{ $type }} URLs</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-{{ $type === 'Homepage' ? 'home' : ($type === 'News' ? 'newspaper' : ($type === 'Gallery' ? 'images' : 'file-alt')) }} fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Sitemap URLs Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Sitemap URLs
                    </h5>
                    <div>
                        <select class="form-select form-select-sm" id="typeFilter" onchange="filterByType()">
                            <option value="">All Types</option>
                            <option value="Homepage">Homepage</option>
                            <option value="News">News</option>
                            <option value="Gallery">Gallery</option>
                            <option value="Page">Pages</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="urlsTable">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Last Modified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($urls as $url)
                                <tr data-type="{{ $url['type'] }}">
                                    <td>
                                        <a href="{{ $url['url'] }}" target="_blank" class="text-decoration-none">
                                            {{ Str::limit($url['url'], 60) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $url['type'] === 'Homepage' ? 'primary' : ($url['type'] === 'News' ? 'success' : ($url['type'] === 'Gallery' ? 'info' : 'warning')) }}">
                                            {{ $url['type'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $url['priority'] }}</span>
                                    </td>
                                    <td>
                                        @if(isset($url['last_modified']))
                                            <small>{{ \Carbon\Carbon::parse($url['last_modified'])->format('d M Y H:i') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ $url['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        @if($url['type'] !== 'Homepage')
                                            <button class="btn btn-sm btn-outline-info" onclick="checkSEO('{{ $url['url'] }}')">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sitemap Instructions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-question-circle"></i> How to Submit Your Sitemap
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fab fa-google text-danger"></i> Google Search Console</h6>
                            <ol>
                                <li>Go to <a href="https://search.google.com/search-console" target="_blank">Google Search Console</a></li>
                                <li>Select your property</li>
                                <li>Go to "Sitemaps" in the left menu</li>
                                <li>Enter: <code>sitemap.xml</code></li>
                                <li>Click "Submit"</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fab fa-microsoft text-primary"></i> Bing Webmaster Tools</h6>
                            <ol>
                                <li>Go to <a href="https://www.bing.com/webmasters" target="_blank">Bing Webmaster Tools</a></li>
                                <li>Select your site</li>
                                <li>Go to "Configure My Site" > "Sitemaps"</li>
                                <li>Enter: <code>{{ url('/sitemap.xml') }}</code></li>
                                <li>Click "Submit"</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div class="alert alert-success mt-3">
                        <strong>Tip:</strong> After submitting your sitemap, it may take a few days for search engines to crawl and index your pages. 
                        You can monitor the indexing status in the respective webmaster tools.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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

function filterByType() {
    const filter = document.getElementById('typeFilter').value;
    const rows = document.querySelectorAll('#urlsTable tbody tr');
    
    rows.forEach(row => {
        if (filter === '' || row.dataset.type === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function checkSEO(url) {
    window.open('/seo-test', '_blank');
}
</script>
@endpush
@endsection
