@extends('layouts.app')
@section('title', 'Pencarian' . (request('q') ? ' - ' . request('q') : '') . ' - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))
@section('meta_description', 'Hasil pencarian untuk: ' . (request('q') ?? 'Cari konten di situs kami'))

@push('styles')
<style>
    .search-page {
        padding-top: 120px;
        min-height: 80vh;
    }
    
    .search-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 3rem;
    }
    
    .search-box-large .form-control {
        border-radius: 25px;
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .search-box-large .btn {
        border-radius: 25px;
        padding: 1rem 2rem;
        font-weight: 600;
        margin-left: 1rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .search-filters {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .filter-btn {
        border-radius: 20px;
        padding: 0.5rem 1.5rem;
        margin: 0.25rem;
        border: 2px solid #e9ecef;
        background: white;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        background: #667eea;
        border-color: #667eea;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .search-result-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .search-result-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .result-type-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 2;
    }
    
    .result-image {
        height: 150px;
        object-fit: cover;
        width: 100%;
    }
    
    .result-content {
        padding: 1.5rem;
    }
    
    .result-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }
    
    .result-excerpt {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    .result-meta {
        font-size: 0.8rem;
        color: #95a5a6;
    }
    
    .no-results {
        text-align: center;
        padding: 3rem 0;
    }
    
    .no-results i {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }
    
    .search-suggestions {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 1rem 1.5rem;
        border-radius: 0 10px 10px 0;
        margin: 2rem 0;
    }
</style>
@endpush

@section('content')
<x-breadcrumb :items="[
    ['title' => 'Pencarian' . (request('q') ? ' - ' . request('q') : '')]
]" />

<div class="search-page">
    <!-- Search Hero -->
    <div class="search-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-4">
                        @if(request('q'))
                            Hasil Pencarian
                        @else
                            Pencarian
                        @endif
                    </h1>
                    @if(request('q'))
                        <p class="lead mb-4">Menampilkan hasil untuk: <strong>"{{ request('q') }}"</strong></p>
                    @else
                        <p class="lead mb-4">Cari berita, galeri, pengumuman, dan halaman lainnya</p>
                    @endif
                    
                    <!-- Large Search Box -->
                    <form action="{{ route('search') }}" method="GET" class="search-box-large">
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-8">
                                <input type="search" 
                                       name="q" 
                                       class="form-control" 
                                       placeholder="Masukkan kata kunci pencarian..." 
                                       value="{{ request('q') }}"
                                       required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-light w-100">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </div>
                        @if(request('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(request('q'))
            <!-- Search Filters -->
            <div class="search-filters">
                <h6 class="mb-3"><i class="fas fa-filter me-2"></i>Filter Hasil:</h6>
                <div class="d-flex flex-wrap">
                    <a href="{{ route('search', ['q' => request('q')]) }}" 
                       class="filter-btn {{ !request('type') || request('type') == 'all' ? 'active' : '' }}">
                        <i class="fas fa-th-large me-1"></i>Semua
                    </a>
                    <a href="{{ route('search', ['q' => request('q'), 'type' => 'news']) }}" 
                       class="filter-btn {{ request('type') == 'news' ? 'active' : '' }}">
                        <i class="fas fa-newspaper me-1"></i>Berita
                    </a>
                    <a href="{{ route('search', ['q' => request('q'), 'type' => 'gallery']) }}" 
                       class="filter-btn {{ request('type') == 'gallery' ? 'active' : '' }}">
                        <i class="fas fa-images me-1"></i>Galeri
                    </a>
                    <a href="{{ route('search', ['q' => request('q'), 'type' => 'announcements']) }}" 
                       class="filter-btn {{ request('type') == 'announcements' ? 'active' : '' }}">
                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                    </a>
                    <a href="{{ route('search', ['q' => request('q'), 'type' => 'pages']) }}" 
                       class="filter-btn {{ request('type') == 'pages' ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-1"></i>Halaman
                    </a>
                </div>
            </div>

            <!-- Search Results -->
            @if($total > 0)
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-search-plus me-2 text-primary"></i>
                        Ditemukan {{ $total }} hasil
                    </h5>
                    <small class="text-muted">
                        Filter: {{ 
                            request('type') == 'news' ? 'Berita' : 
                            (request('type') == 'gallery' ? 'Galeri' : 
                            (request('type') == 'announcements' ? 'Pengumuman' : 
                            (request('type') == 'pages' ? 'Halaman' : 'Semua')))
                        }}
                    </small>
                </div>

                <div class="row">
                    @foreach($results as $result)
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card search-result-card h-100">
                                <!-- Type Badge -->
                                <span class="result-type-badge badge bg-primary">
                                    @if($result->type == 'news')
                                        <i class="fas fa-newspaper me-1"></i>Berita
                                    @elseif($result->type == 'gallery')
                                        <i class="fas fa-images me-1"></i>Galeri
                                    @elseif($result->type == 'announcement')
                                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                                    @else
                                        <i class="fas fa-file-alt me-1"></i>Halaman
                                    @endif
                                </span>

                                @if($result->type == 'gallery' && isset($result->image_url))
                                    <img src="{{ $result->image_url }}" alt="{{ $result->title }}" class="result-image">
                                @elseif($result->type == 'news' && isset($result->featured_image_url))
                                    <img src="{{ $result->featured_image_url }}" alt="{{ $result->title }}" class="result-image">
                                @elseif($result->type == 'news' && isset($result->featured_image))
                                    <img src="{{ Storage::url($result->featured_image) }}" alt="{{ $result->title }}" class="result-image">
                                @endif

                                <div class="result-content">
                                    <h6 class="result-title">
                                        <a href="{{ $result->url }}" class="text-decoration-none text-dark">
                                            {{ $result->title }}
                                        </a>
                                    </h6>
                                    
                                    @if(isset($result->excerpt) && $result->excerpt)
                                        <p class="result-excerpt">{{ Str::limit($result->excerpt, 120) }}</p>
                                    @elseif(isset($result->description) && $result->description)
                                        <p class="result-excerpt">{{ Str::limit($result->description, 120) }}</p>
                                    @elseif(isset($result->content))
                                        <p class="result-excerpt">{{ Str::limit(strip_tags($result->content), 120) }}</p>
                                    @endif

                                    <div class="result-meta">
                                        @if(isset($result->published_at))
                                            <i class="fas fa-calendar-alt me-1"></i>{{ $result->published_at->format('d M Y') }}
                                        @elseif(isset($result->created_at))
                                            <i class="fas fa-calendar-alt me-1"></i>{{ $result->created_at->format('d M Y') }}
                                        @endif
                                        
                                        @if(isset($result->category) && $result->category)
                                            <span class="ms-3">
                                                <i class="fas fa-tag me-1"></i>{{ $result->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Results -->
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h4>Tidak ada hasil ditemukan</h4>
                    <p class="text-muted">Tidak ditemukan hasil untuk pencarian "<strong>{{ request('q') }}</strong>"</p>
                    
                    <div class="search-suggestions">
                        <h6><i class="fas fa-lightbulb me-2"></i>Saran Pencarian:</h6>
                        <ul class="list-unstyled mb-0">
                            <li>• Periksa ejaan kata kunci</li>
                            <li>• Gunakan kata kunci yang lebih umum</li>
                            <li>• Coba kata kunci yang berbeda</li>
                            <li>• Gunakan filter untuk mempersempit pencarian</li>
                        </ul>
                    </div>
                </div>
            @endif
        @else
            <!-- Search Guide -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-5x text-muted mb-4"></i>
                        <h3>Mulai Pencarian Anda</h3>
                        <p class="text-muted mb-4">Cari berita, galeri, pengumuman, dan halaman di {{ $globalSettings['site_name'] ?? 'situs kami' }}</p>
                        
                        <div class="row g-4 mt-4">
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-newspaper fa-2x text-primary mb-3"></i>
                                        <h6>Berita</h6>
                                        <small class="text-muted">Artikel dan berita terbaru</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-images fa-2x text-success mb-3"></i>
                                        <h6>Galeri</h6>
                                        <small class="text-muted">Foto dan video kegiatan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-bullhorn fa-2x text-warning mb-3"></i>
                                        <h6>Pengumuman</h6>
                                        <small class="text-muted">Informasi penting</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-alt fa-2x text-info mb-3"></i>
                                        <h6>Halaman</h6>
                                        <small class="text-muted">Informasi umum</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus search input
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
    
    // Loading state for search forms
    const searchForms = document.querySelectorAll('form[action*="search"]');
    searchForms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mencari...';
                submitBtn.disabled = true;
                
                // Re-enable after some time (fallback)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });
    
    // Search suggestions and live search (optional enhancement)
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            // Add some visual feedback
            if (query.length > 2) {
                this.style.borderColor = '#28a745';
            } else {
                this.style.borderColor = '';
            }
        });
    }
    
    // Smooth scrolling for filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add loading state to filter
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>' + this.textContent;
        });
    });
});
</script>
@endpush
