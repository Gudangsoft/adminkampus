@extends('layouts.frontend')

@section('title', $page->meta_data['title'] ?? $page->title)
@section('meta_description', $page->meta_data['description'] ?? '')
@section('meta_keywords', $page->meta_data['keywords'] ?? '')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-4 fw-bold mb-3">{{ $page->title }}</h1>
                    @if($page->excerpt)
                        <p class="lead">{{ $page->excerpt }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    @if($page->featured_image)
                        <div class="mb-4 text-center">
                            <img src="{{ Storage::url($page->featured_image) }}" 
                                 alt="{{ $page->title }}" 
                                 class="img-fluid rounded shadow">
                        </div>
                    @endif
                    
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
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
    
    .page-content table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
    }
    
    .page-content table th,
    .page-content table td {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        text-align: left;
    }
    
    .page-content table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .page-content table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
</style>
@endpush
