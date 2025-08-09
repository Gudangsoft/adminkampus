@extends('layouts.admin')

@section('title', 'Tambah Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tambah Slider Baru</h3>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Slider <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Deskripsi atau subtitle untuk slider">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label class="form-label">Gambar Slider <span class="text-danger">*</span></label>
                                    
                                    <!-- Tab Navigation -->
                                    <ul class="nav nav-tabs" id="imageTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                                                <i class="fas fa-upload me-1"></i>Upload File
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button" role="tab">
                                                <i class="fas fa-link me-1"></i>URL Gambar
                                            </button>
                                        </li>
                                    </ul>
                                    
                                    <!-- Tab Content -->
                                    <div class="tab-content border border-top-0 p-3">
                                        <div class="tab-pane fade show active" id="upload" role="tabpanel">
                                            <input type="file" 
                                                   class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image" 
                                                   accept="image/*">
                                            <div class="form-text">
                                                Format: JPG, PNG, GIF. Maksimal 2MB. Resolusi yang disarankan: 1920x800px.
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="url" role="tabpanel">
                                            <input type="url" 
                                                   class="form-control @error('image_url') is-invalid @enderror" 
                                                   id="image_url" 
                                                   name="image_url" 
                                                   placeholder="https://example.com/image.jpg">
                                            <div class="form-text">
                                                Masukkan URL gambar yang valid. Pastikan gambar dapat diakses publik.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('image_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img id="image-preview" 
                                             src="#" 
                                             alt="Preview" 
                                             class="img-thumbnail d-none" 
                                             style="max-width: 300px; max-height: 150px;">
                                    </div>
                                </div>

                                <!-- Link -->
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link (Opsional)</label>
                                    <input type="url" 
                                           class="form-control @error('link') is-invalid @enderror" 
                                           id="link" 
                                           name="link" 
                                           value="{{ old('link') }}"
                                           placeholder="https://example.com">
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Button Text -->
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Teks Tombol (Opsional)</label>
                                    <input type="text" 
                                           class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" 
                                           name="button_text" 
                                           value="{{ old('button_text') }}"
                                           maxlength="50"
                                           placeholder="Selengkapnya">
                                    <div class="form-text">Maks. 50 karakter. Tampil hanya jika ada link.</div>
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Settings Card -->
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Pengaturan Slider</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Link Target -->
                                        <div class="mb-3">
                                            <label for="link_target" class="form-label">Target Link</label>
                                            <select class="form-select @error('link_target') is-invalid @enderror" 
                                                    id="link_target" 
                                                    name="link_target">
                                                <option value="_self" {{ old('link_target') == '_self' ? 'selected' : '' }}>
                                                    Tab yang sama (_self)
                                                </option>
                                                <option value="_blank" {{ old('link_target') == '_blank' ? 'selected' : '' }}>
                                                    Tab baru (_blank)
                                                </option>
                                            </select>
                                            @error('link_target')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Sort Order -->
                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" 
                                                   name="sort_order" 
                                                   value="{{ old('sort_order', 1) }}" 
                                                   min="0"
                                                   required>
                                            <div class="form-text">Angka lebih kecil akan tampil lebih dulu.</div>
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1"
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    <strong>Aktifkan Slider</strong>
                                                </label>
                                            </div>
                                            <div class="form-text">Slider hanya akan tampil jika diaktifkan.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Card -->
                                <div class="card mt-3" id="preview-card" style="display: none;">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Preview</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="position-relative">
                                            <img id="preview-image" 
                                                 src="#" 
                                                 alt="Preview" 
                                                 class="w-100 rounded" 
                                                 style="height: 120px; object-fit: cover;">
                                            <div class="position-absolute bottom-0 start-0 end-0 p-2 bg-dark bg-opacity-75 text-white">
                                                <h6 class="mb-1 small" id="preview-title">Judul Slider</h6>
                                                <p class="mb-0 small text-muted" id="preview-description">Deskripsi slider</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Slider
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const imageInput = document.getElementById('image');
    const imageUrlInput = document.getElementById('image_url');
    const imagePreview = document.getElementById('image-preview');
    const previewCard = document.getElementById('preview-card');
    const previewImage = document.getElementById('preview-image');
    const previewTitle = document.getElementById('preview-title');
    const previewDescription = document.getElementById('preview-description');

    // Form inputs for live preview
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');

    // Handle file upload preview
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showImagePreview(e.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            hideImagePreview();
        }
    });

    // Handle URL input preview
    imageUrlInput.addEventListener('input', function(e) {
        const url = e.target.value;
        if (url && isValidUrl(url)) {
            showImagePreview(url);
        } else {
            hideImagePreview();
        }
    });

    function showImagePreview(src) {
        imagePreview.src = src;
        imagePreview.classList.remove('d-none');
        
        previewImage.src = src;
        previewCard.style.display = 'block';
        updatePreview();
    }

    function hideImagePreview() {
        imagePreview.classList.add('d-none');
        previewCard.style.display = 'none';
    }

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // Live preview update
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);

    function updatePreview() {
        const title = titleInput.value || 'Judul Slider';
        const description = descriptionInput.value || 'Deskripsi slider';
        
        previewTitle.textContent = title;
        previewDescription.textContent = description.length > 80 ? description.substring(0, 80) + '...' : description;
    }

    // Tab switching - clear other input when switching
    document.getElementById('upload-tab').addEventListener('shown.bs.tab', function() {
        imageUrlInput.value = '';
        if (!imageInput.files.length) {
            hideImagePreview();
        }
    });

    document.getElementById('url-tab').addEventListener('shown.bs.tab', function() {
        imageInput.value = '';
        if (!imageUrlInput.value) {
            hideImagePreview();
        }
    });
});
</script>
@endpush
@endsection
