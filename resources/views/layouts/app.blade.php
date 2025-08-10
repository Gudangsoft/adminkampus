<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $globalSettings['site_name'] ?? 'G0-CAMPUS')</title>
    <meta name="description" content="@yield('meta_description', $globalSettings['site_description'] ?? 'Kampus modern untuk masa depan cemerlang')">
    <meta name="keywords" content="@yield('meta_keywords', $globalSettings['site_keywords'] ?? 'kampus, universitas, pendidikan, akademik')">

    <!-- Favicon -->
    @if(isset($globalSettings['site_favicon']) && $globalSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    @endif
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#667eea">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a67d8;
            --accent-color: #667eea;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --white: #ffffff;
            --light-bg: #f8f9fa;
        }

        /* Simple Navbar Styling */
        .navbar {
            background: var(--white) !important;
            border-bottom: 1px solid #e0e0e0;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            color: var(--primary-color) !important;
        }

        .navbar-brand img {
            object-fit: contain;
        }

        /* Simple Navigation Links */
        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            margin: 0 0.2rem;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .navbar-nav .nav-link i {
            color: var(--primary-color);
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        /* Mobile optimizations */
        .navbar-toggler {
            border: 1px solid var(--primary-color);
            padding: 0.5rem;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28102, 126, 234, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                margin-top: 1rem;
                padding: 1rem 0;
            }
            
            .navbar-nav .nav-link {
                margin: 0.25rem 0;
                padding: 0.75rem 1rem !important;
                color: var(--text-dark) !important;
            }
        }



        .navbar-nav .nav-item {
            animation: fadeInUp 0.5s ease forwards;
        }

        .navbar-nav .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .navbar-nav .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .navbar-nav .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .navbar-nav .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .navbar-nav .nav-item:nth-child(5) { animation-delay: 0.5s; }
        .navbar-nav .nav-item:nth-child(6) { animation-delay: 0.6s; }
        .navbar-nav .nav-item:nth-child(7) { animation-delay: 0.7s; }
        .navbar-nav .nav-item:nth-child(8) { animation-delay: 0.8s; }

        /* Body padding for fixed navbar */
        body {
            padding-top: 90px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Adjust main content spacing */
        main {
            min-height: calc(100vh - 90px);
        }

        /* Scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Loading animation for navbar */
        .navbar {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
        <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                        <img src="{{ asset('storage/' . $globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}" height="35" class="me-2">
                    @endif
                    <span>{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('news.*') ? 'active fw-bold' : '' }}" href="{{ route('news.index') }}">
                                <i class="fas fa-newspaper"></i> Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active fw-bold' : '' }}" href="{{ route('announcements.index') }}">
                                <i class="fas fa-bullhorn"></i> Pengumuman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('program-studi.*') ? 'active fw-bold' : '' }}" href="{{ route('program-studi.index') }}">
                                <i class="fas fa-graduation-cap"></i> Program Studi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('fakultas.*') ? 'active fw-bold' : '' }}" href="{{ route('fakultas.index') }}">
                                <i class="fas fa-university"></i> Fakultas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active fw-bold' : '' }}" href="{{ route('mahasiswa.index') }}">
                                <i class="fas fa-users"></i> Mahasiswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active fw-bold' : '' }}" href="{{ route('gallery.index') }}">
                                <i class="fas fa-images"></i> Galeri
                            </a>
                        </li>
                            </a>
                        </li>
                        
                        @php
                            $menuPages = \App\Models\Page::published()->inMenu()->orderBy('menu_order')->get();
                        @endphp
                        @foreach($menuPages as $menuPage)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($menuPage->slug) ? 'active fw-bold' : '' }}" href="{{ route('page.show', $menuPage->slug) }}">
                                <i class="fas fa-file"></i>{{ $menuPage->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        
        @include('components.footer')
    </div>
    
    <!-- Modern Navbar Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add scroll effect to navbar
            const navbar = document.querySelector('.navbar');
            let lastScrollTop = 0;

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    navbar.style.transform = 'translateY(0)';
                }
                
                // Add backdrop blur effect on scroll
                if (scrollTop > 50) {
                    navbar.style.backdropFilter = 'blur(20px)';
                    navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                    navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
                } else {
                    navbar.style.backdropFilter = 'blur(10px)';
                    navbar.style.background = '#ffffff';
                    navbar.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.08)';
                }
                
                lastScrollTop = scrollTop;
            });

            // Add ripple effect to nav links
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Create ripple element
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255, 255, 255, 0.6);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                    `;
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    // Remove ripple after animation
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Smooth collapse for mobile menu
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            if (navbarToggler && navbarCollapse) {
                navbarToggler.addEventListener('click', function() {
                    setTimeout(() => {
                        if (navbarCollapse.classList.contains('show')) {
                            navbarCollapse.style.animation = 'fadeInDown 0.3s ease';
                        }
                    }, 10);
                });
            }
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
    
    @if(isset($globalSettings['google_analytics']) && $globalSettings['google_analytics'])
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $globalSettings['google_analytics'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $globalSettings['google_analytics'] }}');
        </script>
    @endif
</body>
</html>
