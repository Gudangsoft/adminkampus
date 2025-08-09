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
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        .navbar-brand {
            font-size: 1.25rem !important;
            text-decoration: none !important;
        }
        .navbar-brand:hover {
            text-decoration: none !important;
        }
        .navbar-brand img {
            object-fit: contain;
        }
        .nav-link.active {
            color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 0.375rem;
        }
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 0.375rem;
            margin: 0 2px;
        }
        .nav-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
            transform: translateY(-1px);
        }
        @media (max-width: 991.98px) {
            .navbar-nav .nav-link {
                margin: 2px 0;
                padding: 0.75rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                        <img src="{{ asset('storage/' . $globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}" height="40" class="me-2">
                    @endif
                    <span class="fw-bold">{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('news.*') ? 'active fw-bold' : '' }}" href="{{ route('news.index') }}">
                                <i class="fas fa-newspaper me-1"></i>Berita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active fw-bold' : '' }}" href="{{ route('announcements.index') }}">
                                <i class="fas fa-bullhorn me-1"></i>Pengumuman
                            </a>
                        </li>
                                                <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('program-studi.*') ? 'active fw-bold' : '' }}" href="{{ route('program-studi.index') }}">
                                <i class="fas fa-graduation-cap me-1"></i>Program Studi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('fakultas.*') ? 'active fw-bold' : '' }}" href="{{ route('fakultas.index') }}">
                                <i class="fas fa-building me-1"></i>Fakultas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active fw-bold' : '' }}" href="{{ route('mahasiswa.index') }}">
                                <i class="fas fa-users me-1"></i>Mahasiswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active fw-bold' : '' }}" href="{{ route('gallery.index') }}">
                                <i class="fas fa-images me-1"></i>Galeri
                            </a>
                        </li>
                        
                        @php
                            $menuPages = \App\Models\Page::published()->inMenu()->orderBy('menu_order')->get();
                        @endphp
                        @foreach($menuPages as $menuPage)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($menuPage->slug) ? 'active fw-bold' : '' }}" href="{{ route('page.show', $menuPage->slug) }}">
                                <i class="fas fa-file-alt me-1"></i>{{ $menuPage->title }}
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
