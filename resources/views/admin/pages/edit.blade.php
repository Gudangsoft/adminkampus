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

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Halaman</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
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
                                <button type="submit" class="btn btn-primary">Update Halaman</button>
                                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
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
                        <select class="form-control" id="status" name="status" form="pageForm">
                            <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Terbit</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="template">Template</label>
                        <select class="form-control" id="template" name="template" form="pageForm">
                            <option value="">Default</option>
                            <option value="full-width" {{ old('template', $page->template) === 'full-width' ? 'selected' : '' }}>Full Width</option>
                            <option value="sidebar" {{ old('template', $page->template) === 'sidebar' ? 'selected' : '' }}>Dengan Sidebar</option>
                        </select>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" 
                               value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }} form="pageForm">
                        <label class="form-check-label" for="show_in_menu">
                            Tampilkan di Menu
                        </label>
                    </div>

                    <div class="form-group mt-3">
                        <label for="menu_order">Urutan Menu</label>
                        <input type="number" class="form-control" id="menu_order" name="menu_order" 
                               value="{{ old('menu_order', $page->menu_order) }}" min="0" form="pageForm">
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
                               value="{{ old('meta_title', $page->meta_title) }}" maxlength="255" form="pageForm">
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" 
                                  rows="3" maxlength="500" form="pageForm">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                               value="{{ old('meta_keywords', $page->meta_keywords) }}" form="pageForm">
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
                            {{ url('/' . $page->slug) }}
                        </a>
                    </p>
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
            .trim();
        slugField.value = slug;
    }
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
    const mainForm = document.querySelector('form[action*="update"]');
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
