@extends('layouts.admin')

@section('title', 'Edit Dosen')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Dosen</h1>
        <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.lecturers.update', $lecturer) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Personal</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nidn" class="form-label">NIDN <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nidn') is-invalid @enderror" 
                                       id="nidn" 
                                       name="nidn" 
                                       value="{{ old('nidn', $lecturer->nidn) }}" 
                                       required>
                                @error('nidn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender" 
                                        required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $lecturer->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $lecturer->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="title_prefix" class="form-label">Gelar Depan</label>
                                <input type="text" 
                                       class="form-control @error('title_prefix') is-invalid @enderror" 
                                       id="title_prefix" 
                                       name="title_prefix" 
                                       value="{{ old('title_prefix', $lecturer->title_prefix) }}" 
                                       placeholder="Dr., Prof., dll">
                                @error('title_prefix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $lecturer->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="title_suffix" class="form-label">Gelar Belakang</label>
                                <input type="text" 
                                       class="form-control @error('title_suffix') is-invalid @enderror" 
                                       id="title_suffix" 
                                       name="title_suffix" 
                                       value="{{ old('title_suffix', $lecturer->title_suffix) }}" 
                                       placeholder="M.Kom., Ph.D., dll">
                                @error('title_suffix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-university me-2"></i>Informasi Akademik</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="faculty_id" class="form-label">Fakultas <span class="text-danger">*</span></label>
                                <select class="form-select @error('faculty_id') is-invalid @enderror" 
                                        id="faculty_id" 
                                        name="faculty_id" 
                                        required>
                                    <option value="">Pilih Fakultas</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" 
                                                {{ old('faculty_id', $lecturer->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('faculty_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label">Jabatan Akademik <span class="text-danger">*</span></label>
                                <select class="form-select @error('position') is-invalid @enderror" 
                                        id="position" 
                                        name="position" 
                                        required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position }}" 
                                                {{ old('position', $lecturer->position) == $position ? 'selected' : '' }}>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="study_program_ids" class="form-label">Program Studi</label>
                                <select class="form-select @error('study_program_ids') is-invalid @enderror" 
                                        id="study_program_ids" 
                                        name="study_program_ids[]" 
                                        multiple>
                                    @foreach($studyPrograms as $program)
                                        <option value="{{ $program->id }}" 
                                                {{ in_array($program->id, old('study_program_ids', $lecturerStudyPrograms)) ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Tahan Ctrl untuk memilih multiple program studi</div>
                                @error('study_program_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="education_background" class="form-label">Latar Belakang Pendidikan</label>
                                <input type="text" 
                                       class="form-control @error('education_background') is-invalid @enderror" 
                                       id="education_background" 
                                       name="education_background" 
                                       value="{{ old('education_background', $lecturer->education_background) }}" 
                                       placeholder="S3 Teknik Informatika">
                                @error('education_background')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-address-book me-2"></i>Kontak & Detail</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $lecturer->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $lecturer->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="office_room" class="form-label">Ruang Kerja</label>
                                <input type="text" 
                                       class="form-control @error('office_room') is-invalid @enderror" 
                                       id="office_room" 
                                       name="office_room" 
                                       value="{{ old('office_room', $lecturer->office_room) }}">
                                @error('office_room')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="google_scholar" class="form-label">Google Scholar</label>
                                <input type="url" 
                                       class="form-control @error('google_scholar') is-invalid @enderror" 
                                       id="google_scholar" 
                                       name="google_scholar" 
                                       value="{{ old('google_scholar', $lecturer->google_scholar) }}">
                                @error('google_scholar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="scopus_id" class="form-label">Scopus ID</label>
                                <input type="text" 
                                       class="form-control @error('scopus_id') is-invalid @enderror" 
                                       id="scopus_id" 
                                       name="scopus_id" 
                                       value="{{ old('scopus_id', $lecturer->scopus_id) }}">
                                @error('scopus_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="expertise" class="form-label">Bidang Keahlian</label>
                            <textarea class="form-control @error('expertise') is-invalid @enderror" 
                                      id="expertise" 
                                      name="expertise" 
                                      rows="3">{{ old('expertise', $lecturer->expertise) }}</textarea>
                            @error('expertise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="biography" class="form-label">Biografi</label>
                            <textarea class="form-control @error('biography') is-invalid @enderror" 
                                      id="biography" 
                                      name="biography" 
                                      rows="4">{{ old('biography', $lecturer->biography) }}</textarea>
                            @error('biography')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Foto Profil</label>
                                @if($lecturer->photo)
                                    <div class="mb-2">
                                        <img src="{{ $lecturer->photo_url }}" 
                                             alt="Current photo" 
                                             class="img-thumbnail" 
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                        <div class="form-text">Foto saat ini</div>
                                    </div>
                                @endif
                                <input type="file" 
                                       class="form-control @error('photo') is-invalid @enderror" 
                                       id="photo" 
                                       name="photo" 
                                       accept="image/*">
                                <div class="form-text">Format: JPEG, PNG, JPG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $lecturer->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Status Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Perbarui Dosen
                    </button>
                </div>
            </form>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Edit</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            NIDN harus tetap unik
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pastikan data fakultas sesuai
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Foto akan diganti jika dipilih file baru
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success me-2"></i>
                            Status aktif mempengaruhi tampilan website
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
