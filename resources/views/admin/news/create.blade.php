@extends('layouts.admin')

@section('title', 'Tambah Berita')

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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Berita Baru</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug') }}">
                                    <div class="form-text">Biarkan kosong untuk generate otomatis dari judul</div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Ringkasan</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                                    <div class="form-text">Ringkasan singkat untuk ditampilkan di halaman utama</div>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Konten Berita <span class="text-danger">*</span></label>
                                    
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
                                             style="min-height: 300px;">{{ old('content') }}</div>
                                    </div>
                                    
                                    <!-- Hidden textarea for form submission -->
                                    <textarea name="content" 
                                              id="content" 
                                              class="d-none @error('content') is-invalid @enderror" 
                                              required>{{ old('content') }}</textarea>
                                    
                                    @error('content')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="Contoh: pendidikan, teknologi, kampus" />
                                    <div class="form-text">Isi tag secara manual, pisahkan dengan koma. Boleh dikosongkan.</div>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Gambar Utama & Thumbnail</label>
                                    
                                    <!-- Image Upload Area -->
                                    <div class="image-upload-area mb-3">
                                        <input type="file" 
                                               class="form-control @error('featured_image') is-invalid @enderror" 
                                               id="featured_image" 
                                               name="featured_image" 
                                               accept="image/*"
                                               onchange="handleImageUpload(this)">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Gambar akan di-resize otomatis untuk thumbnail.</div>
                                        @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Image Preview & Crop Area -->
                                    <div id="image-preview-container" class="image-preview-container d-none">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label">Crop Gambar:</label>
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
                                                <label class="form-label">Preview Thumbnail:</label>
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

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" 
                                               name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Berita Unggulan
                                        </label>
                                    </div>
                                    <div class="form-text">Tampilkan di slider utama</div>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                    <div class="form-text">Untuk SEO (maksimal 160 karakter)</div>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <div>
                                        <button type="submit" name="action" value="save" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                                            <i class="fas fa-save"></i> Simpan & Lanjut Edit
                                        </button>
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
@endsection

@push('scripts')
<!-- Cropper.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
// Rich Text Editor Functions
let editor = document.getElementById('editor-content');
let textarea = document.getElementById('content');

// Update textarea when editor content changes
editor.addEventListener('input', function() {
    textarea.value = editor.innerHTML;
});

// Execute formatting commands
function execCmd(command, value = null) {
    document.execCommand(command, false, value);
    editor.focus();
    textarea.value = editor.innerHTML;
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

// Update hidden textarea before form submission
document.querySelector('form').addEventListener('submit', function() {
    textarea.value = editor.innerHTML;
});

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
});

// Image Cropper Variables
let cropper = null;
let originalFile = null;

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
        if (cropper) {
            cropper.destroy();
        }
        
        // Initialize new cropper
        cropper = new Cropper(imagePreview, {
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
    if (!cropper) return;
    
    const canvas = cropper.getCroppedCanvas({
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
    if (cropper) {
        cropper.reset();
    }
    
    // Clear thumbnail
    const thumbnailCanvas = document.getElementById('thumbnail-preview');
    const thumbnailCtx = thumbnailCanvas.getContext('2d');
    thumbnailCtx.clearRect(0, 0, thumbnailCanvas.width, thumbnailCanvas.height);
    
    // Clear hidden inputs
    document.getElementById('cropped_image').value = '';
    document.getElementById('thumbnail_data').value = '';
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
</script>
@endpush
