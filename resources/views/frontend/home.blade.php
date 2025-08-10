@extends('layouts.app')
@section('title', 'Homepage - ' . ($globalSettings['site_name'] ?? 'G0-CAMPUS'))

@push('styles')
<style>
    .section-content {
        line-height: 1.6;
    }
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 60vh;
    }
    .card-section {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .card-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section text-white d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">{{ $globalSettings['site_name'] ?? 'KESOSI' }}</h1>
                <p class="lead mb-4">{{ $globalSettings['site_description'] ?? 'Kampus Kesehatan Modern' }}</p>
                <div class="d-flex gap-3">
                    <a href="#sections" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-down me-2"></i>Jelajahi
                    </a>
                    <a href="/admin/sections" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Kelola Sections
                    </a>
                </div>
            </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-university fa-5x opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Sections -->
    <section id="sections" class="py-5">
        <div class="container">
            @if($sections->count() > 0)
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Sections Dinamis</h2>
                    <p class="text-muted">{{ $sections->count() }} sections aktif yang dapat dikelola melalui admin</p>
                </div>
                
                <div class="row">
                    @foreach($sections as $section)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card card-section h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-bookmark me-2"></i>
                                        {{ $section->title }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="section-content">
                                        {!! nl2br(e($section->content)) !!}
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <small class="text-muted">
                                        <i class="fas fa-sort me-1"></i>Urutan: {{ $section->order }}
                                        <span class="float-end">
                                            <i class="fas fa-{{ $section->is_active ? 'check text-success' : 'times text-danger' }}"></i>
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Management Link -->
                <div class="text-center mt-5">
                    <a href="/admin/sections" class="btn btn-primary btn-lg">
                        <i class="fas fa-edit me-2"></i>Kelola Sections
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                    <h3>Belum Ada Sections</h3>
                    <p class="text-muted mb-4">Mulai membuat sections untuk mengisi halaman homepage</p>
                    <a href="/admin/sections" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Buat Section Pertama
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<!-- Smooth scroll untuk navigasi -->
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
@endpush
