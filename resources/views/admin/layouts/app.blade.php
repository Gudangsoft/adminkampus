<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Admin Kampus') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), #1e40af);
            color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 2px 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        
        .main-content {
            background-color: white;
            min-height: 100vh;
            padding: 0;
        }
        
        .topbar {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .page-title-box {
            background: linear-gradient(135deg, var(--primary-color), #1e40af);
            color: white;
            padding: 2rem 1.5rem;
            margin: 0 -15px 2rem -15px;
        }
        
        .page-title {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 600;
        }
        
        .breadcrumb {
            background: none;
            margin: 0;
            padding: 0;
        }
        
        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-title {
            font-size: 1.25rem;
        }
        
        .text-primary { color: var(--primary-color) !important; }
        .text-success { color: var(--success-color) !important; }
        .text-danger { color: var(--danger-color) !important; }
        .text-warning { color: var(--warning-color) !important; }
        .text-info { color: var(--info-color) !important; }
        
        .bg-light { background-color: var(--light-color) !important; }
        
        .rounded-circle {
            border-radius: 50% !important;
        }
        
        .font-20 {
            font-size: 1.25rem !important;
        }
        
        .fw-normal {
            font-weight: 400 !important;
        }
        
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .me-2 {
            margin-right: 0.5rem !important;
        }
        
        .text-end {
            text-align: right !important;
        }
        
        .text-muted {
            color: #6b7280 !important;
        }
        
        .mt-0 { margin-top: 0 !important; }
        .my-2 { margin-top: 0.5rem !important; margin-bottom: 0.5rem !important; }
        .py-1 { padding-top: 0.25rem !important; padding-bottom: 0.25rem !important; }
        .mb-0 { margin-bottom: 0 !important; }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="p-3">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Admin Kampus
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.components.*') ? 'active' : '' }}" href="{{ route('admin.components.index') }}">
                            <i class="fas fa-cogs me-2"></i> Dashboard Komponen
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.components.quick-access') ? 'active' : '' }}" href="{{ route('admin.components.quick-access') }}">
                            <i class="fas fa-bolt me-2"></i> Quick Access
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.components.live-chat') ? 'active' : '' }}" href="{{ route('admin.components.live-chat') }}">
                            <i class="fas fa-comments me-2"></i> Live Chat
                        </a>
                        
                        <hr class="my-3 border-secondary">
                        
                        <a class="nav-link" href="{{ route('admin.login') }}">
                            <i class="fas fa-shield-alt me-2"></i> Admin Sistem
                        </a>
                        
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-globe me-2"></i> Lihat Website
                        </a>
                    </nav>
                </div>
                
                <!-- User Info -->
                <div class="mt-auto p-3 border-top border-light border-opacity-25">
                    @auth
                    <div class="d-flex align-items-center text-white">
                        <div class="avatar-sm bg-light bg-opacity-25 rounded-circle me-2">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-white-50">{{ auth()->user()->email }}</small>
                        </div>
                        <a href="{{ route('component.logout') }}" class="text-white-50 ms-2" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                    
                    <form id="logout-form" action="{{ route('component.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @endauth
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top Bar -->
                <div class="topbar">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">@yield('title', 'Admin Panel')</h5>
                        </div>
                        <div>
                            <span class="text-muted">{{ date('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Page Content -->
                <div class="container-fluid py-3">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js untuk analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>
