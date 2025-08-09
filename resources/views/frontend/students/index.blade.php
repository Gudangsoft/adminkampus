@extends('layouts.app')

@section('title', 'Mahasiswa - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded">
                <h1 class="h2 mb-2">
                    <i class="fas fa-user-graduate me-2"></i>Mahasiswa
                </h1>
                <p class="mb-0">Direktori mahasiswa {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('mahasiswa.index') }}">
                        <div class="row g-3">
                            <div class="col-lg-3">
                                <label for="search" class="form-label">Pencarian</label>
                                <input type="text" name="search" id="search" class="form-control" 
                                       placeholder="Nama, NIM, atau Email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-lg-3">
                                <label for="faculty" class="form-label">Fakultas</label>
                                <select name="faculty" id="faculty" class="form-select">
                                    <option value="">Semua Fakultas</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->slug }}" {{ request('faculty') == $faculty->slug ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="study_program" class="form-label">Program Studi</label>
                                <select name="study_program" id="study_program" class="form-select">
                                    <option value="">Semua Program Studi</option>
                                    @foreach($studyPrograms as $program)
                                        <option value="{{ $program->slug }}" {{ request('study_program') == $program->slug ? 'selected' : '' }}>
                                            {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="year" class="form-label">Angkatan</label>
                                <select name="year" id="year" class="form-select">
                                    <option value="">Semua Angkatan</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if(request()->hasAny(['search', 'faculty', 'study_program', 'year']))
                            <div class="row mt-2">
                                <div class="col-12">
                                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-1"></i>Reset Filter
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $students->firstItem() ?? 0 }} - {{ $students->lastItem() ?? 0 }} 
                    dari {{ $students->total() }} mahasiswa
                </small>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="row">
        @forelse($students as $student)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" class="card-img-top" 
                             alt="{{ $student->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-user-graduate fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $student->name }}</h5>
                        <p class="text-muted mb-1"><strong>NIM:</strong> {{ $student->nim }}</p>
                        
                        @if($student->studyProgram)
                            <p class="text-muted mb-1">
                                <strong>Program Studi:</strong> {{ $student->studyProgram->name }}
                            </p>
                            @if($student->studyProgram->faculty)
                                <p class="text-muted mb-1">
                                    <strong>Fakultas:</strong> {{ $student->studyProgram->faculty->name }}
                                </p>
                            @endif
                        @endif
                        
                        @if($student->entry_year)
                            <p class="text-muted mb-2">
                                <strong>Angkatan:</strong> {{ $student->entry_year }}
                            </p>
                        @endif
                        
                        <div class="mt-auto">
                            <div class="mb-2">
                                <span class="badge bg-{{ $student->status == 'active' ? 'success' : ($student->status == 'graduated' ? 'primary' : 'warning') }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </div>
                            
                            <a href="{{ route('mahasiswa.show', $student->nim) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada mahasiswa ditemukan</h5>
                    @if(request()->hasAny(['search', 'faculty', 'study_program', 'year']))
                        <p class="text-muted">Coba ubah filter pencarian Anda</p>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary">Lihat Semua Mahasiswa</a>
                    @else
                        <p class="text-muted">Belum ada data mahasiswa yang tersedia</p>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $students->appends(request()->query())->links() }}
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
</style>
@endsection
