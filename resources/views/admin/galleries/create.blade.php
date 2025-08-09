@extends('layouts.admin')

@section('title', 'Tambah Item Galeri')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Galeri</a></li>
                        <li class="breadcrumb-item active">Tambah Item</li>
                    </ol>
                </div>
                <h4 class="page-title">Tambah Item Galeri</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Form Tambah Item Galeri
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Informasi Dasar</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Deskripsi</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
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
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="type" class="form-label">Jenis <span class="text-danger">*</span></label>
                                                <select class="form-select @error('type') is-invalid @enderror" 
                                                        id="type" name="type" required onchange="toggleMediaFields()">
                                                    <option value="">Pilih Jenis</option>
                                                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                                                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video (YouTube)</option>
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media Upload -->
                                <div class="card" id="imageFields" style="display: none;">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Upload Gambar</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="image_file" class="form-label">File Gambar <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('image_file') is-invalid @enderror" 
                                                   id="image_file" name="image_file" accept="image/*" onchange="previewImage(this)">
                                            @error('image_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Ukuran maksimal 10MB. Format: JPG, PNG, GIF</small>
                                        </div>
                                        
                                        <div id="imagePreview" class="text-center" style="display: none;">
                                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 300px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Video URL -->
                                <div class="card" id="videoFields" style="display: none;">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Link Video YouTube</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="file_path" class="form-label">URL YouTube <span class="text-danger">*</span></label>
                                            <input type="url" class="form-control @error('file_path') is-invalid @enderror" 
                                                   id="file_path" name="file_path" value="{{ old('file_path') }}" 
                                                   placeholder="https://www.youtube.com/watch?v=..." onchange="previewYouTube(this.value)">
                                            @error('file_path')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Masukkan link video YouTube lengkap</small>
                                        </div>
                                        
                                        <div id="youtubePreview" class="text-center" style="display: none;">
                                            <div class="ratio ratio-16x9">
                                                <iframe id="previewFrame" src="" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Info -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Informasi Tambahan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="photographer" class="form-label">Fotografer/Videografer</label>
                                                <input type="text" class="form-control @error('photographer') is-invalid @enderror" 
                                                       id="photographer" name="photographer" value="{{ old('photographer') }}">
                                                @error('photographer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="taken_at" class="form-label">Tanggal Diambil</label>
                                                <input type="date" class="form-control @error('taken_at') is-invalid @enderror" 
                                                       id="taken_at" name="taken_at" value="{{ old('taken_at') }}">
                                                @error('taken_at')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alt_text" class="form-label">Alt Text</label>
                                            <input type="text" class="form-control @error('alt_text') is-invalid @enderror" 
                                                   id="alt_text" name="alt_text" value="{{ old('alt_text') }}" 
                                                   placeholder="Deskripsi singkat untuk accessibility">
                                            @error('alt_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Thumbnail Upload -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Thumbnail (Opsional)</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div id="thumbnailPreview" class="mx-auto mb-3" 
                                                 style="width: 200px; height: 150px; border: 2px dashed #ddd; 
                                                        border-radius: 8px; display: flex; align-items: center; 
                                                        justify-content: center; background-color: #f8f9fa;">
                                                <i class="fas fa-image" style="font-size: 48px; color: #adb5bd;"></i>
                                            </div>
                                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                                   id="thumbnail" name="thumbnail" accept="image/*" onchange="previewThumbnail(this)">
                                            @error('thumbnail')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Ukuran maksimal 2MB. Akan otomatis diambil dari YouTube untuk video</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_featured" 
                                                   name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                Jadikan Item Unggulan
                                            </label>
                                        </div>
                                        <small class="text-muted">Item unggulan akan ditampilkan di halaman utama</small>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Simpan Item
                                            </button>
                                            <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Kembali
                                            </a>
                                        </div>
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

<script>
function toggleMediaFields() {
    const type = document.getElementById('type').value;
    const imageFields = document.getElementById('imageFields');
    const videoFields = document.getElementById('videoFields');
    
    if (type === 'image') {
        imageFields.style.display = 'block';
        videoFields.style.display = 'none';
        document.getElementById('image_file').required = true;
        document.getElementById('file_path').required = false;
    } else if (type === 'video') {
        imageFields.style.display = 'none';
        videoFields.style.display = 'block';
        document.getElementById('image_file').required = false;
        document.getElementById('file_path').required = true;
    } else {
        imageFields.style.display = 'none';
        videoFields.style.display = 'none';
        document.getElementById('image_file').required = false;
        document.getElementById('file_path').required = false;
    }
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function previewThumbnail(input) {
    const preview = document.getElementById('thumbnailPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" 
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '<i class="fas fa-image" style="font-size: 48px; color: #adb5bd;"></i>';
    }
}

function previewYouTube(url) {
    const preview = document.getElementById('youtubePreview');
    const frame = document.getElementById('previewFrame');
    
    if (url) {
        const videoId = extractYouTubeId(url);
        if (videoId) {
            frame.src = `https://www.youtube.com/embed/${videoId}`;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
            alert('URL YouTube tidak valid');
        }
    } else {
        preview.style.display = 'none';
    }
}

function extractYouTubeId(url) {
    const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
    const match = url.match(regex);
    return match ? match[1] : null;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleMediaFields();
});
</script>
@endsection
