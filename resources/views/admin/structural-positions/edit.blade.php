@extends('layouts.admin')

@section('title', 'Edit Jabatan Struktural - ' . $structuralPosition->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>Edit Jabatan Struktural
            </h1>
            <p class="text-muted">Perbarui informasi jabatan struktural: {{ $structuralPosition->name }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.structural-positions.show', $structuralPosition) }}" class="btn btn-info">
                <i class="fas fa-eye me-1"></i>Lihat
            </a>
            <a href="{{ route('admin.structural-positions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tie me-2"></i>Informasi Jabatan Struktural
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.structural-positions.update', $structuralPosition) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="name" class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $structuralPosition->name) }}"
                                       placeholder="e.g. Rektor, Wakil Rektor I"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="level" class="form-label">Level Hierarki <span class="text-danger">*</span></label>
                                <select class="form-select @error('level') is-invalid @enderror" 
                                        id="level" 
                                        name="level" 
                                        required>
                                    <option value="">Pilih Level</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('level', $structuralPosition->level) == $i ? 'selected' : '' }}>
                                            Level {{ $i }} 
                                            @if($i == 1) (Tertinggi)
                                            @elseif($i == 10) (Terendah)
                                            @endif
                                        </option>
                                    @endfor
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $key }}" {{ old('category', $structuralPosition->category) == $key ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Urutan Tampil</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', $structuralPosition->sort_order) }}"
                                       min="0"
                                       placeholder="0">
                                <div class="form-text">Urutan tampilan dalam daftar (0 = pertama)</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Deskripsi tugas dan tanggung jawab jabatan...">{{ old('description', $structuralPosition->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $structuralPosition->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                                <div class="form-text">Jabatan yang aktif akan muncul dalam pilihan saat mengelola dosen</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Perbarui
                            </button>
                            <a href="{{ route('admin.structural-positions.show', $structuralPosition) }}" class="btn btn-info">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                            <a href="{{ route('admin.structural-positions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Dosen dengan Jabatan Ini
                    </h6>
                </div>
                <div class="card-body">
                    @if($structuralPosition->lecturers()->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>{{ $structuralPosition->lecturers()->count() }} dosen</strong> saat ini menggunakan jabatan struktural ini.
                        </div>
                        <small class="text-muted">
                            Perubahan akan mempengaruhi data dosen yang terkait.
                        </small>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada dosen yang menggunakan jabatan ini.
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Panduan
                    </h6>
                </div>
                <div class="card-body">
                    <h6>Level Hierarki:</h6>
                    <ul class="small">
                        <li><strong>Level 1-2:</strong> Rektor, Wakil Rektor, Direktur</li>
                        <li><strong>Level 3-4:</strong> Dekan, Wakil Dekan</li>
                        <li><strong>Level 5-6:</strong> Kepala Program Studi</li>
                        <li><strong>Level 7+:</strong> Kepala Unit, Bagian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
