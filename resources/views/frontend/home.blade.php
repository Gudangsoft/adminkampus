@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
/* Modern Hero Section Styles */
.hero-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #667eea 100%);
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,1000 1000,0 1000,1000"/></svg>');
    background-size: cover;
    animation: float 6s ease-in-out infinite;
}

.hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 1px, transparent 1px),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 1px, transparent 1px),
        radial-gradient(circle at 40% 80%, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 100px 100px, 150px 150px, 120px 120px;
    animation: particles 20s linear infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(1deg); }
}

@keyframes particles {
    0% { transform: translate(0, 0); }
    100% { transform: translate(-50px, -50px); }
}

/* Hero Content */
.hero-content {
    color: white;
    z-index: 2;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 2rem;
    animation: slideInUp 1s ease-out;
}

.text-gradient {
    background: linear-gradient(45deg, #fff, #f8f9fa, #fff);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 3s ease-in-out infinite;
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.hero-subtitle {
    font-size: 1.2rem;
    line-height: 1.6;
    opacity: 0.9;
    animation: slideInUp 1s ease-out 0.2s both;
}

.hero-actions {
    animation: slideInUp 1s ease-out 0.4s both;
}

.btn-hero-primary {
    background: linear-gradient(45deg, #ff6b6b, #ee5a52);
    border: none;
    color: white;
    padding: 15px 30px;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
}

.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(255, 107, 107, 0.4);
    color: white;
}

.btn-hero-outline {
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 13px 28px;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    backdrop-filter: blur(20px);
}

.btn-hero-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
    color: white;
}

/* Hero Stats */
.hero-stats {
    animation: slideInUp 1s ease-out 0.6s both;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    display: block;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

/* Hero Visual */
.hero-visual {
    position: relative;
    animation: slideInRight 1s ease-out;
}

.hero-carousel-modern {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
}

.hero-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.hero-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.hero-card-image {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.hero-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hero-card:hover .hero-card-image img {
    transform: scale(1.1);
}

.hero-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(102, 126, 234, 0.3), rgba(118, 75, 162, 0.3));
}

.hero-card-content {
    padding: 1.5rem;
    color: white;
}

.hero-card-content h3 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.hero-card-content p {
    opacity: 0.9;
    margin: 0;
}

.hero-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.hero-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.hero-indicators button.active {
    background: white;
    transform: scale(1.2);
}

/* Hero Illustration */
.hero-illustration {
    position: relative;
    height: 500px;
    width: 100%;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 20px;
    color: white;
    text-align: center;
    animation: floatingCard 4s ease-in-out infinite;
}

.floating-card.card-1 {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-card.card-2 {
    top: 50%;
    right: 10%;
    animation-delay: 1s;
}

.floating-card.card-3 {
    bottom: 20%;
    left: 20%;
    animation-delay: 2s;
}

@keyframes floatingCard {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
}

.floating-card i {
    font-size: 2rem;
    display: block;
    margin-bottom: 10px;
    color: #ff6b6b;
}

.hero-main-graphic {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
}

.graphic-circle {
    width: 100%;
    height: 100%;
    border: 3px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.graphic-dots {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 2px, transparent 2px);
    background-size: 20px 20px;
    border-radius: 50%;
    animation: rotate 15s linear infinite reverse;
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    color: rgba(255, 255, 255, 0.8);
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

.scroll-mouse {
    width: 24px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 12px;
    margin: 0 auto 10px;
    position: relative;
}

.scroll-wheel {
    width: 4px;
    height: 8px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scrollWheel 2s infinite;
}

@keyframes scrollWheel {
    0% { opacity: 1; top: 8px; }
    100% { opacity: 0; top: 24px; }
}

.scroll-indicator span {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .btn-hero-primary, .btn-hero-outline {
        padding: 12px 24px;
        font-size: 0.9rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .hero-visual {
        margin-top: 3rem;
    }
    
    .floating-card {
        padding: 15px;
        font-size: 0.9rem;
    }
    
    .floating-card i {
        font-size: 1.5rem;
    }
}

/* Statistics Section Styles */
.stats-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.stats-card:hover::before {
    transform: scaleX(1);
}

.stats-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.stats-card:hover .stats-icon {
    transform: scale(1.1);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.stats-number {
    font-size: 3rem;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stats-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.stats-description {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.4;
}

.additional-stat h3 {
    font-size: 2.5rem;
    font-weight: 800;
}

.additional-stat p {
    font-weight: 500;
    color: #6c757d;
}

/* Legacy Hero News Styles - Keep for other sections */
.hero-news-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-height: 380px;
}

.hero-news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.hero-news-card .col-md-5 {
    position: relative;
    overflow: hidden;
}

.hero-news-card .col-md-5 img {
    transition: transform 0.3s ease;
}

.hero-news-card:hover .col-md-5 img {
    transform: scale(1.02);
}

.hero-news-title {
    font-size: 1.8rem;
    line-height: 1.3;
    color: #212529 !important;
    margin-bottom: 1rem;
}

.hero-news-excerpt {
    font-size: 1rem;
    line-height: 1.6;
    color: #6c757d;
}

.hero-news-meta .badge {
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    border-radius: 25px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* News Card Hover Effects */
.news-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px !important;
}

.news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.news-card:hover .card-img-top {
    transform: scale(1.05);
}

/* Section Styling */
.section-title {
    position: relative;
    padding-bottom: 15px;
    margin-bottom: 30px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #0056b3);
    border-radius: 2px;
}

/* Button Enhancements */
.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
}

.btn-outline-primary {
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-news-title {
        font-size: 1.5rem;
    }
    
    .hero-news-excerpt {
        font-size: 1rem;
    }
    
    .hero-news-card .row.g-0 > .col-md-5:first-child {
        order: 2;
    }
    
    .hero-news-card .row.g-0 > .col-md-7:last-child {
        order: 1;
    }
}
</style>
@endpush

@section('content')
<!-- Modern Hero Section -->
<section class="hero-section position-relative overflow-hidden">
    <!-- Animated Background -->
    <div class="hero-bg"></div>
    <div class="hero-particles"></div>
    
    <!-- Hero Content -->
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content">
                    <div class="hero-badge mb-4">
                        <i class="fas fa-star me-2"></i>
                        <span>Kampus Terdepan di Indonesia</span>
                    </div>
                    
                    <h1 class="hero-title mb-4">
                        Masa Depan Cerah <br>
                        Dimulai di <br>
                        <span class="text-gradient">{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</span>
                    </h1>
                    
                    <p class="hero-subtitle mb-5">
                        Bergabunglah dengan ribuan mahasiswa yang telah memilih jalur pendidikan terbaik. 
                        Wujudkan impian kariermu bersama kami dengan fasilitas modern dan kurikulum yang relevan dengan industri.
                    </p>
                    
                    <div class="hero-actions mb-5">
                        <a href="{{ route('program-studi.index') }}" class="btn btn-hero-primary me-3">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Lihat Program Studi
                        </a>
                        <a href="#statistics" class="btn btn-hero-outline">
                            <i class="fas fa-chart-line me-2"></i>
                            Fakta & Angka
                        </a>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="hero-stats">
                        <div class="row g-4">
                            <div class="col-6 col-md-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format($stats['total_students']) }}+</div>
                                    <div class="stat-label">Mahasiswa</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format($stats['total_lecturers']) }}+</div>
                                    <div class="stat-label">Dosen</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format($stats['total_study_programs']) }}+</div>
                                    <div class="stat-label">Program Studi</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format($stats['total_faculties']) }}+</div>
                                    <div class="stat-label">Fakultas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="hero-visual">
                    @if($sliders && $sliders->count() > 0)
                        <div class="hero-carousel-modern">
                            <div id="modernHeroCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($sliders as $index => $slider)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="hero-card">
                                            <div class="hero-card-image">
                                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="img-fluid">
                                                <div class="hero-card-overlay"></div>
                                            </div>
                                            <div class="hero-card-content">
                                                <h3>{{ $slider->title }}</h3>
                                                @if($slider->description)
                                                <p>{{ Str::limit($slider->description, 80) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <!-- Modern Indicators -->
                                <div class="hero-indicators">
                                    @foreach($sliders as $index => $slider)
                                    <button type="button" data-bs-target="#modernHeroCarousel" data-bs-slide-to="{{ $index }}" 
                                            class="{{ $index === 0 ? 'active' : '' }}"></button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="hero-illustration">
                            <div class="floating-card card-1">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Pendidikan Berkualitas</span>
                            </div>
                            <div class="floating-card card-2">
                                <i class="fas fa-users"></i>
                                <span>Komunitas Solid</span>
                            </div>
                            <div class="floating-card card-3">
                                <i class="fas fa-rocket"></i>
                                <span>Karier Cemerlang</span>
                            </div>
                            <div class="hero-main-graphic">
                                <div class="graphic-circle"></div>
                                <div class="graphic-dots"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="scroll-mouse">
            <div class="scroll-wheel"></div>
        </div>
        <span>Scroll untuk melihat lebih banyak</span>
    </div>
</section>

<!-- Statistics Section -->
<section id="statistics" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title position-relative d-inline-block mb-4">
                    Prestasi & Pencapaian Kami
                </h2>
                <p class="lead text-muted">Angka-angka yang membanggakan dari perjalanan pendidikan kami</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center p-4 h-100">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stats-number" data-count="{{ $stats['total_students'] }}">0</div>
                    <div class="stats-label">Mahasiswa Aktif</div>
                    <div class="stats-description">Dari berbagai program studi yang tersedia</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center p-4 h-100">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stats-number" data-count="{{ $stats['total_lecturers'] }}">0</div>
                    <div class="stats-label">Dosen Berkualitas</div>
                    <div class="stats-description">Tenaga pengajar berpengalaman dan profesional</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center p-4 h-100">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stats-number" data-count="{{ $stats['total_study_programs'] }}">0</div>
                    <div class="stats-label">Program Studi</div>
                    <div class="stats-description">Pilihan program sesuai minat dan bakat</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center p-4 h-100">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="stats-number" data-count="{{ $stats['total_faculties'] }}">0</div>
                    <div class="stats-label">Fakultas</div>
                    <div class="stats-description">Beragam bidang keilmuan yang komprehensif</div>
                </div>
            </div>
        </div>
        
        <!-- Additional Stats -->
        <div class="row mt-5">
            <div class="col-md-4 text-center">
                <div class="additional-stat">
                    <h3 class="text-primary mb-2">95%</h3>
                    <p class="mb-0">Tingkat Kelulusan</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="additional-stat">
                    <h3 class="text-success mb-2">88%</h3>
                    <p class="mb-0">Alumni Bekerja</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="additional-stat">
                    <h3 class="text-warning mb-2">A</h3>
                    <p class="mb-0">Akreditasi Institusi</p>
                </div>
            </div>
        </div>
    </div>
</section>
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_students']) }}</div>
                <p class="text-muted">Total Mahasiswa</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_lecturers']) }}</div>
                <p class="text-muted">Dosen</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_study_programs']) }}</div>
                <p class="text-muted">Program Studi</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="h2 text-primary fw-bold">{{ number_format($stats['total_faculties']) }}</div>
                <p class="text-muted">Fakultas</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured News Section -->
@if($featuredNews->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Berita Terbaru</h2>
        
        <!-- Hero News - First News Item -->
        @if($featuredNews->first())
        <div class="row mb-5">
            <div class="col-12">
                <div class="card hero-news-card border-0 shadow-lg overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5">
                            @if($featuredNews->first()->featured_image)
                                <img src="{{ $featuredNews->first()->featured_image_url }}" 
                                     class="img-fluid h-100 w-100" 
                                     alt="{{ $featuredNews->first()->title }}" 
                                     style="object-fit: cover; min-height: 300px; max-height: 350px;">
                            @else
                                <div class="bg-primary d-flex align-items-center justify-content-center h-100" style="min-height: 300px; max-height: 350px;">
                                    <i class="fas fa-newspaper fa-4x text-white opacity-25"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="card-body h-100 d-flex flex-column justify-content-center p-3 p-lg-4">
                                <div class="hero-news-meta mb-3">
                                    <span class="badge bg-primary px-3 py-2 mb-2">
                                        <i class="fas fa-star me-1"></i>BERITA UTAMA
                                    </span>
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $featuredNews->first()->published_at->format('d M Y') }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-tag me-2"></i>
                                        {{ $featuredNews->first()->category->name }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-eye me-2"></i>
                                        {{ number_format($featuredNews->first()->views ?? 0) }} views
                                    </div>
                                </div>
                                <h3 class="hero-news-title fw-bold mb-3 text-dark">
                                    {{ $featuredNews->first()->title }}
                                </h3>
                                <p class="hero-news-excerpt text-muted mb-4 lh-base">
                                    {{ Str::limit($featuredNews->first()->excerpt, 150) }}
                                </p>
                                <div class="hero-news-actions">
                                    <a href="{{ route('news.show', $featuredNews->first()->slug) }}" 
                                       class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Regular News Grid - Skip first news if exists -->
        @if($featuredNews->count() > 1)
        <div class="row">
            @foreach($featuredNews->skip(1) as $news)
            <div class="col-lg-4 mb-4">
                <div class="card news-card h-100 shadow-sm border-0">
                    @if($news->featured_image)
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $news->featured_image_url }}" 
                                 class="card-img-top" 
                                 alt="{{ $news->title }}" 
                                 style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                            <div class="card-img-overlay d-flex align-items-end p-0">
                                <div class="bg-dark bg-opacity-75 text-white p-2 w-100">
                                    <small>{{ $news->category->name }}</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="news-meta mb-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $news->published_at->format('d M Y') }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-eye me-1"></i>
                                {{ number_format($news->views ?? 0) }}
                            </small>
                        </div>
                        <h5 class="card-title fw-bold mb-2">{{ $news->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($news->excerpt, 100) }}</p>
                        <a href="{{ route('news.show', $news->slug) }}" 
                           class="btn btn-outline-primary btn-sm">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        <div class="text-center mt-4">
            <a href="{{ route('news.index') }}" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
@endif

<!-- Announcements Section -->
@if($urgentAnnouncements->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Pengumuman Penting</h2>
        <div class="row">
            @foreach($urgentAnnouncements as $announcement)
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-start border-danger border-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-danger me-2">{{ strtoupper($announcement->priority) }}</span>
                            <small class="text-muted">{{ $announcement->published_at->format('d M Y') }}</small>
                        </div>
                        <h6 class="card-title">{{ $announcement->title }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($announcement->excerpt, 80) }}</p>
                        <a href="{{ route('announcements.show', $announcement->slug) }}" class="btn btn-outline-danger btn-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('announcements.index') }}" class="btn btn-danger">Lihat Semua Pengumuman</a>
        </div>
    </div>
</section>
@endif

<!-- Faculties Section -->
@if($faculties->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Fakultas</h2>
        <div class="row">
            @foreach($faculties as $faculty)
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            @if($faculty->logo)
                                <img src="{{ $faculty->logo_url }}" alt="{{ $faculty->name }}" class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-university"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="card-title">{{ $faculty->name }}</h5>
                                @if($faculty->dean_name)
                                    <p class="text-muted small mb-2">Dekan: {{ $faculty->dean_name }}</p>
                                @endif
                                <p class="card-text">{{ Str::limit($faculty->description, 120) }}</p>
                                <a href="{{ route('program-studi.faculty', $faculty->slug) }}" class="btn btn-outline-primary btn-sm">Lihat Program Studi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if($featuredGallery->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title h3 fw-bold">Galeri Kegiatan</h2>
        <div class="row">
            @foreach($featuredGallery as $gallery)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="{{ $gallery->thumbnail_url }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-1">{{ Str::limit($gallery->title, 50) }}</h6>
                        <small class="text-muted">{{ $gallery->category->name }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('gallery.index') }}" class="btn btn-primary">Lihat Semua Galeri</a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="h3 mb-3">Bergabunglah dengan {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</h2>
        <p class="lead mb-4">{{ $globalSettings['site_description'] ?? 'Wujudkan impian pendidikan tinggi Anda bersama kami' }}</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('program-studi.index') }}" class="btn btn-light btn-lg">
                <i class="fas fa-graduation-cap me-2"></i>Pilih Program Studi
            </a>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
/* Hero Slider Styles */
#heroCarousel {
    height: 500px;
}

#heroCarousel .carousel-item {
    height: 500px;
}

#heroCarousel .carousel-caption {
    background: rgba(0,0,0,0.5);
    padding: 2rem;
    border-radius: 10px;
    bottom: 20%;
}

#heroCarousel .carousel-indicators {
    bottom: 1rem;
}

#heroCarousel .carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.5);
}

#heroCarousel .carousel-indicators button.active {
    background-color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
    #heroCarousel {
        height: 400px;
    }
    
    #heroCarousel .carousel-item {
        height: 400px;
    }
    
    #heroCarousel .carousel-caption h1 {
        font-size: 1.5rem;
    }
    
    #heroCarousel .carousel-caption p {
        font-size: 0.9rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modern Hero Carousel
    const modernHeroCarousel = document.getElementById('modernHeroCarousel');
    if (modernHeroCarousel) {
        new bootstrap.Carousel(modernHeroCarousel, {
            interval: 4000,
            ride: 'carousel'
        });
    }

    // Counter Animation
    function animateCounter(element, target, duration = 2000) {
        let current = 0;
        const increment = target / (duration / 16);
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // Intersection Observer for Statistics
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const numbers = entry.target.querySelectorAll('.stats-number[data-count]');
                numbers.forEach(number => {
                    const target = parseInt(number.dataset.count);
                    animateCounter(number, target);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const statsSection = document.getElementById('statistics');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }

    // Smooth Scroll for Hero Button
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Parallax Effect for Hero Background
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroBg = document.querySelector('.hero-bg');
        const heroParticles = document.querySelector('.hero-particles');
        
        if (heroBg) {
            heroBg.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
        
        if (heroParticles) {
            heroParticles.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });

    // Add hover effects to stats cards
    document.querySelectorAll('.stats-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Hero title typing effect
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const text = heroTitle.innerHTML;
        heroTitle.innerHTML = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                heroTitle.innerHTML += text.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        };
        
        // Start typing effect after a small delay
        setTimeout(typeWriter, 500);
    }
});

// Add some CSS animations via JavaScript
const style = document.createElement('style');
style.textContent = `
    .hero-content > * {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .hero-content .hero-badge { animation-delay: 0.2s; }
    .hero-content .hero-title { animation-delay: 0.4s; }
    .hero-content .hero-subtitle { animation-delay: 0.6s; }
    .hero-content .hero-actions { animation-delay: 0.8s; }
    .hero-content .hero-stats { animation-delay: 1s; }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
