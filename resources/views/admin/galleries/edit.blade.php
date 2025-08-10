@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Galeri: {{ $gallery->title }}</h1>
        <div>
            <a href="{{ route('admin.galleries.show', $gallery) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-eye fa-sm text-white-50"></i> Lihat
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Start -->
    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" id="galleryForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Galeri</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $gallery->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipe <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="image" {{ old('type', $gallery->type) === 'image' ? 'selected' : '' }}>Gambar</option>
                                        <option value="video" {{ old('type', $gallery->type) === 'video' ? 'selected' : '' }}>Video</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Current Media Display -->
                        @if($gallery->file_path)
                            <div class="form-group">
                                <label>Media Saat Ini</label>
                                <div class="border p-3 rounded">
                                    @if($gallery->type === 'image')
                                        <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                                             alt="{{ $gallery->title }}" 
                                             class="img-thumbnail mb-2" 
                                             style="max-height: 200px;">
                                    @elseif($gallery->type === 'video')
                                        <video controls class="w-100 mb-2" style="max-height: 200px;">
                                            <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/mp4">
                                            Browser Anda tidak mendukung video.
                                        </video>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $gallery->file_path }}</small>
                                </div>
                            </div>
                        @endif

                        <!-- File Upload Fields -->
                        <div id="image-upload" style="{{ old('type', $gallery->type) === 'video' ? 'display: none;' : '' }}">
                            <div class="form-group">
                                <label for="image_file">Upload Gambar Baru</label>
                                <input type="file" class="form-control-file @error('image_file') is-invalid @enderror" 
                                       id="image_file" name="image_file" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 10MB</small>
                                @error('image_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="video-upload" style="{{ old('type', $gallery->type) === 'image' ? 'display: none;' : '' }}">
                            <div class="form-group">
                                <label for="file_path">URL Video</label>
                                <input type="url" class="form-control @error('file_path') is-invalid @enderror" 
                                       id="file_path" name="file_path" 
                                       value="{{ old('file_path', $gallery->type === 'video' ? $gallery->file_path : '') }}"
                                       placeholder="https://youtube.com/watch?v=... atau https://vimeo.com/...">
                                <small class="form-text text-muted">URL video YouTube, Vimeo, atau path file video</small>
                                @error('file_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label>
                            @if($gallery->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $gallery->thumbnail) }}" 
                                         alt="Current Thumbnail" class="img-thumbnail" style="max-width: 150px;">
                                    <br><small class="text-muted">Thumbnail saat ini</small>
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="form-text text-muted">Upload thumbnail baru. Format: JPG, PNG. Maksimal 2MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Update Galeri
                                </button>
                                <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-lg">
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
                            <label for="alt_text">Alt Text</label>
                            <input type="text" class="form-control @error('alt_text') is-invalid @enderror" 
                                   id="alt_text" name="alt_text" 
                                   value="{{ old('alt_text', $gallery->alt_text) }}"
                                   placeholder="Deskripsi untuk accessibility">
                            @error('alt_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="photographer">Fotografer</label>
                            <input type="text" class="form-control @error('photographer') is-invalid @enderror" 
                                   id="photographer" name="photographer" 
                                   value="{{ old('photographer', $gallery->photographer) }}">
                            @error('photographer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="taken_at">Tanggal Diambil</label>
                            <input type="date" class="form-control @error('taken_at') is-invalid @enderror" 
                                   id="taken_at" name="taken_at" 
                                   value="{{ old('taken_at', $gallery->taken_at ? $gallery->taken_at->format('Y-m-d') : '') }}">
                            @error('taken_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                                   value="1" {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Galeri Unggulan</strong>
                            </label>
                            <small class="form-text text-muted">Tampilkan di halaman utama</small>
                        </div>
                    </div>
                </div>

                <!-- Gallery Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Dibuat:</strong><br>{{ $gallery->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Terakhir Update:</strong><br>{{ $gallery->updated_at->format('d M Y H:i') }}</p>
                        @if($gallery->user)
                            <p><strong>Dibuat oleh:</strong><br>{{ $gallery->user->name }}</p>
                        @endif
                        <p><strong>Kategori:</strong><br>{{ $gallery->category->name ?? 'Tidak ada' }}</p>
                        <p><strong>Tipe:</strong><br>{{ ucfirst($gallery->type) }}</p>
                        <p><strong>Views:</strong><br>{{ number_format($gallery->views) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Form End -->
</div>
@endsection

@push('scripts')
<script>
// Toggle upload fields based on type
document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const imageUpload = document.getElementById('image-upload');
    const videoUpload = document.getElementById('video-upload');
    
    if (type === 'image') {
        imageUpload.style.display = 'block';
        videoUpload.style.display = 'none';
        document.getElementById('file_path').value = '';
    } else {
        imageUpload.style.display = 'none';
        videoUpload.style.display = 'block';
        document.getElementById('image_file').value = '';
    }
});

// Form validation
document.getElementById('galleryForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const categoryId = document.getElementById('category_id').value;
    const type = document.getElementById('type').value;
    const imageFile = document.getElementById('image_file').files[0];
    const filePath = document.getElementById('file_path').value.trim();
    
    if (!title) {
        e.preventDefault();
        alert('Judul wajib diisi!');
        document.getElementById('title').focus();
        return false;
    }
    
    if (!categoryId) {
        e.preventDefault();
        alert('Kategori wajib dipilih!');
        document.getElementById('category_id').focus();
        return false;
    }
    
    // Show loading indicator
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupdate...';
    submitBtn.disabled = true;
    
    // Re-enable button after 10 seconds (fallback)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 10000);
});

// File size validation
document.getElementById('image_file').addEventListener('change', function() {
    const file = this.files[0];
    if (file && file.size > 10 * 1024 * 1024) { // 10MB
        alert('Ukuran file terlalu besar! Maksimal 10MB.');
        this.value = '';
    }
});

document.getElementById('thumbnail').addEventListener('change', function() {
    const file = this.files[0];
    if (file && file.size > 2 * 1024 * 1024) { // 2MB
        alert('Ukuran thumbnail terlalu besar! Maksimal 2MB.');
        this.value = '';
    }
});
</script>
@endpush
