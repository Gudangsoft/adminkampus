@extends('layouts.admin')

@section('title', 'Detail Dosen')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Dosen</h1>
        <div>
            <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ $lecturer->photo_url }}" 
                         alt="{{ $lecturer->name }}" 
                         class="rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                    
                    <h4 class="card-title">{{ $lecturer->full_name }}</h4>
                    <p class="text-muted mb-2">{{ $lecturer->position }}</p>
                    <p class="text-muted mb-3">NIDN: {{ $lecturer->nidn }}</p>
                    
                    <span class="badge {{ $lecturer->is_active ? 'bg-success' : 'bg-secondary' }} mb-3">
                        {{ $lecturer->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    
                    @if($lecturer->email)
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            <span>{{ $lecturer->email }}</span>
                        </div>
                    @endif
                    
                    @if($lecturer->phone)
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <span>{{ $lecturer->phone }}</span>
                        </div>
                    @endif
                    
                    @if($lecturer->office_room)
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <span>{{ $lecturer->office_room }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Academic Info -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-university me-2"></i>Informasi Akademik</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Fakultas:</strong><br>
                        <span class="badge bg-info text-dark">{{ $lecturer->faculty->name }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Jabatan:</strong><br>
                        <span class="badge 
                            @if($lecturer->position == 'Guru Besar') bg-danger
                            @elseif($lecturer->position == 'Lektor Kepala') bg-warning text-dark
                            @elseif($lecturer->position == 'Lektor') bg-success
                            @else bg-secondary
                            @endif">
                            {{ $lecturer->position }}
                        </span>
                    </div>
                    
                    @if($lecturer->education_background)
                        <div class="mb-3">
                            <strong>Pendidikan:</strong><br>
                            {{ $lecturer->education_background }}
                        </div>
                    @endif
                    
                    @if($studyPrograms->count() > 0)
                        <div>
                            <strong>Program Studi:</strong><br>
                            @foreach($studyPrograms as $program)
                                <span class="badge bg-secondary me-1">{{ $program->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- Biography -->
            @if($lecturer->biography)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-user me-2"></i>Biografi</h6>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            {!! nl2br(e($lecturer->biography)) !!}
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Expertise -->
            @if($lecturer->expertise)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Bidang Keahlian</h6>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            {!! nl2br(e($lecturer->expertise)) !!}
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Academic Links -->
            @if($lecturer->google_scholar || $lecturer->scopus_id || $lecturer->orcid)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-link me-2"></i>Profil Akademik</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($lecturer->google_scholar)
                                <div class="col-md-4 mb-3">
                                    <strong>Google Scholar:</strong><br>
                                    <a href="{{ $lecturer->google_scholar }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fab fa-google me-1"></i> Lihat Profil
                                    </a>
                                </div>
                            @endif
                            
                            @if($lecturer->scopus_id)
                                <div class="col-md-4 mb-3">
                                    <strong>Scopus ID:</strong><br>
                                    <span class="text-muted">{{ $lecturer->scopus_id }}</span>
                                </div>
                            @endif
                            
                            @if($lecturer->orcid)
                                <div class="col-md-4 mb-3">
                                    <strong>ORCID:</strong><br>
                                    <span class="text-muted">{{ $lecturer->orcid }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Metadata -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Dibuat:</strong><br>
                            <span class="text-muted">{{ $lecturer->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Diperbarui:</strong><br>
                            <span class="text-muted">{{ $lecturer->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
