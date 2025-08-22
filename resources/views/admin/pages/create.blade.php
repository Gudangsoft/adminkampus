@extends('layouts.admin')

@section('title', 'Tambah Halaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Halaman</h1>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Halaman</h6>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="form-group mb-3">
                            <label for="title">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="form-group mb-3">
                            <label for="slug">Slug URL</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}" data-auto="true">
                            <small class="form-text text-muted">Kosongkan untuk generate otomatis dari judul</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="form-group mb-3">
                            <label for="content">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" required>{{ old('content', 'Masukkan konten halaman di sini...') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div class="form-group mb-3">
                            <label for="featured_image">Gambar Unggulan</label>
                            <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Simpan Halaman
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Settings Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pengaturan</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Terbit</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="template">Template</label>
                            <select class="form-control" id="template" name="template">
                                <option value="">Default</option>
                                <option value="full-width" {{ old('template') === 'full-width' ? 'selected' : '' }}>Full Width</option>
                                <option value="sidebar" {{ old('template') === 'sidebar' ? 'selected' : '' }}>Dengan Sidebar</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" 
                                   value="1" {{ old('show_in_menu') ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_menu">
                                Tampilkan di Menu
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="menu_order">Urutan Menu</label>
                            <input type="number" class="form-control" id="menu_order" name="menu_order" 
                                   value="{{ old('menu_order', 0) }}" min="0">
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">SEO</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                   value="{{ old('meta_title') }}" maxlength="255">
                        </div>

                        <div class="form-group mb-3">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" 
                                      rows="3" maxlength="500">{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                   value="{{ old('meta_keywords') }}">
                            <small class="form-text text-muted">Pisahkan dengan koma</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slugField = document.getElementById('slug');
        
        // Only auto-generate if slug field is empty or still contains default value
        if (!slugField.value || slugField.value === '' || slugField.getAttribute('data-auto') === 'true') {
            const slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters except word chars, spaces, and hyphens
                .replace(/\s+/g, '-')     // Replace spaces with hyphens
                .replace(/-+/g, '-')     // Replace multiple hyphens with single hyphen
                .replace(/^-+|-+$/g, ''); // Remove leading and trailing hyphens
            slugField.value = slug;
            slugField.setAttribute('data-auto', 'true');
        }
    });
    
    // Manual edit detection for slug field
    document.getElementById('slug').addEventListener('input', function() {
        // Mark as manually edited
        this.removeAttribute('data-auto');
    });

    // Auto-fill meta title from title if empty
    document.getElementById('title').addEventListener('input', function() {
        const metaTitle = document.getElementById('meta_title');
        if (!metaTitle.value) {
            metaTitle.value = this.value;
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
        .then(editor => {
            window.editor = editor;
            console.log('CKEditor initialized successfully');
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
        });

    // Form validation on submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        
        // Update CKEditor content to textarea before validation
        if (window.editor) {
            document.getElementById('content').value = window.editor.getData();
        }
        
        const content = document.getElementById('content').value.trim();
        
        if (!title) {
            e.preventDefault();
            alert('Judul halaman wajib diisi!');
            document.getElementById('title').focus();
            return false;
        }
        
        if (!content || content === 'Masukkan konten halaman di sini...') {
            e.preventDefault();
            alert('Konten halaman wajib diisi!');
            if (window.editor) {
                window.editor.focus();
            } else {
                document.getElementById('content').focus();
            }
            return false;
        }
        
        // Show loading indicator
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Re-enable button after 5 seconds (fallback)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
});
</script>
@endpush
