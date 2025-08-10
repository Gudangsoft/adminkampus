@extends('layouts.app')

@section('title', 'Beranda - Kampus Kesehatan Modern')

@push('styles')
<style>
:root {
    --primary-color: #00A859;
    --secondary-color: #1E88E5;
    --accent-color: #FF6B35;
    --dark-color: #004D40;
}

.hero-section {
    height: 80vh;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    display: flex;
    align-items: center;
    color: white;
}

.hero-section h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
}
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1>Kampus Kesehatan Modern</h1>
                <p class="lead">Membentuk tenaga kesehatan profesional untuk masa depan yang lebih sehat.</p>
                <a href="#about" class="btn btn-light btn-lg">Mulai Eksplorasi</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 fw-bold mb-4">Tentang Kampus Kesehatan</h2>
                <p class="lead">Kami berkomitmen untuk mencetak tenaga kesehatan profesional yang berkualitas tinggi.</p>
            </div>
        </div>
        
        <div class="row g-4 mt-5">
            <div class="col-lg-4">
                <div class="card text-center p-4">
                    <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                    <h5>Pendidikan Klinis</h5>
                    <p>Program pendidikan yang menggabungkan teori dan praktik klinis.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center p-4">
                    <i class="fas fa-microscope fa-3x text-primary mb-3"></i>
                    <h5>Laboratorium Modern</h5>
                    <p>Fasilitas laboratorium lengkap dengan peralatan canggih.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center p-4">
                    <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                    <h5>Dosen Berpengalaman</h5>
                    <p>Tim pengajar yang terdiri dari dokter spesialis berpengalaman.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Smooth scrolling
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
