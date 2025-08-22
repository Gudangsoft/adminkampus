@extends('layouts.frontend')

@section('title', $page->meta_data['title'] ?? $page->title)
@section('meta_description', $page->meta_data['description'] ?? '')
@section('meta_keywords', $page->meta_data['keywords'] ?? '')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold text-primary mb-3">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="lead text-muted">{{ $page->excerpt }}</p>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            @if($page->featured_image)
                <div class="mb-4">
                    <img src="{{ Storage::url($page->featured_image) }}" 
                         alt="{{ $page->title }}" 
                         class="img-fluid rounded shadow">
                </div>
            @endif
            
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Navigation Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Navigasi</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                            <li><a href="{{ route('about') }}" class="text-decoration-none">Tentang Kami</a></li>
                            <li><a href="{{ route('news.index') }}" class="text-decoration-none">Berita</a></li>
                            <li><a href="{{ route('contact') }}" class="text-decoration-none">Kontak</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Related Pages -->
                @if(isset($relatedPages) && $relatedPages->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Halaman Terkait</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach($relatedPages as $relatedPage)
                                <li class="mb-2">
                                    <a href="{{ route('pages.show', $relatedPage->slug) }}" class="text-decoration-none">
                                        {{ $relatedPage->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                
                <!-- Quick Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi</h5>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-0">
                            Halaman ini diperbarui pada: {{ $page->updated_at->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .page-content h1,
    .page-content h2,
    .page-content h3,
    .page-content h4,
    .page-content h5,
    .page-content h6 {
        color: #2c3e50;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    .page-content p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    
    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 1rem 0;
    }
    
    .page-content blockquote {
        border-left: 4px solid #007bff;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 4px;
    }
    
    .page-content ul,
    .page-content ol {
        padding-left: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .page-content li {
        margin-bottom: 0.5rem;
    }
    
    .sidebar .card {
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .sidebar .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    
    .sidebar ul li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f3f4;
    }
    
    .sidebar ul li:last-child {
        border-bottom: none;
    }
    
    .sidebar ul li a:hover {
        color: #007bff !important;
    }
</style>
@endpush
