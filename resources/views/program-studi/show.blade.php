@extends('layouts.app')

@section('title', $program->name . ' - Program Studi')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('program-studi.index') }}">Program Studi</a></li>
                    <li class="breadcrumb-item active">{{ $program->name }}</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="mb-2">
                        <span class="badge bg-primary me-2">{{ $program->degree }}</span>
                        @if($program->accreditation)
                            <span class="badge bg-success">Akreditasi {{ $program->accreditation }}</span>
                        @endif
                    </div>
                    <h1 class="h2 mb-2">{{ $program->name }}</h1>
                    <p class="text-muted mb-0">
                        <i class="fas fa-building me-1"></i>
                        <a href="{{ route('fakultas.show', $program->faculty->slug) }}" class="text-decoration-none">
                            {{ $program->faculty->name }}
                        </a>
                    </p>
                </div>
                
                <div class="text-end">
                    <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Description -->
            @if($program->description)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Tentang Program Studi
                        </h5>
                        <div class="card-text">
                            {!! nl2br(e($program->description)) !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Students List -->
            @if($students->isNotEmpty())
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Mahasiswa ({{ $students->total() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Angkatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>
                                                <span class="fw-medium">{{ $student->nim }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-medium">{{ $student->name }}</div>
                                                    @if($student->email)
                                                        <small class="text-muted">{{ $student->email }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $student->entry_year }}</span>
                                            </td>
                                            <td>
                                                @if($student->status == 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @elseif($student->status == 'inactive')
                                                    <span class="badge bg-warning">Tidak Aktif</span>
                                                @elseif($student->status == 'graduated')
                                                    <span class="badge bg-info">Lulus</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($student->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('mahasiswa.show', $student->nim) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($students->hasPages())
                            <div class="mt-3">
                                {{ $students->links() }}
                            </div>
                        @endif
                        
                        <div class="mt-3">
                            <a href="{{ route('mahasiswa.index', ['program' => $program->slug]) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-users me-1"></i>
                                Lihat Semua Mahasiswa
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lecturers List -->
            @if($lecturers->isNotEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                            Dosen ({{ $lecturers->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($lecturers as $lecturer)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $lecturer->name }}</h6>
                                            @if($lecturer->nip)
                                                <small class="text-muted d-block">NIP: {{ $lecturer->nip }}</small>
                                            @endif
                                            @if($lecturer->email)
                                                <small class="text-muted d-block">{{ $lecturer->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Statistik Program
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 text-primary mb-1">{{ $students->total() }}</div>
                                <small class="text-muted">Total Mahasiswa</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h5 text-success mb-1">{{ $lecturers->count() }}</div>
                                <small class="text-muted">Dosen</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h5 text-info mb-1">{{ $program->degree }}</div>
                                <small class="text-muted">Jenjang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info me-2 text-primary"></i>
                        Detail Program
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Jenjang</small>
                        <span class="fw-medium">{{ $program->degree }}</span>
                    </div>
                    
                    @if($program->accreditation)
                        <div class="mb-3">
                            <small class="text-muted d-block">Akreditasi</small>
                            <span class="badge bg-success">{{ $program->accreditation }}</span>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Fakultas</small>
                        <a href="{{ route('fakultas.show', $program->faculty->slug) }}" 
                           class="text-decoration-none">
                            {{ $program->faculty->name }}
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Related Programs -->
            @if($relatedPrograms->isNotEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-graduation-cap me-2 text-primary"></i>
                            Program Terkait
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($relatedPrograms as $relatedProgram)
                            <div class="mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                <h6 class="mb-1">
                                    <a href="{{ route('program-studi.show', $relatedProgram->slug) }}" 
                                       class="text-decoration-none">
                                        {{ $relatedProgram->name }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <span class="badge bg-primary me-1">{{ $relatedProgram->degree }}</span>
                                    {{ $relatedProgram->students_count ?? 0 }} mahasiswa
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
