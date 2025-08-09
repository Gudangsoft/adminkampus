@extends('layouts.admin')

@section('title', 'Detail Halaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Halaman</h1>
        <div>
            <a href="{{ url('/' . $page->slug) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-external-link-alt fa-sm text-white-50"></i> Lihat di Website
            </a>
            <a href="{{ route('admin.pages.edit', $page) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.pages.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $page->title }}</h6>
                    <div class="dropdown no-arrow">
                        <span class="badge badge-{{ $page->status === 'published' ? 'success' : 'warning' }}">
                            {{ ucfirst($page->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($page->featured_image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $page->featured_image) }}" 
                                 alt="{{ $page->title }}" class="img-fluid rounded shadow-sm" 
                                 style="max-width: 100%; height: auto;">
                        </div>
                    @endif
                    
                    <div class="content-preview">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Page Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Halaman</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Status:</strong></div>
                        <div class="col-sm-8">
                            <span class="badge badge-{{ $page->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($page->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Slug:</strong></div>
                        <div class="col-sm-8">{{ $page->slug }}</div>
                    </div>
                    
                    @if($page->template)
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Template:</strong></div>
                            <div class="col-sm-8">{{ ucwords(str_replace('-', ' ', $page->template)) }}</div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Menu:</strong></div>
                        <div class="col-sm-8">
                            @if($page->show_in_menu)
                                <span class="badge badge-info">Tampil di Menu</span>
                                @if($page->menu_order)
                                    <small class="text-muted">(Urutan: {{ $page->menu_order }})</small>
                                @endif
                            @else
                                <span class="badge badge-secondary">Tidak di Menu</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Dibuat:</strong></div>
                        <div class="col-sm-8">{{ $page->created_at->format('d M Y H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Update:</strong></div>
                        <div class="col-sm-8">{{ $page->updated_at->format('d M Y H:i') }}</div>
                    </div>
                    
                    @if($page->user)
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Penulis:</strong></div>
                            <div class="col-sm-8">{{ $page->user->name }}</div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>URL:</strong></div>
                        <div class="col-sm-8">
                            <a href="{{ url('/' . $page->slug) }}" target="_blank" class="text-primary">
                                {{ url('/' . $page->slug) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($page->meta_title || $page->meta_description || $page->meta_keywords)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi SEO</h6>
                    </div>
                    <div class="card-body">
                        @if($page->meta_title)
                            <div class="mb-3">
                                <strong>Meta Title:</strong>
                                <p class="text-muted">{{ $page->meta_title }}</p>
                            </div>
                        @endif
                        
                        @if($page->meta_description)
                            <div class="mb-3">
                                <strong>Meta Description:</strong>
                                <p class="text-muted">{{ $page->meta_description }}</p>
                            </div>
                        @endif
                        
                        @if($page->meta_keywords)
                            <div class="mb-3">
                                <strong>Meta Keywords:</strong>
                                <p class="text-muted">{{ $page->meta_keywords }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Halaman
                        </a>
                        
                        <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-external-link-alt"></i> Lihat di Website
                        </a>
                        
                        <button type="button" class="btn btn-info btn-sm" onclick="copyUrl()">
                            <i class="fas fa-copy"></i> Salin URL
                        </button>
                        
                        <hr>
                        
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Hapus Halaman
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-preview {
    line-height: 1.6;
}

.content-preview h1, 
.content-preview h2, 
.content-preview h3, 
.content-preview h4, 
.content-preview h5, 
.content-preview h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.content-preview p {
    margin-bottom: 1rem;
    text-align: justify;
}

.content-preview img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.content-preview blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.content-preview table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-collapse: collapse;
}

.content-preview table th,
.content-preview table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

.content-preview table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
}

.content-preview ul, 
.content-preview ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.content-preview li {
    margin-bottom: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
function copyUrl() {
    const url = '{{ url('/' . $page->slug) }}';
    navigator.clipboard.writeText(url).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        button.classList.remove('btn-info');
        button.classList.add('btn-success');
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-info');
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin URL');
    });
}
</script>
@endpush
