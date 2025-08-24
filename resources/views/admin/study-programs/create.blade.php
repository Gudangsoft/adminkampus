@extends('layouts.admin')

@section('title', 'Tambah Program Studi')

@push('styles')
<style>
    .form-floating {
        position: relative;
    }
    
    .preview-card {
        transition: all 0.3s ease;
        border: 2px dashed #dee2e6 !important;
    }
    
    .preview-card.has-content {
        border: 2px solid #0d6efd !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .card-header {
        background: linear-gradient(135deg, #0d6efd, #6610f2) !important;
    }
    
    .required-field::after {
        content: " *";
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                Tambah Program Studi Baru
                            </h5>
                            <small class="text-muted">Lengkapi informasi program studi yang akan ditambahkan</small>
                        </div>
                        <a href="{{ route('admin.study-programs.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('admin.study-programs.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Nama Program Studi -->
                                <div class="mb-4">
                                    <label for="name" class="form-label required-field">
                                        Nama Program Studi
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Contoh: Teknik Informatika, Sistem Informasi"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Nama lengkap program studi yang akan ditampilkan</div>
                                </div>
                                
                                <!-- Kode Program Studi -->
                                <div class="mb-4">
                                    <label for="code" class="form-label required-field">
                                        Kode Program Studi
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('code') is-invalid @enderror" 
                                           id="code" 
                                           name="code" 
                                           value="{{ old('code') }}" 
                                           placeholder="Contoh: TI, SI, MI, TE"
                                           maxlength="10"
                                           style="text-transform: uppercase;"
                                           required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kode unik untuk program studi (maksimal 10 karakter)</div>
                                </div>
                                <!-- Jenjang & Akreditasi -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="degree" class="form-label required-field">
                                            Jenjang Pendidikan
                                        </label>
                                        <select class="form-select @error('degree') is-invalid @enderror" 
                                                id="degree" 
                                                name="degree" 
                                                required>
                                            <option value="">Pilih Jenjang</option>
                                            <option value="D3" {{ old('degree') == 'D3' ? 'selected' : '' }}>D3 (Diploma 3)</option>
                                            <option value="D4" {{ old('degree') == 'D4' ? 'selected' : '' }}>D4 (Diploma 4)</option>
                                            <option value="S1" {{ old('degree') == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                            <option value="S2" {{ old('degree') == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                                            <option value="S3" {{ old('degree') == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                                        </select>
                                        @error('degree')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="accreditation" class="form-label">
                                            Status Akreditasi 
                                            <small class="text-muted">(Opsional)</small>
                                        </label>
                                        <select class="form-select @error('accreditation') is-invalid @enderror" 
                                                id="accreditation" 
                                                name="accreditation">
                                            <option value="">Pilih Akreditasi</option>
                                            <option value="A" {{ old('accreditation') == 'A' ? 'selected' : '' }}>A (Unggul)</option>
                                            <option value="B" {{ old('accreditation') == 'B' ? 'selected' : '' }}>B (Baik Sekali)</option>
                                            <option value="C" {{ old('accreditation') == 'C' ? 'selected' : '' }}>C (Baik)</option>
                                            <option value="Baik Sekali" {{ old('accreditation') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                            <option value="Baik" {{ old('accreditation') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        </select>
                                        @error('accreditation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="description" class="form-label">Deskripsi Program Studi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="5"
                                              placeholder="Deskripsikan visi, misi, dan keunggulan program studi...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Prospek Karir -->
                                <div class="mb-4">
                                    <label for="career_prospects" class="form-label">Prospek Karir</label>
                                    <textarea class="form-control @error('career_prospects') is-invalid @enderror" 
                                              id="career_prospects" 
                                              name="career_prospects" 
                                              rows="4"
                                              placeholder="Prospek karir lulusan (satu per baris)">{{ old('career_prospects') }}</textarea>
                                    @error('career_prospects')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Masukkan satu prospek karir per baris.</small>
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
                                                    <div class="form-text mb-0">Program studi akan ditampilkan di website</div>
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
                                        Urutan tampil di halaman program studi (0 = paling atas)
                                    </div>
                                </div>
                                
                                <!-- Preview Card -->
                                <div class="card preview-card" id="preview-card">
                                    <div class="card-header bg-primary text-white py-2">
                                        <small><i class="fas fa-eye me-1"></i>Preview Live</small>
                                    </div>
                                    <div class="card-body py-3">
                                        <div id="preview-name" class="fw-bold text-primary mb-1 fs-6">Nama Program Studi</div>
                                        <div id="preview-code" class="small text-muted mb-2">
                                            <i class="fas fa-code me-1"></i>Kode: <span class="fw-bold text-dark">-</span>
                                        </div>
                                        <div class="mb-2">
                                            <span id="preview-degree" class="badge bg-secondary">Jenjang</span>
                                            <span id="preview-accreditation" class="badge bg-success d-none">Akreditasi</span>
                                        </div>
                                        <div id="preview-description" class="small text-muted mb-2" style="line-height: 1.4;">
                                            Deskripsi program studi akan muncul di sini...
                                        </div>
                                        <div class="mt-2">
                                            <span id="preview-status" class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tips -->
                                <div class="alert alert-light border-start border-primary border-4 mt-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-lightbulb text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <strong>Tips:</strong>
                                            <ul class="mb-0 small mt-1">
                                                <li>Gunakan nama yang jelas dan mudah dipahami</li>
                                                <li>Kode program studi sebaiknya singkat dan unik</li>
                                                <li>Deskripsi yang menarik akan meningkatkan minat calon mahasiswa</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light border-top">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.study-programs.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Program Studi
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
    const codeInput = document.getElementById('code');
    const degreeSelect = document.getElementById('degree');
    const accreditationSelect = document.getElementById('accreditation');
    const descriptionInput = document.getElementById('description');
    const statusInput = document.getElementById('is_active');
    
    const previewCard = document.getElementById('preview-card');
    const previewName = document.getElementById('preview-name');
    const previewCode = document.getElementById('preview-code');
    const previewDegree = document.getElementById('preview-degree');
    const previewAccreditation = document.getElementById('preview-accreditation');
    const previewDescription = document.getElementById('preview-description');
    const previewStatus = document.getElementById('preview-status');
    
    // Function to check if form has content
    function checkFormContent() {
        const hasContent = nameInput.value.trim() || codeInput.value.trim() || degreeSelect.value || descriptionInput.value.trim();
        if (hasContent) {
            previewCard.classList.add('has-content');
        } else {
            previewCard.classList.remove('has-content');
        }
    }
    
    // Update preview on input
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nama Program Studi';
        checkFormContent();
    });
    
    codeInput.addEventListener('input', function() {
        const codeSpan = previewCode.querySelector('span');
        codeSpan.textContent = this.value.toUpperCase() || '-';
        codeSpan.className = this.value ? 'fw-bold text-primary' : 'fw-bold text-dark';
        checkFormContent();
    });
    
    degreeSelect.addEventListener('change', function() {
        previewDegree.textContent = this.value || 'Jenjang';
        // Update badge color based on degree
        let badgeClass = 'badge ';
        switch(this.value) {
            case 'S3':
                badgeClass += 'bg-danger';
                break;
            case 'S2':
                badgeClass += 'bg-warning text-dark';
                break;
            case 'S1':
                badgeClass += 'bg-primary';
                break;
            case 'D4':
                badgeClass += 'bg-info';
                break;
            case 'D3':
                badgeClass += 'bg-success';
                break;
            default:
                badgeClass += 'bg-secondary';
        }
        previewDegree.className = badgeClass;
        checkFormContent();
    });
    
    accreditationSelect.addEventListener('change', function() {
        if (this.value) {
            previewAccreditation.textContent = this.value;
            previewAccreditation.classList.remove('d-none');
            // Update badge color based on accreditation
            let badgeClass = 'badge ';
            switch(this.value) {
                case 'A':
                    badgeClass += 'bg-success';
                    break;
                case 'B':
                    badgeClass += 'bg-warning text-dark';
                    break;
                case 'C':
                    badgeClass += 'bg-info';
                    break;
                default:
                    badgeClass += 'bg-secondary';
            }
            previewAccreditation.className = badgeClass;
        } else {
            previewAccreditation.classList.add('d-none');
        }
    });
    
    descriptionInput.addEventListener('input', function() {
        const text = this.value || 'Deskripsi program studi akan muncul di sini...';
        previewDescription.textContent = text.length > 120 ? text.substring(0, 120) + '...' : text;
        previewDescription.className = this.value ? 'small text-dark mb-2' : 'small text-muted mb-2';
        checkFormContent();
    });
    
    statusInput.addEventListener('change', function() {
        if (this.checked) {
            previewStatus.className = 'badge bg-success';
            previewStatus.innerHTML = '<i class="fas fa-check-circle me-1"></i>Aktif';
        } else {
            previewStatus.className = 'badge bg-secondary';
            previewStatus.innerHTML = '<i class="fas fa-times-circle me-1"></i>Nonaktif';
        }
    });
    
    // Auto-uppercase for code input
    codeInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Form validation enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = [nameInput, codeInput, degreeSelect];
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });
    
    // Initialize form content check
    checkFormContent();
});
</script>
@endpush
@endsection
