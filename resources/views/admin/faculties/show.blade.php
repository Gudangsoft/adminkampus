@extends('layouts.admin')

@section('title', 'Detail Fakultas - ' . $faculty->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-building me-2 text-primary"></i>
                                Detail Fakultas
                            </h5>
                            <small class="text-muted">Informasi lengkap tentang {{ $faculty->name }}</small>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('fakultas.show', $faculty->slug) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i>Lihat di Website
                            </a>
                            <a href="{{ route('admin.faculties.edit', $faculty) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $faculty->name }}</h3>
                            @if($faculty->description)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Deskripsi:</h6>
                                    <p class="text-muted">{{ $faculty->description }}</p>
                                </div>
                            @endif
                            
                            <!-- Quick Stats -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card border border-primary">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-graduation-cap fa-2x text-primary mb-2"></i>
                                            <h4 class="text-primary mb-1">{{ $studyPrograms->count() }}</h4>
                                            <small class="text-muted">Program Studi</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border border-success">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-users fa-2x text-success mb-2"></i>
                                            <h4 class="text-success mb-1">{{ $faculty->students->count() }}</h4>
                                            <small class="text-muted">Mahasiswa</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border border-info">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-chalkboard-teacher fa-2x text-info mb-2"></i>
                                            <h4 class="text-info mb-1">{{ $faculty->lecturers->count() }}</h4>
                                            <small class="text-muted">Dosen</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Status & Info -->
                            <div class="card border">
                                <div class="card-header py-2">
                                    <small class="fw-bold">Informasi Fakultas</small>
                                </div>
                                <div class="card-body py-3">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Status</small>
                                        <span class="badge {{ $faculty->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $faculty->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Urutan Tampil</small>
                                        <span class="fw-medium">{{ $faculty->sort_order }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Slug URL</small>
                                        <code class="small">{{ $faculty->slug }}</code>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Dibuat</small>
                                        <span class="small">{{ $faculty->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="mb-0">
                                        <small class="text-muted d-block">Terakhir Diperbarui</small>
                                        <span class="small">{{ $faculty->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Study Programs -->
            @if($studyPrograms->isNotEmpty())
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                Program Studi ({{ $studyPrograms->count() }})
                            </h6>
                            <a href="{{ route('admin.study-programs.create', ['faculty' => $faculty->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah Program Studi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Program Studi</th>
                                        <th>Jenjang</th>
                                        <th>Akreditasi</th>
                                        <th>Mahasiswa</th>
                                        <th>Dosen</th>
                                        <th>Status</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studyPrograms as $program)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $program->name }}</div>
                                                @if($program->description)
                                                    <small class="text-muted">{{ Str::limit($program->description, 60) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $program->degree }}</span>
                                            </td>
                                            <td>
                                                @if($program->accreditation)
                                                    <span class="badge bg-success">{{ $program->accreditation }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $program->students_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $program->lecturers_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $program->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $program->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.study-programs.show', $program) }}" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.study-programs.edit', $program) }}" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Recent Students -->
            @if($faculty->students->isNotEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-users me-2 text-primary"></i>
                                Mahasiswa Terbaru ({{ $faculty->students->count() > 10 ? '10 dari ' . $faculty->students->count() : $faculty->students->count() }})
                            </h6>
                            <a href="{{ route('admin.students.index', ['faculty' => $faculty->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-users me-1"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Program Studi</th>
                                        <th>Angkatan</th>
                                        <th>Status</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($faculty->students->take(10) as $student)
                                        <tr>
                                            <td>
                                                <code class="small">{{ $student->nim }}</code>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $student->name }}</div>
                                                @if($student->email)
                                                    <small class="text-muted">{{ $student->email }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="small">{{ $student->studyProgram->name }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $student->entry_year }}</span>
                                            </td>
                                            <td>
                                                @if($student->status == 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @elseif($student->status == 'graduate')
                                                    <span class="badge bg-info">Lulus</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($student->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.students.show', $student) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
