@extends('layouts.admin')

@section('title', 'Tambah Fakultas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-plus me-2 text-primary"></i>
                                Tambah Fakultas Baru
                            </h5>
                            <small class="text-muted">Tambahkan fakultas baru ke dalam sistem</small>
                        </div>
                        <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('admin.faculties.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Nama Fakultas -->
                                <div class="mb-4">
                                    <label for="name" class="form-label">
                                        Nama Fakultas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Contoh: Fakultas Teknik dan Informatika"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Nama fakultas akan otomatis diubah menjadi URL-friendly slug
                                    </div>
                                </div>
                                
                                <!-- Kode Fakultas -->
                                <div class="mb-4">
                                    <label for="code" class="form-label">
                                        Kode Fakultas
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('code') is-invalid @enderror" 
                                           id="code" 
                                           name="code" 
                                           value="{{ old('code') }}" 
                                           placeholder="Contoh: FTI"
                                           maxlength="10">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Kosongkan untuk generate otomatis dari nama fakultas
                                    </div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="description" class="form-label">Deskripsi Fakultas</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="5"
                                              placeholder="Deskripsikan visi, misi, dan keunggulan fakultas...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Deskripsi akan ditampilkan di halaman publik fakultas
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Status -->
                                <div class="mb-4">
                                    <label class="form-label">Status Publikasi</label>
                                    <div class="card border">
                                        <div class="card-body py-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1"
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    <strong>Aktif</strong>
                                                    <div class="form-text mb-0">Fakultas akan ditampilkan di website</div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Urutan -->
                                <div class="mb-4">
                                    <label for="sort_order" class="form-label">Urutan Tampil</label>
                                    <input type="number" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="{{ old('sort_order', 0) }}" 
                                           min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Urutan tampil di halaman fakultas (0 = paling atas)
                                    </div>
                                </div>
                                
                                <!-- Preview Card -->
                                <div class="card border border-primary">
                                    <div class="card-header bg-primary text-white py-2">
                                        <small><i class="fas fa-eye me-1"></i>Preview</small>
                                    </div>
                                    <div class="card-body py-2">
                                        <div id="preview-name" class="fw-bold text-primary mb-1">Nama Fakultas</div>
                                        <div id="preview-description" class="small text-muted">Deskripsi fakultas akan muncul di sini...</div>
                                        <div class="mt-2">
                                            <span id="preview-status" class="badge bg-success">Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light border-top">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Fakultas
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
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const statusInput = document.getElementById('is_active');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewStatus = document.getElementById('preview-status');
    
    // Update preview on input
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nama Fakultas';
    });
    
    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Deskripsi fakultas akan muncul di sini...';
    });
    
    statusInput.addEventListener('change', function() {
        if (this.checked) {
            previewStatus.className = 'badge bg-success';
            previewStatus.textContent = 'Aktif';
        } else {
            previewStatus.className = 'badge bg-secondary';
            previewStatus.textContent = 'Nonaktif';
        }
    });
    
    // Initial preview
    if (nameInput.value) previewName.textContent = nameInput.value;
    if (descriptionInput.value) previewDescription.textContent = descriptionInput.value;
});
</script>
@endpush
@endsection
