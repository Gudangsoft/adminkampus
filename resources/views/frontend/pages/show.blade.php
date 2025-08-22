@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)

@section('meta')
@if($page->meta_description)
    <meta name="description" content="{{ $page->meta_description }}">
@endif
@if($page->meta_keywords)
    <meta name="keywords" content="{{ $page->meta_keywords }}">
@endif
<meta property="og:title" content="{{ $page->meta_title ?: $page->title }}">
@if($page->meta_description)
    <meta property="og:description" content="{{ $page->meta_description }}">
@endif
@if($page->featured_image)
    <meta property="og:image" content="{{ asset('storage/' . $page->featured_image) }}">
@endif
<meta property="og:type" content="article">
<meta property="og:url" content="{{ request()->url() }}">
@endsection

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header bg-primary text-white rounded-lg mb-4 p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title mb-2">{{ $page->title }}</h1>
                @if($page->meta_description)
                    <p class="page-subtitle mb-0 opacity-75">{{ $page->meta_description }}</p>
                @endif
            </div>
            @if($page->featured_image)
                <div class="col-md-4 text-end">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" 
                         alt="{{ $page->title }}" 
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 120px; object-fit: cover;">
                </div>
            @endif
        </div>
    </div>

    <!-- Page Content -->
    <div class="row">
        <div class="col-lg-8">
            <article class="page-content">
                @if($page->featured_image && !isset($showHeaderImage))
                    <div class="featured-image mb-4 text-center">
                        <img src="{{ asset('storage/' . $page->featured_image) }}" 
                             alt="{{ $page->title }}" 
                             class="img-fluid rounded shadow-sm">
                    </div>
                @endif
                
                <div class="content">
                    {!! $page->content !!}
                </div>
                
                <!-- Page Meta Info -->
                <div class="page-meta mt-5 pt-4 border-top">
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}
                        </div>
                        @if($page->user)
                        <div class="col-md-6 text-md-end">
                            <i class="fas fa-user me-2"></i>
                            Oleh: {{ $page->user->name }}
                        </div>
                        @endif
                    </div>
                </div>
            </article>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Quick Navigation -->
                @php
                    $menuPages = \App\Models\Page::published()->inMenu()->orderBy('menu_order')->get();
                @endphp
                
                @if($menuPages->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sitemap me-2"></i>
                            Halaman Lainnya
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($menuPages as $menuPage)
                                <a href="{{ route('pages.show', $menuPage->slug) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $menuPage->slug === $page->slug ? 'active' : '' }}">
                                    {{ $menuPage->title }}
                                    @if($menuPage->slug === $page->slug)
                                        <i class="fas fa-chevron-right"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Contact Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Kontak
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="contact-info">
                            <p class="mb-2">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                <strong>Telepon:</strong><br>
                                <span class="ms-4">(021) 123-4567</span>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <strong>Email:</strong><br>
                                <span class="ms-4">info@gocampus.ac.id</span>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                <strong>Alamat:</strong><br>
                                <span class="ms-4">
                                    Jl. Pendidikan No. 123<br>
                                    Jakarta Selatan 12345
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-share-alt me-2"></i>
                            Media Sosial
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="social-links d-flex justify-content-around">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                        
                        <!-- Share This Page -->
                        <hr>
                        <p class="mb-2"><strong>Bagikan halaman ini:</strong></p>
                        <div class="share-buttons d-flex justify-content-around">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($page->title) }}" 
                               target="_blank" class="btn btn-info btn-sm">
                                <i class="fab fa-twitter me-1"></i> Twitter
                            </a>
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
/* Page Content Styles */
.page-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.page-content .content h1,
.page-content .content h2,
.page-content .content h3,
.page-content .content h4,
.page-content .content h5,
.page-content .content h6 {
    color: #2c3e50;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.page-content .content h1 {
    font-size: 2.5rem;
    border-bottom: 3px solid #007bff;
    padding-bottom: 0.5rem;
}

.page-content .content h2 {
    font-size: 2rem;
    color: #007bff;
}

.page-content .content h3 {
    font-size: 1.5rem;
    color: #495057;
}

.page-content .content p {
    line-height: 1.8;
    margin-bottom: 1.5rem;
    text-align: justify;
}

.page-content .content ul,
.page-content .content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content .content li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.page-content .content blockquote {
    border-left: 4px solid #007bff;
    padding: 1rem 1.5rem;
    margin: 2rem 0;
    background-color: #f8f9fa;
    font-style: italic;
}

.page-content .content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin: 1rem 0;
}

.page-content .content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
}

.page-content .content table th,
.page-content .content table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

.page-content .content table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.page-content .content strong {
    color: #2c3e50;
}

/* Sidebar Styles */
.sidebar .card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.sidebar .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.contact-info p {
    line-height: 1.6;
}

.social-links a,
.share-buttons a {
    text-decoration: none;
}

/* Featured Image */
.featured-image img {
    max-height: 400px;
    width: 100%;
    object-fit: cover;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header .col-md-4 {
        margin-top: 1rem;
        text-align: center !important;
    }
    
    .page-content .content h1 {
        font-size: 2rem;
    }
    
    .page-content .content h2 {
        font-size: 1.5rem;
    }
    
    .share-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
@endpush
