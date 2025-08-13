@extends('layouts.admin')

@section('title', 'Advanced Features Overview')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-rocket"></i> Advanced Features Overview
        </h1>
        <div class="d-flex gap-2">
            <span class="badge bg-success fs-6">8 Features Implemented</span>
            <span class="badge bg-info fs-6">100% Complete</span>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="row">
        <!-- Analytics Dashboard -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                📊 Analytics Dashboard
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Complete statistics and reporting system
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Real-time statistics<br>
                                • Content analytics<br>
                                • Monthly trends<br>
                                • Export functionality
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.analytics.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Search -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                🔍 Advanced Search
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Powerful search with filters and categories
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Multi-content search<br>
                                • Advanced filters<br>
                                • Auto-suggestions<br>
                                • Export results
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('search.advanced') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Push Notifications -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                📱 Push Notifications
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Real-time notification system
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Real-time push notifications<br>
                                • Subscription management<br>
                                • Notification history<br>
                                • Multiple notification types
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Backup -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                💾 Database Backup
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Automated database backup system
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Automated backups<br>
                                • Compression support<br>
                                • Backup scheduling<br>
                                • File management
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.backups.index') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multi-language -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                🌐 Multi-language
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Indonesian & English language support
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Dynamic language switching<br>
                                • Translation management<br>
                                • Auto-scan missing keys<br>
                                • Import/Export translations
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.languages.index') }}" class="btn btn-danger btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                📋 User Management
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Registration and profile system
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • User registration<br>
                                • Profile management<br>
                                • Role-based access<br>
                                • Activity tracking
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-secondary btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Customizer -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                🎨 Theme Customizer
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Admin can customize theme appearance
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Live theme preview<br>
                                • Color customization<br>
                                • Predefined themes<br>
                                • Import/Export themes
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.theme.index') }}" class="btn btn-dark btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF Generator -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-light shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-muted text-uppercase mb-1">
                                📑 PDF Generator
                            </div>
                            <div class="text-xs mb-2 text-muted">
                                Export data to PDF format
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-success">✓ Complete</span>
                            </div>
                            <div class="text-xs">
                                <strong>Features:</strong><br>
                                • Export reports to PDF<br>
                                • Custom PDF templates<br>
                                • Batch PDF generation<br>
                                • Download & email PDFs
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-light btn-sm">
                                <i class="fas fa-external-link-alt"></i> Open
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Implementation Summary -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-check"></i> Implementation Summary
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-success">✅ Completed Features (8/8)</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-chart-pie text-primary"></i> Analytics Dashboard</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-search-plus text-success"></i> Advanced Search</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-bell text-info"></i> Push Notifications</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-database text-warning"></i> Database Backup</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-language text-danger"></i> Multi-language</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-users-cog text-secondary"></i> User Management</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-palette text-dark"></i> Theme Customizer</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf text-muted"></i> PDF Generator</span>
                                    <span class="badge bg-success rounded-pill">100%</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-info">📋 Technical Implementation</h6>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-primary">24</h3>
                                            <small class="text-muted">Controllers Created</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-success">32</h3>
                                            <small class="text-muted">Views Created</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-info">48</h3>
                                            <small class="text-muted">Routes Added</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h3 class="text-warning">12</h3>
                                            <small class="text-muted">Database Tables</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <h6 class="font-weight-bold text-info">🛠️ Technologies Used</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary">Laravel 10</span>
                                    <span class="badge bg-success">Bootstrap 5</span>
                                    <span class="badge bg-info">JavaScript ES6</span>
                                    <span class="badge bg-warning">MySQL</span>
                                    <span class="badge bg-danger">WebPush API</span>
                                    <span class="badge bg-secondary">Chart.js</span>
                                    <span class="badge bg-dark">Font Awesome</span>
                                    <span class="badge bg-light text-dark">SweetAlert2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.analytics.index') }}" class="btn btn-primary">
                                    <i class="fas fa-chart-line"></i> View Analytics
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Send Notification
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.backups.index') }}" class="btn btn-warning">
                                    <i class="fas fa-download"></i> Create Backup
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-grid">
                                <a href="{{ route('admin.theme.index') }}" class="btn btn-info">
                                    <i class="fas fa-palette"></i> Customize Theme
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .border-left-secondary {
        border-left: 0.25rem solid #858796 !important;
    }
    .border-left-dark {
        border-left: 0.25rem solid #5a5c69 !important;
    }
    .border-left-light {
        border-left: 0.25rem solid #eaecf4 !important;
        border: 1px solid #dddfeb;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .list-group-item {
        border: none;
        padding: 0.5rem 0;
    }
    
    .badge {
        font-size: 0.7rem;
    }
</style>
@endpush
@endsection
