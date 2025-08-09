<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', setting('site_description'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('site_keywords'))">
    <title>@yield('title') - {{ setting('site_name', 'G0-CAMPUS') }}</title>
    
    <!-- Favicon -->
    @if(setting('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ Storage::url(setting('site_favicon')) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --accent-color: #f59e0b;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --bg-light: #f8fafc;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background: white !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            color: white;
            min-height: 500px;
            display: flex;
            align-items: center;
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .footer {
            background-color: var(--text-dark);
            color: white;
        }
        
        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        .news-card .card-body {
            padding: 1.5rem;
        }
        
        .news-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .news-meta {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.75rem;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                min-height: 400px;
                text-align: center;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                @if(setting('site_logo'))
                    <img src="{{ Storage::url(setting('site_logo')) }}" alt="{{ setting('site_name') }}" height="40" class="me-2">
                @endif
                {{ setting('site_name', 'G0-CAMPUS') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('tentang-kami') ? 'active' : '' }}" href="{{ route('page.show', 'tentang-kami') }}">Tentang</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('study-programs.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            Program Studi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('study-programs.index') }}">Semua Program</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('study-programs.faculty', 'fakultas-teknik') }}">Fakultas Teknik</a></li>
                            <li><a class="dropdown-item" href="{{ route('study-programs.faculty', 'fakultas-ekonomi-dan-bisnis') }}">Fakultas Ekonomi & Bisnis</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('kontak') ? 'active' : '' }}" href="{{ route('page.show', 'kontak') }}">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-3">{{ setting('site_name', 'G0-CAMPUS') }}</h5>
                    <p class="text-light">{{ setting('site_description', 'Website Resmi Universitas G0-CAMPUS') }}</p>
                    <div class="social-links">
                        @if(setting('social_facebook'))
                            <a href="{{ setting('social_facebook') }}" class="me-3" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if(setting('social_instagram'))
                            <a href="{{ setting('social_instagram') }}" class="me-3" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if(setting('social_youtube'))
                            <a href="{{ setting('social_youtube') }}" class="me-3" target="_blank">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                        @if(setting('social_twitter'))
                            <a href="{{ setting('social_twitter') }}" class="me-3" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-2 mb-4">
                    <h6 class="text-white mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('page.show', 'tentang-kami') }}">Tentang</a></li>
                        <li><a href="{{ route('study-programs.index') }}">Program Studi</a></li>
                        <li><a href="{{ route('news.index') }}">Berita</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 mb-4">
                    <h6 class="text-white mb-3">Informasi</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('announcements.index') }}">Pengumuman</a></li>
                        <li><a href="{{ route('gallery.index') }}">Galeri</a></li>
                        <li><a href="{{ route('page.show', 'kontak') }}">Kontak</a></li>
                        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h6 class="text-white mb-3">Kontak</h6>
                    <p class="text-light">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ setting('contact_address', 'Alamat kampus belum diatur') }}
                    </p>
                    <p class="text-light">
                        <i class="fas fa-phone me-2"></i>
                        {{ setting('contact_phone', 'Telepon belum diatur') }}
                    </p>
                    <p class="text-light">
                        <i class="fas fa-envelope me-2"></i>
                        {{ setting('contact_email', 'Email belum diatur') }}
                    </p>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: #475569;">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; {{ date('Y') }} {{ setting('site_name', 'G0-CAMPUS') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-light mb-0">Developed with <i class="fas fa-heart text-danger"></i> by G0-CAMPUS Team</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
