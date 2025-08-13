@extends('layouts.app')

@section('title', 'Pencarian Lanjutan - ' . setting('site_name', config('app.name')))

@section('meta_description', 'Cari berita, pengumuman, galeri, mahasiswa, dan dosen dengan fitur pencarian lanjutan yang powerful.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Search Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-search me-2"></i>
                    Pencarian Lanjutan
                </h1>
                <p class="lead text-muted">
                    Temukan informasi yang Anda cari dengan filter dan kategori yang lengkap
                </p>
            </div>

            <!-- Advanced Search Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filter Pencarian
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('search.advanced') }}" id="advancedSearchForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="search_query" class="form-label">Kata Kunci</label>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control" 
                                               id="search_query" 
                                               name="q" 
                                               value="{{ $query }}" 
                                               placeholder="Masukkan kata kunci pencarian..."
                                               autocomplete="off">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search me-1"></i> Cari
                                        </button>
                                    </div>
                                    <div id="search-suggestions" class="position-absolute w-100 bg-white border rounded-bottom shadow-sm" style="z-index: 1000; display: none;"></div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="content_type" class="form-label">Tipe Konten</label>
                                    <select class="form-select" id="content_type" name="type">
                                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>Semua Konten</option>
                                        <option value="news" {{ $type == 'news' ? 'selected' : '' }}>Berita</option>
                                        <option value="announcements" {{ $type == 'announcements' ? 'selected' : '' }}>Pengumuman</option>
                                        <option value="galleries" {{ $type == 'galleries' ? 'selected' : '' }}>Galeri</option>
                                        <option value="students" {{ $type == 'students' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="lecturers" {{ $type == 'lecturers' ? 'selected' : '' }}>Dosen</option>
                                        <option value="pages" {{ $type == 'pages' ? 'selected' : '' }}>Halaman</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-select" id="category" name="category">
                                        <option value="">Semua Kategori</option>
                                        <!-- News Categories -->
                                        <optgroup label="Kategori Berita" id="news-categories" style="display: {{ in_array($type, ['all', 'news']) ? 'block' : 'none' }};">
                                            @foreach($newsCategories as $cat)
                                                <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <!-- Gallery Categories -->
                                        <optgroup label="Kategori Galeri" id="gallery-categories" style="display: {{ in_array($type, ['all', 'galleries']) ? 'block' : 'none' }};">
                                            @foreach($galleryCategories as $cat)
                                                <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <!-- Faculties -->
                                        <optgroup label="Fakultas" id="faculties" style="display: {{ in_array($type, ['all', 'students', 'lecturers']) ? 'block' : 'none' }};">
                                            @foreach($faculties as $faculty)
                                                <option value="{{ $faculty->id }}" {{ $category == $faculty->id ? 'selected' : '' }}>
                                                    {{ $faculty->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_from" class="form-label">Dari Tanggal</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $date_from }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_to" class="form-label">Sampai Tanggal</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $date_to }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort" class="form-label">Urutkan</label>
                                    <select class="form-select" id="sort" name="sort">
                                        <option value="relevance" {{ $sort == 'relevance' ? 'selected' : '' }}>Relevansi</option>
                                        <option value="date_desc" {{ $sort == 'date_desc' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="date_asc" {{ $sort == 'date_asc' ? 'selected' : '' }}>Terlama</option>
                                        <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-fill">
                                            <i class="fas fa-search me-1"></i> Cari Sekarang
                                        </button>
                                        <a href="{{ route('search.advanced') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            @if($query)
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list me-2"></i>
                                Hasil Pencarian
                            </h5>
                            <span class="badge bg-primary">{{ $total }} hasil ditemukan</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($results->count() > 0)
                            <div class="search-results">
                                @foreach($results as $result)
                                    <div class="search-result-item border-bottom pb-3 mb-3">
                                        <div class="row">
                                            @if($result['image'])
                                                <div class="col-md-2">
                                                    <img src="{{ $result['image'] }}" 
                                                         alt="{{ $result['title'] }}" 
                                                         class="img-fluid rounded"
                                                         style="max-height: 80px; object-fit: cover;">
                                                </div>
                                                <div class="col-md-10">
                                            @else
                                                <div class="col-md-12">
                                            @endif
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">
                                                            <a href="{{ $result['url'] }}" class="text-decoration-none">
                                                                {{ $result['title'] }}
                                                            </a>
                                                        </h6>
                                                        <p class="text-muted mb-2">
                                                            {{ Str::limit($result['content'], 120) }}
                                                        </p>
                                                        <div class="small text-muted">
                                                            <span class="badge bg-{{ $result['type'] == 'news' ? 'primary' : ($result['type'] == 'announcement' ? 'warning' : 'success') }} me-2">
                                                                {{ ucfirst($result['type']) }}
                                                            </span>
                                                            <i class="fas fa-folder me-1"></i> {{ $result['category'] }}
                                                            <span class="mx-2">•</span>
                                                            <i class="fas fa-calendar me-1"></i> {{ $result['date']->format('d M Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-search text-muted mb-3" style="font-size: 4rem;"></i>
                                <h4 class="text-muted">Tidak ada hasil ditemukan</h4>
                                <p class="text-muted">
                                    Coba gunakan kata kunci yang berbeda atau ubah filter pencarian Anda.
                                </p>
                                <a href="{{ route('search.advanced') }}" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Coba Pencarian Baru
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Search Guide -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-lightbulb text-warning mb-3" style="font-size: 4rem;"></i>
                        <h4>Tips Pencarian</h4>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <ul class="list-unstyled text-start">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Gunakan kata kunci yang spesifik</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Pilih tipe konten untuk hasil yang lebih tepat</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Gunakan filter kategori dan tanggal</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Coba kombinasi kata kunci yang berbeda</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search_query');
    const suggestionsDiv = document.getElementById('search-suggestions');
    const typeSelect = document.getElementById('content_type');
    const categorySelect = document.getElementById('category');
    
    // Auto-suggestions
    let suggestionTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(suggestionTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            suggestionsDiv.style.display = 'none';
            return;
        }
        
        suggestionTimeout = setTimeout(() => {
            fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        suggestionsDiv.innerHTML = data.map(item => 
                            `<div class="p-2 border-bottom suggestion-item" style="cursor: pointer;">
                                <div class="d-flex justify-content-between">
                                    <span>${item.title}</span>
                                    <small class="text-muted">${item.type}</small>
                                </div>
                            </div>`
                        ).join('');
                        suggestionsDiv.style.display = 'block';
                        
                        // Add click handlers
                        suggestionsDiv.querySelectorAll('.suggestion-item').forEach((item, index) => {
                            item.addEventListener('click', function() {
                                window.location.href = data[index].url;
                            });
                        });
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                })
                .catch(() => {
                    suggestionsDiv.style.display = 'none';
                });
        }, 300);
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
    
    // Category filter based on content type
    typeSelect.addEventListener('change', function() {
        const type = this.value;
        const newsCategories = document.getElementById('news-categories');
        const galleryCategories = document.getElementById('gallery-categories');
        const faculties = document.getElementById('faculties');
        
        // Hide all optgroups
        newsCategories.style.display = 'none';
        galleryCategories.style.display = 'none';
        faculties.style.display = 'none';
        
        // Show relevant optgroups
        switch(type) {
            case 'news':
                newsCategories.style.display = 'block';
                break;
            case 'galleries':
                galleryCategories.style.display = 'block';
                break;
            case 'students':
            case 'lecturers':
                faculties.style.display = 'block';
                break;
            case 'all':
                newsCategories.style.display = 'block';
                galleryCategories.style.display = 'block';
                faculties.style.display = 'block';
                break;
        }
        
        // Reset category selection
        categorySelect.value = '';
    });
    
    // Form validation
    document.getElementById('advancedSearchForm').addEventListener('submit', function(e) {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            e.preventDefault();
            alert('Kata kunci pencarian minimal 2 karakter');
            searchInput.focus();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.search-result-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
}

.search-results {
    max-height: 600px;
    overflow-y: auto;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.card-header {
    border-bottom: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush
