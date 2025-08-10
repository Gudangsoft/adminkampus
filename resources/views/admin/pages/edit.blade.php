@extends('layouts.admin')

@section('title', 'Edit Halaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Halaman: {{ $page->title }}</h1>
        <div>
            <a href="{{ route('admin.pages.show', $page) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-eye fa-sm text-white-50"></i> Lihat
            </a>
            <a href="{{ route('admin.pages.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Form Start -->
    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data" id="pageForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Halaman</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug URL</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $page->slug) }}">
                            <small class="form-text text-muted">Kosongkan untuk generate otomatis dari judul</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="featured_image">Gambar Unggulan</label>
                            @if($page->featured_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $page->featured_image) }}" 
                                         alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Halaman
                                </button>
                                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Settings Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pengaturan</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Terbit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="template">Template</label>
                            <select class="form-control" id="template" name="template">
                                <option value="">Default</option>
                                <option value="full-width" {{ old('template', $page->template) === 'full-width' ? 'selected' : '' }}>Full Width</option>
                                <option value="sidebar" {{ old('template', $page->template) === 'sidebar' ? 'selected' : '' }}>Dengan Sidebar</option>
                            </select>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" 
                                   value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_menu">
                                Tampilkan di Menu
                            </label>
                        </div>

                        <div class="form-group mt-3">
                            <label for="menu_order">Urutan Menu</label>
                            <input type="number" class="form-control" id="menu_order" name="menu_order" 
                                   value="{{ old('menu_order', $page->menu_order) }}" min="0">
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">SEO</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                   value="{{ old('meta_title', $page->meta_data['title'] ?? '') }}" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" 
                                      rows="3" maxlength="500">{{ old('meta_description', $page->meta_data['description'] ?? '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                   value="{{ old('meta_keywords', $page->meta_data['keywords'] ?? '') }}">
                            <small class="form-text text-muted">Pisahkan dengan koma</small>
                        </div>
                    </div>
                </div>

                <!-- Page Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Halaman</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Dibuat:</strong><br>{{ $page->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Terakhir Update:</strong><br>{{ $page->updated_at->format('d M Y H:i') }}</p>
                        @if($page->user)
                            <p><strong>Penulis:</strong><br>{{ $page->user->name }}</p>
                        @endif
                        <p><strong>URL:</strong><br>
                            <a href="{{ url('/' . $page->slug) }}" target="_blank" class="text-primary">
                                {{ url('/' . $page->slug) }} <i class="fas fa-external-link-alt"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Form End -->
</div>
@endsection

@push('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
// Auto-generate slug from title (only if slug is empty or matches current title)
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slugField = document.getElementById('slug');
    const originalSlug = '{{ $page->slug }}';
    
    // Only auto-generate if slug field is empty or unchanged from original
    if (!slugField.value || slugField.value === originalSlug) {
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugField.value = slug;
    }
});

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#content'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'link', '|',
            'bulletedList', 'numberedList', '|',
            'outdent', 'indent', '|',
            'blockQuote', 'insertTable', '|',
            'undo', 'redo'
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
        }
    })
    .catch(error => {
        console.error(error);
    });

// Form validation
document.getElementById('pageForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    
    if (!title) {
        e.preventDefault();
        alert('Judul halaman wajib diisi!');
        document.getElementById('title').focus();
        return false;
    }
    
    if (!content) {
        e.preventDefault();
        alert('Konten halaman wajib diisi!');
        document.getElementById('content').focus();
        return false;
    }
    
    // Show loading indicator
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds (fallback)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});
</script>
@endpush
