@extends('layouts.app')

@section('title', 'Fakultas - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded">
                <h1 class="h2 mb-2">
                    <i class="fas fa-university me-2"></i>Fakultas
                </h1>
                <p class="mb-0">Jelajahi berbagai fakultas di {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</p>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <form method="GET" action="{{ route('fakultas.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari fakultas..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('fakultas.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="col-lg-6">
            <div class="d-flex justify-content-lg-end">
                <small class="text-muted align-self-center">
                    Menampilkan {{ $faculties->firstItem() ?? 0 }} - {{ $faculties->lastItem() ?? 0 }} 
                    dari {{ $faculties->total() }} fakultas
                </small>
            </div>
        </div>
    </div>

    <!-- Faculties Grid -->
    <div class="row">
        @forelse($faculties as $faculty)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    @if($faculty->image)
                        <img src="{{ asset('storage/' . $faculty->image) }}" class="card-img-top" 
                             alt="{{ $faculty->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $faculty->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit($faculty->description, 120) }}
                        </p>
                        
                        <div class="faculty-stats mb-3">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="fw-bold text-primary">{{ $faculty->study_programs_count }}</div>
                                    <small class="text-muted">Program Studi</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-success">{{ $faculty->lecturers_count }}</div>
                                    <small class="text-muted">Dosen</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-info">{{ $faculty->students_count ?? 0 }}</div>
                                    <small class="text-muted">Mahasiswa</small>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('fakultas.show', $faculty->slug) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-1"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-university fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada fakultas ditemukan</h5>
                    @if(request('search'))
                        <p class="text-muted">Coba ubah kata kunci pencarian Anda</p>
                        <a href="{{ route('fakultas.index') }}" class="btn btn-primary">Lihat Semua Fakultas</a>
                    @else
                        <p class="text-muted">Belum ada data fakultas yang tersedia</p>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($faculties->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $faculties->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.faculty-stats {
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    padding: 0.75rem 0;
}
</style>
@endsection
