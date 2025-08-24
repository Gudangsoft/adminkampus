<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    
    <!-- Favicon -->
    @if(isset($globalSettings['site_favicon']) && $globalSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    @endif
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#667eea">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar.hidden {
            transform: translateX(-100%);
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.3);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.5);
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand h4, .sidebar-brand h5 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        
        .sidebar-logo {
            background: rgba(255, 255, 255, 0.95);
            padding: 8px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: block;
            margin: 0 auto;
        }
        
        .sidebar-logo:hover {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        
        .topbar-logo {
            max-height: 35px;
            width: auto;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.9);
            padding: 4px 8px;
            border-radius: 6px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Navigation Styles */
        .nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
        }
        
        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.2);
            border-right: 3px solid white;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
            font-size: 0.9rem;
        }
        
        /* Dropdown Navigation */
        .dropdown-nav .dropdown-toggle {
            color: rgba(255,255,255,0.8);
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }
        
        .dropdown-nav .dropdown-toggle:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        
        .dropdown-nav .dropdown-toggle .fa-chevron-down {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }
        
        .dropdown-nav .nav-link.dropdown-toggle[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }
        
        .submenu {
            background: rgba(0,0,0,0.2);
            border-left: 3px solid rgba(255,255,255,0.3);
            margin-left: 1.5rem;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .submenu .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
        }
        
        .submenu .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 1.5rem;
        }
        
        .submenu .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-right: 2px solid white;
        }
        
        .submenu .nav-link i {
            width: 16px;
            margin-right: 0.5rem;
            font-size: 0.8rem;
        }
        
        /* Collapse animation */
        .collapse {
            transition: height 0.3s ease, opacity 0.3s ease;
        }
        
        .collapse:not(.show) {
            height: 0 !important;
            opacity: 0;
        }
        
        .collapse.show {
            opacity: 1;
        }
        
        /* Content Wrapper */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .content-wrapper.expanded {
            margin-left: 0;
        }
        
        /* Topbar */
        .topbar {
            background: white;
            height: var(--topbar-height);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            color: #495057;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background-color: #e9ecef;
            color: #212529;
        }
        
        /* Main Content */
        .main-content {
            padding: 2rem;
            min-height: calc(100vh - var(--topbar-height));
        }
        
        /* Cards */
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 1.25rem;
            border-radius: 10px 10px 0 0 !important;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        /* Tables */
        .table th {
            border-top: none;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            background: #f8f9fa;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        /* Bootstrap 4 Badge Compatibility */
        .badge-success {
            background-color: #28a745 !important;
            color: white !important;
        }
        
        .badge-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }
        
        .badge-info {
            background-color: #17a2b8 !important;
            color: white !important;
        }
        
        .badge-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        
        .badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
            display: inline-block;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .sidebar-toggle {
                display: block !important;
            }
        }
        
        @media (min-width: 769px) {
            .sidebar-toggle-mobile {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                <img src="{{ asset('storage/' . $globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}" class="sidebar-logo" style="max-height: 60px; max-width: 200px; margin-bottom: 12px; object-fit: contain;">
                <h5 class="mb-0">{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</h5>
            @else
                <div class="default-logo-container" style="background: rgba(255, 255, 255, 0.95); padding: 15px; border-radius: 8px; margin-bottom: 12px;">
                    <div class="default-logo" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-graduation-cap" style="color: white; font-size: 24px;"></i>
                    </div>
                </div>
                <h4>{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</h4>
            @endif
            <small class="text-white-50">Admin Panel</small>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            <!-- Berita Menu with Dropdown -->
            <div class="nav-item dropdown-nav">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.news.*') || request()->routeIs('admin.news-categories.*') ? 'active' : '' }}" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#beritaMenu" aria-expanded="{{ request()->routeIs('admin.news.*') || request()->routeIs('admin.news-categories.*') ? 'true' : 'false' }}">
                    <i class="fas fa-newspaper"></i>
                    Berita
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.news.*') || request()->routeIs('admin.news-categories.*') ? 'show' : '' }}" id="beritaMenu">
                    <div class="submenu">
                        <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" 
                           href="{{ route('admin.news.index') }}">
                            <i class="fas fa-newspaper"></i>
                            Kelola Berita
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.news-categories.*') ? 'active' : '' }}" 
                           href="{{ route('admin.news-categories.index') }}">
                            <i class="fas fa-tags"></i>
                            Kategori Berita
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" 
                   href="{{ route('admin.announcements.index') }}">
                    <i class="fas fa-bullhorn"></i>
                    Pengumuman
                </a>
            </div>
            
            <!-- Akademik Menu with Dropdown -->
            <div class="nav-item dropdown-nav">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.faculties.*') || request()->routeIs('admin.study-programs.*') || request()->routeIs('admin.lecturers.*') || request()->routeIs('admin.students.*') ? 'active' : '' }}" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#akademikMenu" aria-expanded="{{ request()->routeIs('admin.faculties.*') || request()->routeIs('admin.study-programs.*') || request()->routeIs('admin.lecturers.*') || request()->routeIs('admin.students.*') ? 'true' : 'false' }}">
                    <i class="fas fa-university"></i>
                    Akademik
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.faculties.*') || request()->routeIs('admin.study-programs.*') || request()->routeIs('admin.lecturers.*') || request()->routeIs('admin.students.*') ? 'show' : '' }}" id="akademikMenu">
                    <div class="submenu">
                       
                        <a class="nav-link {{ request()->routeIs('admin.study-programs.*') ? 'active' : '' }}" 
                           href="{{ route('admin.study-programs.index') }}">
                            <i class="fas fa-graduation-cap"></i>
                            Program Studi
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.lecturers.*') ? 'active' : '' }}" 
                           href="{{ route('admin.lecturers.index') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Dosen
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" 
                           href="{{ route('admin.students.index') }}">
                            <i class="fas fa-user-graduate"></i>
                            Mahasiswa
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Media Menu with Dropdown -->
            <div class="nav-item dropdown-nav">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.sliders.*') || request()->routeIs('admin.sections.*') ? 'active' : '' }}" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#mediaMenu" aria-expanded="{{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.sliders.*') || request()->routeIs('admin.sections.*') ? 'true' : 'false' }}">
                    <i class="fas fa-photo-video"></i>
                    Media
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.sliders.*') || request()->routeIs('admin.sections.*') ? 'show' : '' }}" id="mediaMenu">
                    <div class="submenu">
                        <a class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" 
                           href="{{ route('admin.galleries.index') }}">
                            <i class="fas fa-images"></i>
                            Galeri
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" 
                           href="{{ route('admin.sliders.index') }}">
                            <i class="fas fa-sliders-h"></i>
                            Slider
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}" 
                           href="{{ route('admin.sections.index') }}">
                            <i class="fas fa-th-large"></i>
                            Sections
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" 
                   href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-file-alt"></i>
                    Halaman
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" 
                   href="{{ route('admin.menus.index') }}">
                    <i class="fas fa-bars"></i>
                    Menu
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" 
                   href="{{ route('admin.profile.show') }}">
                    <i class="fas fa-user"></i>
                    Profil
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </div>
            
            <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
            
            <div class="nav-item">
                <a class="nav-link" href="{{ url('/') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    Lihat Website
                </a>
            </div>
            
            <div class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <a class="nav-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </form>
            </div>
        </nav>
    </div>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                @if(isset($globalSettings['site_logo']) && $globalSettings['site_logo'])
                    <img src="{{ asset('storage/' . $globalSettings['site_logo']) }}" alt="{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}" class="topbar-logo d-none d-lg-inline" style="height: 35px; margin-right: 10px;">
                @else
                    <div class="topbar-default-logo d-none d-lg-inline" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; margin-right: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-graduation-cap" style="color: white; font-size: 16px;"></i>
                    </div>
                @endif
                <h5 class="mb-0 d-none d-md-block">@yield('title', 'Dashboard')</h5>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span class="ms-2">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.show') }}"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="#" 
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.querySelector('.content-wrapper');
            
            // Load saved state
            const sidebarHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (sidebarHidden) {
                sidebar.classList.add('hidden');
                contentWrapper.classList.add('expanded');
            }
            
            // Toggle function
            sidebarToggle?.addEventListener('click', function() {
                const isHidden = sidebar.classList.contains('hidden');
                
                if (isHidden) {
                    // Show sidebar
                    sidebar.classList.remove('hidden');
                    contentWrapper.classList.remove('expanded');
                    localStorage.setItem('sidebarHidden', 'false');
                } else {
                    // Hide sidebar
                    sidebar.classList.add('hidden');
                    contentWrapper.classList.add('expanded');
                    localStorage.setItem('sidebarHidden', 'true');
                }
            });
            
            // Mobile specific behavior
            if (window.innerWidth <= 768) {
                // On mobile, always start with sidebar hidden
                sidebar.classList.add('hidden');
                contentWrapper.classList.add('expanded');
                
                // Mobile toggle shows sidebar temporarily
                sidebarToggle?.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                            sidebar.classList.remove('show');
                        }
                    }
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    // Restore desktop state
                    const sidebarHidden = localStorage.getItem('sidebarHidden') === 'true';
                    if (sidebarHidden) {
                        sidebar.classList.add('hidden');
                        contentWrapper.classList.add('expanded');
                    } else {
                        sidebar.classList.remove('hidden');
                        contentWrapper.classList.remove('expanded');
                    }
                } else {
                    // Mobile: always start hidden
                    sidebar.classList.add('hidden');
                    contentWrapper.classList.add('expanded');
                }
            });
        });
        
        // Auto dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Dropdown navigation handling
        document.addEventListener('DOMContentLoaded', function() {
            // Handle dropdown toggle clicks
            const dropdownToggles = document.querySelectorAll('.dropdown-nav .dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('data-bs-target');
                    const targetElement = document.querySelector(targetId);
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    // Close all other dropdowns
                    dropdownToggles.forEach(otherToggle => {
                        if (otherToggle !== this) {
                            const otherTargetId = otherToggle.getAttribute('data-bs-target');
                            const otherTarget = document.querySelector(otherTargetId);
                            if (otherTarget) {
                                otherTarget.classList.remove('show');
                                otherToggle.setAttribute('aria-expanded', 'false');
                                otherToggle.classList.remove('active');
                            }
                        }
                    });
                    
                    // Toggle current dropdown
                    if (isExpanded) {
                        targetElement.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                        this.classList.remove('active');
                    } else {
                        targetElement.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                        this.classList.add('active');
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
