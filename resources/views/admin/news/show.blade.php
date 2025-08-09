@extends('layouts.admin')

@section('title', 'Detail Berita')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Detail Berita
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('news.show', $news->slug) }}" class="btn btn-info btn-sm" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Lihat di Frontend
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <!-- Featured Image -->
                            @if($news->featured_image)
                            <div class="mb-4">
                                <img src="{{ Storage::url($news->featured_image) }}" 
                                     alt="{{ $news->title }}" 
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 400px; width: 100%; object-fit: cover;">
                            </div>
                            @endif

                            <!-- Title -->
                            <h2 class="mb-3">{{ $news->title }}</h2>

                            <!-- Excerpt -->
                            <div class="alert alert-light border-start border-primary border-4 mb-4">
                                <p class="mb-0 fw-semibold">{{ $news->excerpt }}</p>
                            </div>

                            <!-- Content -->
                            <div class="content-wrapper">
                                {!! $news->content !!}
                            </div>
                        </div>

                        <!-- Sidebar Info -->
                        <div class="col-lg-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle"></i> Informasi Berita
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status:</label>
                                        <div>
                                            @if($news->status === 'published')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Published
                                                </span>
                                            @elseif($news->status === 'draft')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-edit"></i> Draft
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-archive"></i> Archived
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kategori:</label>
                                        <div>
                                            <span class="badge bg-primary">{{ $news->category->name }}</span>
                                        </div>
                                    </div>

                                    <!-- Author -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Penulis:</label>
                                        <div>{{ $news->user->name }}</div>
                                    </div>

                                    <!-- Featured -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Featured:</label>
                                        <div>
                                            @if($news->is_featured)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-star"></i> Ya
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">Tidak</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Published Date -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Publish:</label>
                                        <div>
                                            @if($news->published_at)
                                                {{ $news->published_at->format('d M Y H:i') }}
                                            @else
                                                <span class="text-muted">Belum dipublish</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Views -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Views:</label>
                                        <div>
                                            <i class="fas fa-eye text-muted"></i> 
                                            {{ number_format($news->views) }} kali dilihat
                                        </div>
                                    </div>

                                    <!-- Created/Updated -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dibuat:</label>
                                        <div class="small text-muted">{{ $news->created_at->format('d M Y H:i') }}</div>
                                    </div>

                                    @if($news->updated_at != $news->created_at)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diupdate:</label>
                                        <div class="small text-muted">{{ $news->updated_at->format('d M Y H:i') }}</div>
                                    </div>
                                    @endif

                                    <!-- Slug -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Slug:</label>
                                        <div class="small text-muted">{{ $news->slug }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-cogs"></i> Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Berita
                                        </a>
                                        
                                        @if($news->status === 'draft')
                                        <form action="{{ route('admin.news.update', $news) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="title" value="{{ $news->title }}">
                                            <input type="hidden" name="excerpt" value="{{ $news->excerpt }}">
                                            <input type="hidden" name="content" value="{{ $news->content }}">
                                            <input type="hidden" name="category_id" value="{{ $news->category_id }}">
                                            <input type="hidden" name="status" value="published">
                                            <input type="hidden" name="is_featured" value="{{ $news->is_featured ? '1' : '0' }}">
                                            <button type="submit" class="btn btn-success w-100" 
                                                    onclick="return confirm('Publikasikan berita ini?')">
                                                <i class="fas fa-upload"></i> Publikasikan
                                            </button>
                                        </form>
                                        @endif

                                        <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100" 
                                                    onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                                <i class="fas fa-trash"></i> Hapus Berita
                                            </button>
                                        </form>
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
.content-wrapper {
    line-height: 1.6;
}

.content-wrapper img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 1rem 0;
}

.content-wrapper h1,
.content-wrapper h2,
.content-wrapper h3,
.content-wrapper h4,
.content-wrapper h5,
.content-wrapper h6 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.content-wrapper p {
    margin-bottom: 1rem;
    text-align: justify;
}

.content-wrapper ul,
.content-wrapper ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.content-wrapper blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
}
</style>
@endsection
