@extends('layouts.app')

@section('title', 'Program Studi - G0 Campus')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">Program Studi</h1>
                    <p class="text-muted mb-0">Jelajahi berbagai program studi yang tersedia di G0 Campus</p>
                </div>
                <div class="text-end">
                    <div class="d-flex align-items-center text-muted">
                        <i class="fas fa-graduation-cap me-2"></i>
                        <span class="fw-bold">{{ $programs->total() }} Program</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('program-studi.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-building me-1"></i>
                                    Fakultas
                                </label>
                                <select name="faculty" class="form-select">
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
                                <label class="form-label">
                                    <i class="fas fa-certificate me-1"></i>
                                    Jenjang
                                </label>
                                <select name="degree" class="form-select">
                                    <option value="">Semua Jenjang</option>
                                    <option value="D3" {{ request('degree') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ request('degree') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ request('degree') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ request('degree') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-search me-1"></i>
                                    Cari Program
                                </label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama program..." 
                                       value="{{ request('search') }}">
                            </div>
                            
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="w-100">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-1"></i>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        @if(request()->hasAny(['faculty', 'degree', 'search']))
                            <div class="mt-3">
                                <a href="{{ route('program-studi.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i>
                                    Reset Filter
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs Grid -->
    <div class="row">
        @forelse($programs as $program)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body d-flex flex-column">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">
                                    <a href="{{ route('program-studi.show', $program->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $program->name }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-building me-1"></i>
                                    {{ $program->faculty->name }}
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-primary">{{ $program->degree }}</span>
                                @if($program->accreditation)
                                    <span class="badge bg-success ms-1">{{ $program->accreditation }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="flex-grow-1 mb-3">
                            @if($program->description)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($program->description, 120) }}
                                </p>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="fw-bold text-primary">{{ $program->students_count ?? 0 }}</div>
                                    <small class="text-muted">Mahasiswa</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="fw-bold text-success">{{ $program->lecturers_count ?? 0 }}</div>
                                    <small class="text-muted">Dosen</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="mt-auto">
                            <a href="{{ route('program-studi.show', $program->slug) }}" 
                               class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-1"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mb-3">Tidak ada program studi ditemukan</h5>
                        <p class="text-muted mb-0">
                            @if(request()->hasAny(['faculty', 'degree', 'search']))
                                Coba ubah filter pencarian Anda
                            @else
                                Belum ada program studi yang tersedia
                            @endif
                        </p>
                        
                        @if(request()->hasAny(['faculty', 'degree', 'search']))
                            <a href="{{ route('program-studi.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-refresh me-1"></i>
                                Lihat Semua Program
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($programs->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $programs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.hover-shadow {
    transition: box-shadow 0.15s ease-in-out;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-title a:hover {
    color: var(--bs-primary) !important;
}
</style>
@endsection
