@extends('layouts.app')

@section('title', $student->name . ' - Mahasiswa - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Mahasiswa</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $student->name }}</li>
        </ol>
    </nav>

    <!-- Student Profile -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" class="card-img-top" 
                         alt="{{ $student->name }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-user-graduate fa-5x text-muted"></i>
                    </div>
                @endif
                
                <div class="card-body text-center">
                    <h4 class="card-title">{{ $student->name }}</h4>
                    <p class="text-muted mb-2">{{ $student->nim }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-{{ $student->status == 'active' ? 'success' : ($student->status == 'graduated' ? 'primary' : 'warning') }} fs-6">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                    
                    @if($student->email)
                        <a href="mailto:{{ $student->email }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Kirim Email
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Mahasiswa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Nama Lengkap:</strong>
                            <p class="mb-0">{{ $student->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>NIM:</strong>
                            <p class="mb-0">{{ $student->nim }}</p>
                        </div>
                        @if($student->studyProgram)
                            <div class="col-md-6 mb-3">
                                <strong>Program Studi:</strong>
                                <p class="mb-0">
                                    <a href="{{ route('program-studi.show', $student->studyProgram->slug) }}" class="text-decoration-none">
                                        {{ $student->studyProgram->name }}
                                    </a>
                                </p>
                            </div>
                            
                        @if($student->entry_year)
                            <div class="col-md-6 mb-3">
                                <strong>Tahun Masuk:</strong>
                                <p class="mb-0">{{ $student->entry_year }}</p>
                            </div>
                        @endif
                        @if($student->graduation_year)
                            <div class="col-md-6 mb-3">
                                <strong>Tahun Lulus:</strong>
                                <p class="mb-0">{{ $student->graduation_year }}</p>
                            </div>
                        @endif
                        @if($student->phone)
                            <div class="col-md-6 mb-3">
                                <strong>No. Telepon:</strong>
                                <p class="mb-0">{{ $student->phone }}</p>
                            </div>
                        @endif
                        @if($student->email)
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong>
                                <p class="mb-0">
                                    <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                                </p>
                            </div>
                        @endif
                        @if($student->address)
                            <div class="col-12 mb-3">
                                <strong>Alamat:</strong>
                                <p class="mb-0">{{ $student->address }}</p>
                            </div>
                        @endif
                        @if($student->place_of_birth)
                            <div class="col-md-6 mb-3">
                                <strong>Tempat Lahir:</strong>
                                <p class="mb-0">{{ $student->place_of_birth }}</p>
                            </div>
                        @endif
                        @if($student->date_of_birth)
                            <div class="col-md-6 mb-3">
                                <strong>Tanggal Lahir:</strong>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') }}</p>
                            </div>
                        @endif
                        @if($student->gender)
                            <div class="col-md-6 mb-3">
                                <strong>Jenis Kelamin:</strong>
                                <p class="mb-0">{{ $student->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <strong>Status:</strong>
                            <p class="mb-0">
                                <span class="badge bg-{{ $student->status == 'active' ? 'success' : ($student->status == 'graduated' ? 'primary' : 'warning') }}">
                                    @if($student->status == 'active')
                                        Aktif
                                    @elseif($student->status == 'graduated')
                                        Lulus
                                    @elseif($student->status == 'inactive')
                                        Tidak Aktif
                                    @else
                                        {{ ucfirst($student->status) }}
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            @if($student->bio || $student->achievements || $student->interests)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Informasi Tambahan
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($student->bio)
                            <div class="mb-3">
                                <strong>Biodata:</strong>
                                <p class="mb-0">{{ $student->bio }}</p>
                            </div>
                        @endif
                        
                        @if($student->achievements)
                            <div class="mb-3">
                                <strong>Prestasi:</strong>
                                <div>
                                    @foreach(explode(',', $student->achievements) as $achievement)
                                        <span class="badge bg-warning text-dark me-1 mb-1">{{ trim($achievement) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($student->interests)
                            <div class="mb-0">
                                <strong>Minat/Hobi:</strong>
                                <div>
                                    @foreach(explode(',', $student->interests) as $interest)
                                        <span class="badge bg-info me-1 mb-1">{{ trim($interest) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
