@extends('layouts.app')

@section('title', 'Program Studi - ' . $faculty->name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('program-studi.index') }}">Program Studi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $faculty->name }}</li>
                </ol>
            </nav>
            
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-primary mb-3">{{ $faculty->name }}</h1>
                @if($faculty->description)
                <p class="lead text-muted">{{ $faculty->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Study Programs Grid -->
    @if($studyPrograms->count() > 0)
    <div class="row">
        @foreach($studyPrograms as $program)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 study-program-card">
                @if($program->image)
                <img src="{{ $program->image_url }}" class="card-img-top" alt="{{ $program->name }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-graduation-cap fa-3x text-white opacity-75"></i>
                </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <span class="badge bg-primary mb-2">{{ $program->degree_level }}</span>
                        @if($program->accreditation)
                        <span class="badge bg-success">Akreditasi {{ $program->accreditation }}</span>
                        @endif
                    </div>
                    
                    <h5 class="card-title fw-bold">{{ $program->name }}</h5>
                    
                    @if($program->description)
                    <p class="card-text text-muted flex-grow-1">
                        {{ Str::limit($program->description, 120) }}
                    </p>
                    @endif
                    
                    <div class="program-info mb-3">
                        @if($program->duration)
                        <small class="text-muted d-block">
                            <i class="fas fa-clock me-1"></i>
                            Durasi: {{ $program->duration }}
                        </small>
                        @endif
                        
                        @if($program->tuition_fee)
                        <small class="text-muted d-block">
                            <i class="fas fa-money-bill-wave me-1"></i>
                            Biaya: {{ $program->formatted_tuition_fee }}
                        </small>
                        @endif
                    </div>
                    
                    <div class="mt-auto">
                        <a href="{{ route('program-studi.show', $program->slug) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-info-circle me-1"></i>
                            Detail Program
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($studyPrograms->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $studyPrograms->links() }}
            </div>
        </div>
    </div>
    @endif
    
    @else
    <!-- Empty State -->
    <div class="row">
        <div class="col-12 text-center py-5">
            <div class="empty-state">
                <i class="fas fa-graduation-cap fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">Belum Ada Program Studi</h3>
                <p class="text-muted">Program studi untuk fakultas ini belum tersedia.</p>
                <a href="{{ route('program-studi.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Program
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Faculty Info Section -->
    @if($faculty->vision || $faculty->mission)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-center">Tentang {{ $faculty->name }}</h4>
                    
                    <div class="row">
                        @if($faculty->vision)
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary fw-bold">
                                <i class="fas fa-eye me-2"></i>Visi
                            </h5>
                            <p class="text-muted">{{ $faculty->vision }}</p>
                        </div>
                        @endif
                        
                        @if($faculty->mission)
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary fw-bold">
                                <i class="fas fa-bullseye me-2"></i>Misi
                            </h5>
                            <p class="text-muted">{{ $faculty->mission }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Contact Section -->
    @if($faculty->phone || $faculty->email || $faculty->address)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-phone me-2 text-primary"></i>Kontak Fakultas
                    </h5>
                    
                    <div class="row">
                        @if($faculty->phone)
                        <div class="col-md-4 mb-2">
                            <small class="text-muted d-block">Telepon</small>
                            <span>{{ $faculty->phone }}</span>
                        </div>
                        @endif
                        
                        @if($faculty->email)
                        <div class="col-md-4 mb-2">
                            <small class="text-muted d-block">Email</small>
                            <a href="mailto:{{ $faculty->email }}">{{ $faculty->email }}</a>
                        </div>
                        @endif
                        
                        @if($faculty->address)
                        <div class="col-md-4 mb-2">
                            <small class="text-muted d-block">Alamat</small>
                            <span>{{ $faculty->address }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.study-program-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
}

.study-program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.study-program-card:hover .card-img-top {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #6c757d;
}

.empty-state {
    padding: 60px 20px;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
