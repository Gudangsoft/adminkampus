@extends('layouts.app')
@section('title', 'Pejabat Struktural - ' . config('app.name'))

@push('styles')
<style>
    .official-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
    }
    
    .official-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .official-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .official-name {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .official-position {
        color: #27ae60;
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .category-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .category-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .category-description {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }
    
    .contact-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .contact-item i {
        width: 20px;
        margin-right: 10px;
        color: #6c757d;
    }
    
    /* Center alignment for single official cards */
    .officials-grid .row {
        justify-content: center;
    }
    
    /* Responsive centering for single cards */
    @media (min-width: 992px) {
        .officials-grid .col-lg-4:only-child {
            max-width: 400px;
        }
    }
    
    @media (max-width: 991px) {
        .officials-grid .col-md-6:only-child {
            max-width: 400px;
        }
    }
    
    /* Enhanced centering for categories with single official */
    .officials-grid .row:has(.col-lg-4:only-child),
    .officials-grid .row:has(.col-md-6:only-child) {
        display: flex;
        justify-content: center;
    }
    
    /* Alternative approach using flexbox */
    .single-official-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .single-official-center .col-lg-4,
    .single-official-center .col-md-6 {
        max-width: 400px;
        flex: 0 0 auto;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<!-- Campus Officials Content -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Pejabat Struktural</h1>
                <p class="lead text-muted">Para pemimpin yang mengabdi untuk kemajuan institusi pendidikan</p>
            </div>
        </div>
        @if($campusOfficials->count() > 0)
            @foreach($groupedOfficials as $category => $officials)
            <div class="mb-5">
                <!-- Category Header -->
                <div class="category-header">
                    <h2 class="category-title">
                        @if($category == 'Rektor')
                            <i class="fas fa-crown me-2"></i>Pimpinan Sekolah Tinggi
                        @elseif($category == 'Direktur')
                            <i class="fas fa-university me-2"></i>Pimpinan Sekolah Tinggi
                        @elseif($category == 'Lembaga')
                            <i class="fas fa-building me-2"></i>Pimpinan Lembaga
                        @elseif($category == 'Program Studi')
                            <i class="fas fa-graduation-cap me-2"></i>Pimpinan Program Studi
                        @elseif($category == 'Dekan')
                            <i class="fas fa-user-graduate me-2"></i>Pimpinan Fakultas
                        @elseif($category == 'Unit')
                            <i class="fas fa-cogs me-2"></i>Pimpinan Unit
                        @elseif($category == 'Bagian')
                            <i class="fas fa-users-cog me-2"></i>Pimpinan Bagian
                        @else
                            <i class="fas fa-user-tie me-2"></i>{{ $category }}
                        @endif
                    </h2>
                    <p class="category-description">
                        @if($category == 'Rektor')
                            Pimpinan tertinggi sekolah tinggi yang bertanggung jawab atas seluruh kebijakan strategis
                        @elseif($category == 'Direktur')
                            Direktur dan wakil direktur sekolah tinggi
                        @elseif($category == 'Lembaga')
                            Pimpinan lembaga penelitian, pengabdian masyarakat, dan lembaga lainnya
                        @elseif($category == 'Program Studi')
                            Pimpinan program studi yang fokus pada pengembangan kurikulum dan akademik
                        @elseif($category == 'Dekan')
                            Pimpinan fakultas dan wakil dekan
                        @elseif($category == 'Unit')
                            Pimpinan unit pelaksana teknis dan layanan
                        @elseif($category == 'Bagian')
                            Pimpinan bagian administratif dan operasional
                        @else
                            Para pejabat struktural kategori {{ $category }}
                        @endif
                    </p>
                </div>

                <!-- Officials Grid -->
                <div class="officials-grid">
                    <div class="row g-4 justify-content-center {{ count($officials) == 1 ? 'single-official-center' : '' }}">
                        @foreach($officials as $official)
                        <div class="col-lg-4 col-md-6 col-sm-8 {{ count($officials) == 1 ? 'd-flex justify-content-center' : '' }}">
                            <div class="card official-card h-100 shadow-sm {{ count($officials) == 1 ? 'mx-auto' : '' }}" style="{{ count($officials) == 1 ? 'max-width: 400px;' : '' }}">
                                <div class="card-body text-center p-4">
                                <!-- Photo -->
                                <div class="mb-4">
                                    @if($official->photo)
                                        <img src="{{ $official->photo_url }}" 
                                             alt="{{ $official->name }}"
                                             class="official-photo">
                                    @else
                                        <div class="official-photo mx-auto d-flex align-items-center justify-content-center bg-light border">
                                            <i class="fas fa-user fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Basic Info -->
                                <h5 class="official-name">{{ $official->full_name }}</h5>
                                <p class="official-position">{{ $official->structuralPosition->name }}</p>
                                
                                @if($official->nidn)
                                <p class="text-muted small mb-3">NIDN: {{ $official->nidn }}</p>
                                @endif

                                @if($official->position)
                                <div class="mb-3">
                                    <span class="badge bg-secondary">{{ $official->position }}</span>
                                </div>
                                @endif

                                @if($official->structural_description)
                                <p class="text-muted small mb-3">{{ Str::limit($official->structural_description, 100) }}</p>
                                @endif

                                <!-- Contact Info -->
                                @if($official->email || $official->phone || $official->office_location)
                                <div class="contact-info">
                                    @if($official->email)
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <small><a href="mailto:{{ $official->email }}" class="text-decoration-none">{{ $official->email }}</a></small>
                                    </div>
                                    @endif
                                    
                                    @if($official->phone)
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <small><a href="tel:{{ $official->phone }}" class="text-decoration-none">{{ $official->phone }}</a></small>
                                    </div>
                                    @endif
                                    
                                    @if($official->office_location)
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <small>{{ $official->office_location }}</small>
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Period Info -->
                                @if($official->structural_start_date || $official->structural_end_date)
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        @if($official->structural_start_date)
                                            Mulai: {{ $official->structural_start_date->format('d M Y') }}
                                        @endif
                                        @if($official->structural_end_date)
                                            <br>Selesai: {{ $official->structural_end_date->format('d M Y') }}
                                        @else
                                            @if($official->structural_start_date)
                                                <br><span class="text-success">Aktif</span>
                                            @endif
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-users fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Belum Ada Data Pejabat</h3>
                <p class="text-muted">Data pejabat struktural sedang dalam proses pemutakhiran.</p>
            </div>
        @endif

        <!-- Back to Home Button -->
        <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
