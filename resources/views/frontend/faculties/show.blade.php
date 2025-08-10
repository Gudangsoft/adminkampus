@extends('layouts.app')

@section('title', $faculty->name . ' - Fakultas - ' . (config('app.name') ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fakultas.index') }}">Fakultas</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $faculty->name }}</li>
        </ol>
    </nav>

    <!-- Faculty Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                @if($faculty->image)
                    <img src="{{ asset('storage/' . $faculty->image) }}" class="card-img-top" 
                         alt="{{ $faculty->name }}" style="height: 300px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="card-title h2">{{ $faculty->name }}</h1>
                            <p class="card-text">{{ $faculty->description }}</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Statistik Fakultas</h6>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="fw-bold text-primary h4">{{ $stats['total_study_programs'] }}</div>
                                            <small class="text-muted">Program Studi</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold text-success h4">{{ $stats['total_lecturers'] }}</div>
                                            <small class="text-muted">Dosen</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold text-info h4">{{ $stats['total_students'] }}</div>
                                            <small class="text-muted">Mahasiswa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Study Programs Section -->
    @if($studyPrograms->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Program Studi
                    </h3>
                    <a href="{{ route('program-studi.index', ['faculty' => $faculty->slug]) }}" class="btn btn-outline-primary">
                        Lihat Semua Program Studi
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($studyPrograms as $program)
                            <div class="col-lg-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $program->name }}</h5>
                                        <div class="mb-2">
                                            <span class="badge bg-primary">{{ $program->degree }}</span>
                                            @if($program->accreditation)
                                                <span class="badge bg-success">Akreditasi {{ $program->accreditation }}</span>
                                            @endif
                                        </div>
                                        <p class="card-text text-muted">
                                            {{ Str::limit($program->description, 100) }}
                                        </p>
                                        <a href="{{ route('program-studi.show', $program->slug) }}" class="btn btn-sm btn-outline-primary">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Lecturers Section -->
    @if($lecturers->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Dosen
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($lecturers as $lecturer)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card h-100">
                                    @if($lecturer->photo)
                                        <img src="{{ asset('storage/' . $lecturer->photo) }}" class="card-img-top" 
                                             alt="{{ $lecturer->name }}" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $lecturer->name }}</h6>
                                        @if($lecturer->title)
                                            <p class="text-muted small mb-1">{{ $lecturer->title }}</p>
                                        @endif
                                        @if($lecturer->education)
                                            <p class="text-muted small mb-2">{{ $lecturer->education }}</p>
                                        @endif
                                        @if($lecturer->specialization)
                                            <div class="mb-2">
                                                @foreach(explode(',', $lecturer->specialization) as $spec)
                                                    <span class="badge bg-light text-dark me-1">{{ trim($spec) }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($lecturer->email)
                                            <a href="mailto:{{ $lecturer->email }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-envelope me-1"></i>Kontak
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($lecturers->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $lecturers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
