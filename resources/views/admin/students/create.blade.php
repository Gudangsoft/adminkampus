@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Mahasiswa</a></li>
                        <li class="breadcrumb-item active">Tambah Mahasiswa</li>
                    </ol>
                </div>
                <h4 class="page-title">Tambah Mahasiswa</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-user-add-line me-2"></i>Form Tambah Mahasiswa
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" id="studentForm">
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
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                                                       id="nim" name="nim" value="{{ old('nim') }}" required>
                                                @error('nim')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="study_program_id" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                                <select class="form-select @error('study_program_id') is-invalid @enderror" 
                                                        id="study_program_id" name="study_program_id" required>
                                                    <option value="">Pilih Program Studi</option>
                                                    @foreach($studyPrograms as $program)
                                                        <option value="{{ $program->id }}" 
                                                                {{ old('study_program_id') == $program->id ? 'selected' : '' }}>
                                                            {{ $program->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('study_program_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <select class="form-select @error('gender') is-invalid @enderror" 
                                                        id="gender" name="gender" required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" 
                                                       id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}">
                                                @error('place_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                                @error('date_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Kontak</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="phone" class="form-label">No. Telepon</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                       id="phone" name="phone" value="{{ old('phone') }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="parent_name" class="form-label">Nama Orang Tua/Wali</label>
                                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                                       id="parent_name" name="parent_name" value="{{ old('parent_name') }}">
                                                @error('parent_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="parent_phone" class="form-label">No. Telepon Orang Tua/Wali</label>
                                                <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                                                       id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}">
                                                @error('parent_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Informasi Akademik</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="entry_year" class="form-label">Tahun Masuk <span class="text-danger">*</span></label>
                                                <select class="form-select @error('entry_year') is-invalid @enderror" 
                                                        id="entry_year" name="entry_year" required>
                                                    <option value="">Pilih Tahun Masuk</option>
                                                    @for($year = date('Y'); $year >= 2000; $year--)
                                                        <option value="{{ $year }}" 
                                                                {{ old('entry_year') == $year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('entry_year')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="school_origin" class="form-label">Asal Sekolah</label>
                                                <input type="text" class="form-control @error('school_origin') is-invalid @enderror" 
                                                       id="school_origin" name="school_origin" value="{{ old('school_origin') }}">
                                                @error('school_origin')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="semester" class="form-label">Semester</label>
                                                <select class="form-select @error('semester') is-invalid @enderror" 
                                                        id="semester" name="semester">
                                                    <option value="">Pilih Semester</option>
                                                    @for($sem = 1; $sem <= 14; $sem++)
                                                        <option value="{{ $sem }}" 
                                                                {{ old('semester') == $sem ? 'selected' : '' }}>
                                                            Semester {{ $sem }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('semester')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="gpa" class="form-label">IPK</label>
                                                <input type="number" step="0.01" min="0" max="4" 
                                                       class="form-control @error('gpa') is-invalid @enderror" 
                                                       id="gpa" name="gpa" value="{{ old('gpa') }}">
                                                @error('gpa')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="credits_taken" class="form-label">SKS Diambil</label>
                                                <input type="number" min="0" max="160" 
                                                       class="form-control @error('credits_taken') is-invalid @enderror" 
                                                       id="credits_taken" name="credits_taken" value="{{ old('credits_taken') }}">
                                                @error('credits_taken')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="graduation_date" class="form-label">Tanggal Lulus</label>
                                                <input type="date" class="form-control @error('graduation_date') is-invalid @enderror" 
                                                       id="graduation_date" name="graduation_date" value="{{ old('graduation_date') }}">
                                                @error('graduation_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Photo Upload -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Foto Mahasiswa</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div id="photoPreview" class="mx-auto mb-3" 
                                                 style="width: 200px; height: 200px; border: 2px dashed #ddd; 
                                                        border-radius: 8px; display: flex; align-items: center; 
                                                        justify-content: center; background-color: #f8f9fa;">
                                                <i class="ri-image-line" style="font-size: 48px; color: #adb5bd;"></i>
                                            </div>
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                                   id="photo" name="photo" accept="image/*" onchange="previewPhoto(this)">
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Ukuran maksimal 2MB. Format: JPG, PNG, GIF</small>
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
                                            <input class="form-check-input" type="checkbox" id="is_active" 
                                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Status Aktif
                                            </label>
                                        </div>
                                        <small class="text-muted">Mahasiswa dengan status aktif akan ditampilkan di website</small>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ri-save-line me-2"></i>Simpan Mahasiswa
                                            </button>
                                            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                                                <i class="ri-arrow-left-line me-2"></i>Kembali
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
function previewPhoto(input) {
    const preview = document.getElementById('photoPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" 
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '<i class="ri-image-line" style="font-size: 48px; color: #adb5bd;"></i>';
    }
}

// Auto generate slug when name changes
document.getElementById('name').addEventListener('input', function(e) {
    // Auto-generate slug functionality if needed
});

// Form validation
document.getElementById('studentForm').addEventListener('submit', function(e) {
    // Additional client-side validation if needed
});
</script>
@endsection
