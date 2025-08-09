@extends('layouts.admin')

@section('title', 'Edit Berita')

@push('styles')
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<style>
.image-preview-container {
    max-width: 100%;
    max-height: 400px;
    overflow: hidden;
    border: 2px dashed #ddd;
    border-radius: 8px;
    background-color: #f8f9fa;
}

.image-preview {
    max-width: 100%;
    max-height: 400px;
    display: block;
}

.crop-container {
    max-height: 400px;
    margin: 15px 0;
}

.thumbnail-preview {
    max-width: 200px;
    max-height: 150px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.editor-toolbar {
    border: 1px solid #ddd;
    border-bottom: none;
    background: #f8f9fa;
    padding: 8px;
    border-radius: 4px 4px 0 0;
}

.editor-toolbar button {
    margin: 2px;
    padding: 5px 8px;
    border: 1px solid #ccc;
    background: white;
    border-radius: 3px;
    cursor: pointer;
}

.editor-toolbar button:hover {
    background: #e9ecef;
}

.editor-toolbar button.active {
    background: #007bff;
    color: white;
}

.editor-content {
    border: 1px solid #ddd;
    border-top: none;
    min-height: 300px;
    padding: 10px;
    border-radius: 0 0 4px 4px;
    background: white;
}

.editor-content:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Berita
                    </h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.news.show', $news) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Main Content -->
                            <div class="col-lg-8">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $news->title) }}" 
                                           required
                                           placeholder="Masukkan judul berita">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Excerpt -->
                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Ringkasan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" 
                                              name="excerpt" 
                                              rows="3" 
                                              required
                                              placeholder="Masukkan ringkasan berita">{{ old('excerpt', $news->excerpt) }}</textarea>
                                    <div class="form-text">Ringkasan akan ditampilkan di halaman daftar berita</div>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label for="content" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                                    
                                    <!-- Custom Rich Text Editor -->
                                    <div class="editor-container">
                                        <div class="editor-toolbar">
                                            <button type="button" onclick="execCmd('bold')" title="Bold">
                                                <i class="fas fa-bold"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('italic')" title="Italic">
                                                <i class="fas fa-italic"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('underline')" title="Underline">
                                                <i class="fas fa-underline"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('strikeThrough')" title="Strike">
                                                <i class="fas fa-strikethrough"></i>
                                            </button>
                                            |
                                            <button type="button" onclick="execCmd('justifyLeft')" title="Align Left">
                                                <i class="fas fa-align-left"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('justifyCenter')" title="Align Center">
                                                <i class="fas fa-align-center"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('justifyRight')" title="Align Right">
                                                <i class="fas fa-align-right"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('justifyFull')" title="Justify">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            |
                                            <button type="button" onclick="execCmd('insertUnorderedList')" title="Bullet List">
                                                <i class="fas fa-list-ul"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('insertOrderedList')" title="Number List">
                                                <i class="fas fa-list-ol"></i>
                                            </button>
                                            |
                                            <button type="button" onclick="insertLink()" title="Insert Link">
                                                <i class="fas fa-link"></i>
                                            </button>
                                            <button type="button" onclick="execCmd('unlink')" title="Remove Link">
                                                <i class="fas fa-unlink"></i>
                                            </button>
                                            |
                                            <button type="button" onclick="insertImage()" title="Insert Image">
                                                <i class="fas fa-image"></i>
                                            </button>
                                            |
                                            <select onchange="execCmd('formatBlock', this.value); this.selectedIndex=0;" class="form-select d-inline-block" style="width: auto;">
                                                <option value="">Format</option>
                                                <option value="h1">Heading 1</option>
                                                <option value="h2">Heading 2</option>
                                                <option value="h3">Heading 3</option>
                                                <option value="h4">Heading 4</option>
                                                <option value="p">Paragraph</option>
                                                <option value="blockquote">Quote</option>
                                            </select>
                                            |
                                            <button type="button" onclick="execCmd('removeFormat')" title="Clear Format">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        </div>
                                        <div class="editor-content" 
                                             contenteditable="true" 
                                             id="editor-content"
                                             data-placeholder="Tulis konten berita di sini..."
                                             style="min-height: 300px;">{!! old('content', $news->content) !!}</div>
                                    </div>
                                    
                                    <!-- Hidden textarea for form submission -->
                                    <textarea name="content" 
                                              id="content" 
                                              class="d-none @error('content') is-invalid @enderror" 
                                              required>{!! old('content', $news->content) !!}</textarea>
                                    
                                    @error('content')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Featured Image -->
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Gambar Utama & Thumbnail</label>
                                    
                                    @if($news->featured_image)
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Saat Ini:</label>
                                        <div class="d-flex gap-3">
                                            <div>
                                                <img src="{{ Storage::url($news->featured_image) }}" 
                                                     alt="Current image" 
                                                     class="img-thumbnail"
                                                     style="max-height: 200px;">
                                                <div class="small text-muted mt-1">Gambar Utama</div>
                                            </div>
                                            <div>
                                                @if(Storage::exists('public/news/thumbnails/' . basename($news->featured_image)))
                                                <img src="{{ Storage::url('news/thumbnails/' . basename($news->featured_image)) }}" 
                                                     alt="Current thumbnail" 
                                                     class="img-thumbnail"
                                                     style="max-height: 150px;">
                                                <div class="small text-muted mt-1">Thumbnail Saat Ini</div>
                                                @else
                                                <div class="border p-3 text-center text-muted" style="width: 200px; height: 150px; display: flex; align-items: center; justify-content: center;">
                                                    <div>
                                                        <i class="fas fa-image fa-2x mb-2"></i><br>
                                                        Thumbnail belum dibuat
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Image Upload Area -->
                                    <div class="image-upload-area mb-3">
                                        <input type="file" 
                                               class="form-control @error('featured_image') is-invalid @enderror" 
                                               id="featured_image" 
                                               name="featured_image" 
                                               accept="image/*"
                                               onchange="handleImageUpload(this)">
                                        <div class="form-text">
                                            Format: JPG, PNG, GIF. Maksimal 2MB. 
                                            @if($news->featured_image)
                                                Biarkan kosong jika tidak ingin mengubah gambar.
                                            @endif
                                        </div>
                                        @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Image Preview & Crop Area -->
                                    <div id="image-preview-container" class="image-preview-container d-none">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label">Crop Gambar Baru:</label>
                                                <div class="crop-container">
                                                    <img id="image-preview" class="image-preview" />
                                                </div>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="cropImage()">
                                                        <i class="fas fa-crop"></i> Crop & Generate Thumbnail
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="resetCrop()">
                                                        <i class="fas fa-undo"></i> Reset
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Preview Thumbnail Baru:</label>
                                                <div class="thumbnail-preview-container">
                                                    <canvas id="thumbnail-preview" class="thumbnail-preview border" width="200" height="150"></canvas>
                                                </div>
                                                <div class="mt-2 small text-muted">
                                                    <strong>Ukuran:</strong> 200x150px<br>
                                                    <strong>Aspek Rasio:</strong> 4:3
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs for cropped image data -->
                                    <input type="hidden" id="cropped_image" name="cropped_image">
                                    <input type="hidden" id="thumbnail_data" name="thumbnail_data">
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-lg-4">
                                <!-- Publish Settings -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-cog"></i> Pengaturan Publikasi
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>
                                                    Draft
                                                </option>
                                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>
                                                    Published
                                                </option>
                                                <option value="archived" {{ old('status', $news->status) === 'archived' ? 'selected' : '' }}>
                                                    Archived
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Category -->
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    id="category_id" 
                                                    name="category_id" 
                                                    required>
                                                <option value="">Pilih Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Published Date -->
                                        <div class="mb-3">
                                            <label for="published_at" class="form-label">Tanggal Publikasi</label>
                                            <input type="datetime-local" 
                                                   class="form-control @error('published_at') is-invalid @enderror" 
                                                   id="published_at" 
                                                   name="published_at"
                                                   value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
                                            <div class="form-text">Kosongkan untuk menggunakan waktu sekarang saat dipublikasi</div>
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Featured -->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="is_featured" 
                                                       name="is_featured"
                                                       value="1"
                                                       {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    <i class="fas fa-star text-warning"></i> Berita Unggulan
                                                </label>
                                            </div>
                                            <div class="form-text">Berita unggulan akan ditampilkan di halaman utama</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-info-circle"></i> Informasi
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Penulis:</strong> {{ $news->user->name }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Dibuat:</strong> {{ $news->created_at->format('d M Y H:i') }}
                                        </div>
                                        @if($news->updated_at != $news->created_at)
                                        <div class="mb-2">
                                            <strong>Terakhir Diupdate:</strong> {{ $news->updated_at->format('d M Y H:i') }}
                                        </div>
                                        @endif
                                        <div class="mb-2">
                                            <strong>Views:</strong> {{ number_format($news->views) }}
                                        </div>
                                        <div class="mb-0">
                                            <strong>Slug:</strong> 
                                            <code class="small">{{ $news->slug }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" name="action" value="save" class="btn btn-primary me-2">
                                            <i class="fas fa-save"></i> Update Berita
                                        </button>
                                        @if($news->status !== 'published')
                                        <button type="submit" name="action" value="publish" class="btn btn-success">
                                            <i class="fas fa-upload"></i> Update & Publikasikan
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Cropper.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rich Text Editor Functions
    let editor = document.getElementById('editor-content');
    let textarea = document.getElementById('content');

    // Update textarea when editor content changes
    editor.addEventListener('input', function() {
        textarea.value = editor.innerHTML;
    });

    // Update hidden textarea before form submission
    document.querySelector('form').addEventListener('submit', function() {
        textarea.value = editor.innerHTML;
    });

    // Image Cropper Variables
    let cropper = null;
    let originalFile = null;
    
    // Auto-update published_at when status changes to published
    const statusSelect = document.getElementById('status');
    const publishedAtInput = document.getElementById('published_at');
    
    statusSelect.addEventListener('change', function() {
        if (this.value === 'published' && !publishedAtInput.value) {
            const now = new Date();
            const localDateTime = now.getFullYear() + '-' + 
                                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(now.getDate()).padStart(2, '0') + 'T' + 
                                String(now.getHours()).padStart(2, '0') + ':' + 
                                String(now.getMinutes()).padStart(2, '0');
            publishedAtInput.value = localDateTime;
        }
    });

    // Handle form submission based on action
    const form = document.querySelector('form');
    const publishBtn = document.querySelector('button[value="publish"]');
    
    if (publishBtn) {
        publishBtn.addEventListener('click', function() {
            statusSelect.value = 'published';
            if (!publishedAtInput.value) {
                const now = new Date();
                const localDateTime = now.getFullYear() + '-' + 
                                    String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                    String(now.getDate()).padStart(2, '0') + 'T' + 
                                    String(now.getHours()).padStart(2, '0') + ':' + 
                                    String(now.getMinutes()).padStart(2, '0');
                publishedAtInput.value = localDateTime;
            }
        });
    }

    // Add placeholder text for empty editor
    editor.addEventListener('focus', function() {
        if (this.innerHTML === '' || this.innerHTML === '<br>') {
            this.innerHTML = '';
        }
    });

    editor.addEventListener('blur', function() {
        if (this.innerHTML === '') {
            this.innerHTML = '<br>';
        }
    });

    // Initialize editor content
    if (editor.innerHTML.trim() === '') {
        editor.innerHTML = '<br>';
    }
});

// Execute formatting commands (global functions for toolbar)
function execCmd(command, value = null) {
    document.execCommand(command, false, value);
    document.getElementById('editor-content').focus();
    document.getElementById('content').value = document.getElementById('editor-content').innerHTML;
}

// Insert link
function insertLink() {
    const url = prompt('Masukkan URL:');
    if (url) {
        execCmd('createLink', url);
    }
}

// Insert image
function insertImage() {
    const url = prompt('Masukkan URL gambar:');
    if (url) {
        execCmd('insertImage', url);
    }
}

// Handle image upload
function handleImageUpload(input) {
    const file = input.files[0];
    if (!file) return;

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar! Maksimal 2MB.');
        input.value = '';
        return;
    }

    // Validate file type
    if (!file.type.match('image.*')) {
        alert('File harus berupa gambar!');
        input.value = '';
        return;
    }

    originalFile = file;
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const imagePreview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');
        
        imagePreview.src = e.target.result;
        container.classList.remove('d-none');
        
        // Destroy existing cropper
        if (window.cropper) {
            window.cropper.destroy();
        }
        
        // Initialize new cropper
        window.cropper = new Cropper(imagePreview, {
            aspectRatio: 4/3, // 4:3 aspect ratio for thumbnail
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            responsive: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    };
    
    reader.readAsDataURL(file);
}

// Crop image and generate thumbnail
function cropImage() {
    if (!window.cropper) return;
    
    const canvas = window.cropper.getCroppedCanvas({
        width: 800,
        height: 600,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });
    
    // Generate thumbnail
    const thumbnailCanvas = document.getElementById('thumbnail-preview');
    const thumbnailCtx = thumbnailCanvas.getContext('2d');
    
    // Clear thumbnail canvas
    thumbnailCtx.clearRect(0, 0, thumbnailCanvas.width, thumbnailCanvas.height);
    
    // Draw cropped image to thumbnail canvas
    thumbnailCtx.drawImage(canvas, 0, 0, 200, 150);
    
    // Convert to base64 and store in hidden inputs
    const croppedImageData = canvas.toDataURL('image/jpeg', 0.9);
    const thumbnailData = thumbnailCanvas.toDataURL('image/jpeg', 0.8);
    
    document.getElementById('cropped_image').value = croppedImageData;
    document.getElementById('thumbnail_data').value = thumbnailData;
    
    alert('Gambar berhasil di-crop! Thumbnail telah dibuat.');
}

// Reset crop
function resetCrop() {
    if (window.cropper) {
        window.cropper.reset();
    }
    
    // Clear thumbnail
    const thumbnailCanvas = document.getElementById('thumbnail-preview');
    const thumbnailCtx = thumbnailCanvas.getContext('2d');
    thumbnailCtx.clearRect(0, 0, thumbnailCanvas.width, thumbnailCanvas.height);
    
    // Clear hidden inputs
    document.getElementById('cropped_image').value = '';
    document.getElementById('thumbnail_data').value = '';
}
</script>
@endpush
@endsection
