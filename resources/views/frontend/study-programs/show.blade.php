@extends('layouts.app')

@section('title', $studyProgram->name . ' - Program Studi')

@section('content')
<!-- Hero Section -->
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-white">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('program-studi.index') }}" class="text-white-50">Program Studi</a></li>
                        <li class="breadcrumb-item active text-white">{{ $studyProgram->name }}</li>
                    </ol>
                </nav>
                
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-light text-primary px-3 py-2 me-3">{{ $studyProgram->degree }}</span>
                            @if($studyProgram->accreditation)
                                <span class="badge bg-success px-3 py-2">Akreditasi {{ $studyProgram->accreditation }}</span>
                            @endif
                        </div>
                        <h1 class="display-5 fw-bold mb-3">{{ $studyProgram->name }}</h1>
                        <p class="lead mb-3">
                            <i class="fas fa-university me-2"></i>
                            <a href="{{ route('fakultas.show', $studyProgram->faculty->slug) }}" class="text-white">
                                {{ $studyProgram->faculty->name }}
                            </a>
                        </p>
                    </div>
                    
                    <div class="col-lg-4 text-lg-end">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <h4 class="fw-bold mb-1">{{ $studyProgram->students_count ?? 0 }}</h4>
                                    <small>Mahasiswa</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <h4 class="fw-bold mb-1">{{ $lecturers->count() }}</h4>
                                    <small>Dosen</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <h4 class="fw-bold mb-1">{{ date('Y') - 2000 + 1 }}</h4>
                                    <small>Tahun</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Description -->
            @if($studyProgram->description)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tentang Program Studi</h5>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            {!! $studyProgram->description !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Career Prospects Section -->
            @if($studyProgram->career_prospects && count($studyProgram->career_prospects) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Prospek Karir</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($studyProgram->career_prospects as $index => $prospect)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary rounded-circle me-3" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                            {{ $index + 1 }}
                                        </span>
                                        <span>{{ $prospect }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lecturers Section -->
            @if($lecturers->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Dosen Program Studi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($lecturers as $lecturer)
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="lecturer-avatar me-3">
                                            <img src="{{ $lecturer->photo_url }}" 
                                                 alt="{{ $lecturer->name }}" 
                                                 class="rounded-circle" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $lecturer->full_name }}</h6>
                                            @if($lecturer->position)
                                                <p class="mb-1 text-muted small">{{ $lecturer->position }}</p>
                                            @endif
                                            @if($lecturer->email)
                                                <p class="mb-0 text-muted small">
                                                    <i class="fas fa-envelope me-1"></i>{{ $lecturer->email }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($studyProgram->faculty->lecturers()->count() > $lecturers->count())
                            <div class="text-center">
                                <a href="{{ route('fakultas.show', $studyProgram->faculty->slug) }}" 
                                   class="btn btn-outline-success">
                                    <i class="fas fa-eye me-1"></i>Lihat Semua Dosen
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info me-2"></i>Informasi Program</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <strong>Fakultas:</strong><br>
                            <a href="{{ route('fakultas.show', $studyProgram->faculty->slug) }}" 
                               class="text-decoration-none">
                                {{ $studyProgram->faculty->name }}
                            </a>
                        </div>
                        <div class="col-6">
                            <strong>Jenjang:</strong><br>
                            <span class="badge bg-primary">{{ $studyProgram->degree }}</span>
                        </div>
                        @if($studyProgram->accreditation)
                            <div class="col-6">
                                <strong>Akreditasi:</strong><br>
                                <span class="badge bg-success">{{ $studyProgram->accreditation }}</span>
                            </div>
                        @endif
                        <div class="col-6">
                            <strong>Total Mahasiswa:</strong><br>
                            <span class="text-primary fw-bold">{{ $studyProgram->students_count ?? 0 }}</span>
                        </div>
                        <div class="col-6">
                            <strong>Total Dosen:</strong><br>
                            <span class="text-success fw-bold">{{ $lecturers->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Programs -->
            @if($relatedPrograms->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Program Studi Lainnya</h6>
                    </div>
                    <div class="card-body">
                        @foreach($relatedPrograms as $related)
                            <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('program-studi.show', $related->slug) }}" 
                                           class="text-decoration-none">
                                            {{ $related->name }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ $related->degree }}</small>
                                </div>
                                <span class="badge bg-primary">{{ $related->students_count ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Contact Faculty -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-phone me-2"></i>Kontak Fakultas</h6>
                </div>
                <div class="card-body text-center">
                    <p class="mb-3">Butuh informasi lebih lanjut tentang program studi ini?</p>
                    <a href="{{ route('fakultas.show', $studyProgram->faculty->slug) }}" 
                       class="btn btn-secondary btn-sm">
                        <i class="fas fa-university me-1"></i>Hubungi Fakultas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content img {
    max-width: 100%;
    height: auto;
}

.lecturer-avatar img {
    border: 3px solid #e9ecef;
}

.breadcrumb-dark .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}
</style>
@endsection
