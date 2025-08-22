@extends('layouts.admin')

@section('title', 'Tambah Program Studi')

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
                                Tambah Program Studi Baru
                            </h5>
                            <small class="text-muted">Tambahkan program studi baru ke dalam sistem</small>
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
                                    <label for="name" class="form-label">
                                        Nama Program Studi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Contoh: Teknik Informatika"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Fakultas -->
                                <div class="mb-4">
                                    <label for="faculty_id" class="form-label">
                                        Fakultas
                                    </label>
                                        <select class="form-select @error('faculty_id') is-invalid @enderror"
                                                id="faculty_id"
                                                name="faculty_id">
                                            <option value="" {{ old('faculty_id') === null || old('faculty_id') === '' ? 'selected' : '' }}>-- Tanpa Fakultas --</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                                {{ $faculty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('faculty_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Jenjang & Akreditasi -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="degree" class="form-label">
                                            Jenjang <span class="text-danger">*</span>
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
                                        <label for="accreditation" class="form-label">Akreditasi</label>
                                        <select class="form-select @error('accreditation') is-invalid @enderror" 
                                                id="accreditation" 
                                                name="accreditation">
                                            <option value="">Pilih Akreditasi</option>
                                            <option value="A" {{ old('accreditation') == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                            <option value="B" {{ old('accreditation') == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                            <option value="C" {{ old('accreditation') == 'C' ? 'selected' : '' }}>C (Cukup)</option>
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
                                <div class="card border border-primary">
                                    <div class="card-header bg-primary text-white py-2">
                                        <small><i class="fas fa-eye me-1"></i>Preview</small>
                                    </div>
                                    <div class="card-body py-2">
                                        <div id="preview-name" class="fw-bold text-primary mb-1">Nama Program Studi</div>
                                        <div id="preview-faculty" class="small text-muted mb-1">Fakultas akan muncul di sini</div>
                                        <div class="mb-2">
                                            <span id="preview-degree" class="badge bg-primary">Jenjang</span>
                                            <span id="preview-accreditation" class="badge bg-success d-none">Akreditasi</span>
                                        </div>
                                        <div id="preview-description" class="small text-muted">Deskripsi program studi akan muncul di sini...</div>
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
    const facultySelect = document.getElementById('faculty_id');
    const degreeSelect = document.getElementById('degree');
    const accreditationSelect = document.getElementById('accreditation');
    const descriptionInput = document.getElementById('description');
    const statusInput = document.getElementById('is_active');
    
    const previewName = document.getElementById('preview-name');
    const previewFaculty = document.getElementById('preview-faculty');
    const previewDegree = document.getElementById('preview-degree');
    const previewAccreditation = document.getElementById('preview-accreditation');
    const previewDescription = document.getElementById('preview-description');
    const previewStatus = document.getElementById('preview-status');
    
    // Update preview on input
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nama Program Studi';
    });
    
    facultySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        previewFaculty.textContent = selectedOption.text === 'Pilih Fakultas' ? 'Fakultas akan muncul di sini' : selectedOption.text;
    });
    
    degreeSelect.addEventListener('change', function() {
        previewDegree.textContent = this.value || 'Jenjang';
    });
    
    accreditationSelect.addEventListener('change', function() {
        if (this.value) {
            previewAccreditation.textContent = this.value;
            previewAccreditation.classList.remove('d-none');
        } else {
            previewAccreditation.classList.add('d-none');
        }
    });
    
    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Deskripsi program studi akan muncul di sini...';
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
});
</script>
@endpush
@endsection
