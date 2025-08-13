@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Galeri</li>
                    </ol>
                </div>
                <h4 class="page-title">Kelola Galeri</h4>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-primary rounded">
                                <i class="fas fa-images avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ $totalGalleries }}</h5>
                            <p class="text-muted mb-0">Total Item</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-success rounded">
                                <i class="fas fa-image avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ $totalImages }}</h5>
                            <p class="text-muted mb-0">Gambar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-info rounded">
                                <i class="fas fa-video avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ $totalVideos }}</h5>
                            <p class="text-muted mb-0">Video</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-warning rounded">
                                <i class="fas fa-star avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ $featuredCount }}</h5>
                            <p class="text-muted mb-0">Unggulan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('admin.galleries.index') }}" class="d-flex gap-3">
                                <div class="flex-grow-1">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari judul, deskripsi, atau fotografer..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div>
                                    <select name="category" class="form-select" style="min-width: 150px;">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <select name="type" class="form-select">
                                        <option value="">Semua Jenis</option>
                                        <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                    </select>
                                </div>
                                <div>
                                    <select name="featured" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Unggulan</option>
                                        <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Biasa</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('admin.galleries.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Item
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($galleries->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada item galeri</h5>
                            <p class="text-muted">Silakan tambah item galeri pertama Anda</p>
                            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Item Galeri
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach($galleries as $gallery)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card gallery-item h-100">
                                        <div class="position-relative">
                                            <!-- Thumbnail -->
                                            <img src="{{ $gallery->thumbnail_url }}" 
                                                 alt="{{ $gallery->title }}" 
                                                 class="card-img-top" 
                                                 style="height: 200px; object-fit: cover;">
                                            
                                            <!-- Type Badge -->
                                            <span class="badge bg-{{ $gallery->type === 'image' ? 'success' : 'info' }} position-absolute top-0 start-0 m-2">
                                                <i class="fas fa-{{ $gallery->type === 'image' ? 'image' : 'video' }}"></i>
                                                {{ $gallery->type === 'image' ? 'Gambar' : 'Video' }}
                                            </span>
                                            
                                            <!-- Featured Badge -->
                                            @if($gallery->is_featured)
                                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                                    <i class="fas fa-star"></i> Unggulan
                                                </span>
                                            @endif
                                            
                                            <!-- Video Play Button -->
                                            @if($gallery->type === 'video')
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <div class="bg-dark bg-opacity-75 rounded-circle p-3">
                                                        <i class="fas fa-play text-white fs-4"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="card-body">
                                            <h6 class="card-title mb-2">{{ Str::limit($gallery->title, 50) }}</h6>
                                            <p class="card-text text-muted small">{{ $gallery->category ? $gallery->category->name : 'Tidak ada kategori' }}</p>
                                            
                                            @if($gallery->description)
                                                <p class="card-text small">{{ Str::limit(strip_tags($gallery->description), 80) }}</p>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                                <span>
                                                    <i class="fas fa-eye"></i> {{ number_format($gallery->views) }}
                                                </span>
                                                <span>{{ $gallery->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer bg-transparent">
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('admin.galleries.show', $gallery) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                                                   class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.galleries.toggle-featured', $gallery) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-outline-warning btn-sm"
                                                            title="{{ $gallery->is_featured ? 'Hapus dari unggulan' : 'Jadikan unggulan' }}">
                                                        <i class="fas fa-star{{ $gallery->is_featured ? '' : '-o' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <p class="text-muted mb-0">
                                            Menampilkan {{ $galleries->firstItem() ?? 0 }} - {{ $galleries->lastItem() ?? 0 }} 
                                            dari {{ $galleries->total() }} item
                                        </p>
                                    </div>
                                    <div>
                                        {{ $galleries->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-item {
    transition: transform 0.2s;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-title {
    font-size: 1.125rem;
}

/* Pagination styling */
.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #5a67d8;
    border: 1px solid #e2e8f0;
    padding: 0.5rem 0.75rem;
}

.page-link:hover {
    color: #4c51bf;
    background-color: #f7fafc;
    border-color: #cbd5e0;
}

.page-item.active .page-link {
    background-color: #5a67d8;
    border-color: #5a67d8;
    color: white;
}

.page-item.disabled .page-link {
    color: #a0aec0;
    background-color: #f7fafc;
    border-color: #e2e8f0;
}
</style>
@endsection
