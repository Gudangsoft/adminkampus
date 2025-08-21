@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center text-white">
                <h1 class="display-4 fw-bold mb-3">Program Studi</h1>
                <p class="lead mb-0">Temukan program studi yang sesuai dengan minat dan passion Anda</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('program-studi.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Program Studi</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama program studi...">
                        </div>
                        <div class="col-md-3">
                            <label for="faculty" class="form-label">Fakultas</label>
                            <select class="form-select" id="faculty" name="faculty">
                                <option value="">Semua Fakultas</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->slug }}" 
                                            {{ request('faculty') == $faculty->slug ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="degree" class="form-label">Jenjang</label>
                            <select class="form-select" id="degree" name="degree">
                                <option value="">Semua Jenjang</option>
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree }}" 
                                            {{ request('degree') == $degree ? 'selected' : '' }}>
                                        {{ $degree }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="row">
        @if($studyPrograms->count() > 0)
            @foreach($studyPrograms as $program)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 study-program-card">
                        <div class="card-body d-flex flex-column">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-primary text-white px-3 py-2">{{ $program->degree }}</span>
                                @if($program->accreditation)
                                    <span class="badge bg-success">Akreditasi {{ $program->accreditation }}</span>
                                @endif
                            </div>

                            <!-- Program Name -->
                            <h5 class="card-title fw-bold mb-2">
                                <a href="{{ route('program-studi.show', $program->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $program->name }}
                                </a>
                            </h5>

                            <!-- Faculty -->
                            @if($program->faculty && $program->faculty->slug)
                                <p class="text-muted mb-2">
                                    <i class="fas fa-university me-1"></i>
                                    <a href="{{ route('fakultas.show', $program->faculty->slug) }}" 
                                       class="text-decoration-none">
                                        {{ $program->faculty->name }}
                                    </a>
                                </p>
                            @endif

                            <!-- Description -->
                            @if($program->description)
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit(strip_tags($program->description), 120) }}
                                </p>
                            @endif

                            <!-- Stats -->
                            <div class="row text-center mb-3 mt-auto">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h6 class="fw-bold mb-0 text-primary">{{ $program->students_count }}</h6>
                                        <small class="text-muted">Mahasiswa</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h6 class="fw-bold mb-0 text-success">{{ $program->lecturers_count }}</h6>
                                    <small class="text-muted">Dosen</small>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="text-center">
                                <a href="{{ route('program-studi.show', $program->slug) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Program studi tidak ditemukan</h4>
                    <p class="text-muted">Coba ubah kriteria pencarian Anda</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($studyPrograms->hasPages())
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    {{ $studyPrograms->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    @endif
</div>

<style>
.study-program-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.study-program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.card-title a:hover {
    color: #0d6efd !important;
}
</style>
@endsection
