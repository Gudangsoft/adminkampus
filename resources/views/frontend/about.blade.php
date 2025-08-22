@extends('layouts.frontend')

@section('title', 'Tentang Kami')
@section('meta_description', 'Tentang Kampus Admin - Website resmi kampus dengan sistem manajemen konten modern')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Tentang Kami</h1>
                <p class="lead text-muted">
                    Website resmi kampus dengan sistem manajemen konten yang modern dan user-friendly
                </p>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="h3 text-primary mb-4">Visi</h2>
                    <p class="mb-4">
                        Menjadi platform digital terdepan dalam pengelolaan informasi kampus yang 
                        memberikan kemudahan akses informasi bagi seluruh civitas akademika.
                    </p>
                    
                    <h2 class="h3 text-primary mb-4">Misi</h2>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Menyediakan sistem informasi yang terintegrasi dan mudah digunakan</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Memfasilitasi komunikasi yang efektif antar civitas akademika</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Mendukung transparansi dan akuntabilitas institusi</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Meningkatkan kualitas pelayanan digital kampus</li>
                    </ul>
                    
                    <h2 class="h3 text-primary mb-4 mt-5">Fitur Utama</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-newspaper text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Manajemen Berita</h5>
                                    <p class="text-muted small">Sistem publikasi berita dan pengumuman yang mudah dikelola</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-images text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Galeri Media</h5>
                                    <p class="text-muted small">Pengelolaan foto dan video kegiatan kampus</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-users text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Direktori Dosen</h5>
                                    <p class="text-muted small">Database lengkap profil dosen dan staf akademik</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Program Studi</h5>
                                    <p class="text-muted small">Informasi lengkap program studi dan fakultas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
