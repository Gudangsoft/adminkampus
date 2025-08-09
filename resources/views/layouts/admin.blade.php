<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    
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
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar-brand {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin-bottom: 0.25rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
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
        
        .main-content {
            padding: 2rem;
        }
        
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
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        .table th {
            border-top: none;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</h4>
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
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" 
                   href="{{ route('admin.news.index') }}">
                    <i class="fas fa-newspaper"></i>
                    Berita
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.news-categories.*') ? 'active' : '' }}" 
                   href="{{ route('admin.news-categories.index') }}">
                    <i class="fas fa-tags"></i>
                    Kategori Berita
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" 
                   href="{{ route('admin.announcements.index') }}">
                    <i class="fas fa-bullhorn"></i>
                    Pengumuman
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.faculties.*') ? 'active' : '' }}" 
                   href="{{ route('admin.faculties.index') }}">
                    <i class="fas fa-building"></i>
                    Fakultas
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.study-programs.*') ? 'active' : '' }}" 
                   href="{{ route('admin.study-programs.index') }}">
                    <i class="fas fa-graduation-cap"></i>
                    Program Studi
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.lecturers.*') ? 'active' : '' }}" 
                   href="{{ route('admin.lecturers.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Dosen
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" 
                   href="{{ route('admin.students.index') }}">
                    <i class="fas fa-user-graduate"></i>
                    Mahasiswa
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" 
                   href="{{ route('admin.galleries.index') }}">
                    <i class="fas fa-images"></i>
                    Galeri
                </a>
            </div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" 
                   href="{{ route('admin.sliders.index') }}">
                    <i class="fas fa-sliders-h"></i>
                    Slider
                </a>
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
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 d-none d-md-block">@yield('title', 'Dashboard')</h5>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span class="ms-2">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
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
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Auto dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
