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

    <!-- Alert untuk testing -->
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> Template create page berhasil dimuat!
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Halaman</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
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
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="form-group mb-3">
                            <label for="content">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <!-- Status -->
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Template -->
                        <div class="form-group mb-3">
                            <label for="template">Template</label>
                            <select class="form-control @error('template') is-invalid @enderror" id="template" name="template">
                                <option value="">Default</option>
                                <option value="fullwidth" {{ old('template') == 'fullwidth' ? 'selected' : '' }}>Full Width</option>
                                <option value="sidebar" {{ old('template') == 'sidebar' ? 'selected' : '' }}>With Sidebar</option>
                            </select>
                            @error('template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div class="form-group mb-3">
                            <label for="featured_image">Featured Image</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Show in Menu -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="show_in_menu" 
                                   name="show_in_menu" value="1" {{ old('show_in_menu') ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_menu">
                                Tampilkan di Menu
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SEO Section -->
                <hr>
                <h5>SEO (Optional)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                            <small class="form-text text-muted">Pisahkan dengan koma</small>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="meta_description">Meta Description</label>
                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                              id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Halaman
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .trim('-'); // Trim hyphens from start and end
    
    document.getElementById('slug').value = slug;
});

// Auto-fill meta title from title if empty
document.getElementById('title').addEventListener('input', function() {
    const metaTitle = document.getElementById('meta_title');
    if (!metaTitle.value) {
        metaTitle.value = this.value;
    }
});

console.log('Page create scripts loaded successfully!');
</script>
@endpush
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug URL</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}">
                            <small class="form-text text-muted">Kosongkan untuk generate otomatis dari judul</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="featured_image">Gambar Unggulan</label>
                            <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror" 
                                   id="featured_image" name="featured_image" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Halaman
                                </button>
                                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Batal
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
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Terbit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="template">Template</label>
                            <select class="form-control" id="template" name="template">
                                <option value="">Default</option>
                                <option value="full-width" {{ old('template') === 'full-width' ? 'selected' : '' }}>Full Width</option>
                                <option value="sidebar" {{ old('template') === 'sidebar' ? 'selected' : '' }}>Dengan Sidebar</option>
                            </select>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" 
                                   value="1" {{ old('show_in_menu') ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_menu">
                                Tampilkan di Menu
                            </label>
                        </div>

                        <div class="form-group mt-3">
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
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                   value="{{ old('meta_title') }}" maxlength="255">
                        </div>

                        <div class="form-group">
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
    <!-- Form End -->
</div>
@endsection

@push('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slugField = document.getElementById('slug');
    
    // Only auto-generate if slug field is empty
    if (!slugField.value) {
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
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds (fallback)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});
</script>
@endpush 
                               value="1" {{ old('show_in_menu') ? 'checked' : '' }} form="pageForm">
                        <label class="form-check-label" for="show_in_menu">
                            Tampilkan di Menu
                        </label>
                    </div>

                    <div class="form-group mt-3">
                        <label for="menu_order">Urutan Menu</label>
                        <input type="number" class="form-control" id="menu_order" name="menu_order" 
                               value="{{ old('menu_order', 0) }}" min="0" form="pageForm">
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
                               value="{{ old('meta_title') }}" maxlength="255" form="pageForm">
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" 
                                  rows="3" maxlength="500" form="pageForm">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                               value="{{ old('meta_keywords') }}" form="pageForm">
                        <small class="form-text text-muted">Pisahkan dengan koma</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form to connect sidebar controls -->
<form id="pageForm" style="display: none;"></form>
@endsection

@push('scripts')
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug').value = slug;
});

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#content'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'blockQuote', 'insertTable', '|',
                'undo', 'redo'
            ]
        },
        language: 'id',
        image: {
            toolbar: [
                'imageTextAlternative',
                'imageStyle:full',
                'imageStyle:side'
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells'
            ]
        }
    })
    .catch(error => {
        console.error(error);
    });

// Connect form elements
document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.querySelector('form[action*="store"]');
    const sidebarInputs = document.querySelectorAll('#pageForm input, #pageForm select, #pageForm textarea');
    
    sidebarInputs.forEach(input => {
        const cloned = input.cloneNode(true);
        cloned.style.display = 'none';
        mainForm.appendChild(cloned);
        
        input.addEventListener('input', function() {
            cloned.value = this.value;
        });
        
        input.addEventListener('change', function() {
            cloned.value = this.value;
            if (this.type === 'checkbox') {
                cloned.checked = this.checked;
            }
        });
    });
});
</script>
@endpush
