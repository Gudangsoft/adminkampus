@extends('layouts.admin')

@section('title', 'Meta Tags Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Meta Tags Management</h1>
                <div>
                    <a href="{{ route('admin.seo.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $newsWithIssues->count() }}</h4>
                            <p class="mb-0">Berita dengan Masalah Title</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $galleryWithIssues->count() }}</h4>
                            <p class="mb-0">Galeri dengan Masalah Title</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-images fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $pagesWithIssues->count() }}</h4>
                            <p class="mb-0">Halaman dengan Masalah Title</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News with Title Issues -->
    @if($newsWithIssues->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-newspaper text-warning"></i> Berita dengan Masalah Title
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Length</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsWithIssues as $news)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($news->title, 60) }}</strong>
                                        @if($news->excerpt)
                                            <br><small class="text-muted">{{ Str::limit($news->excerpt, 80) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ strlen($news->title) < 30 ? 'danger' : 'warning' }}">
                                            {{ strlen($news->title) }} chars
                                        </span>
                                        @if(strlen($news->title) < 30)
                                            <br><small class="text-danger">Too short</small>
                                        @elseif(strlen($news->title) > 60)
                                            <br><small class="text-warning">Too long</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $news->status === 'published' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($news->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $news->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @if($news->status === 'published')
                                            <a href="{{ route('news.show', $news->slug) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Gallery with Title Issues -->
    @if($galleryWithIssues->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-images text-info"></i> Galeri dengan Masalah Title
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Length</th>
                                    <th>Type</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($galleryWithIssues as $gallery)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($gallery->title, 60) }}</strong>
                                        @if($gallery->description)
                                            <br><small class="text-muted">{{ Str::limit($gallery->description, 80) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ strlen($gallery->title) < 30 ? 'danger' : 'warning' }}">
                                            {{ strlen($gallery->title) }} chars
                                        </span>
                                        @if(strlen($gallery->title) < 30)
                                            <br><small class="text-danger">Too short</small>
                                        @elseif(strlen($gallery->title) > 60)
                                            <br><small class="text-warning">Too long</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ ucfirst($gallery->type ?? 'photo') }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $gallery->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('gallery.show', $gallery->slug) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Pages with Title Issues -->
    @if($pagesWithIssues->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt text-danger"></i> Halaman dengan Masalah Title
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Length</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagesWithIssues as $page)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($page->title, 60) }}</strong>
                                        @if($page->excerpt)
                                            <br><small class="text-muted">{{ Str::limit($page->excerpt, 80) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ strlen($page->title) < 30 ? 'danger' : 'warning' }}">
                                            {{ strlen($page->title) }} chars
                                        </span>
                                        @if(strlen($page->title) < 30)
                                            <br><small class="text-danger">Too short</small>
                                        @elseif(strlen($page->title) > 60)
                                            <br><small class="text-warning">Too long</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $page->status === 'published' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($page->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $page->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @if($page->status === 'published')
                                            <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- SEO Guidelines -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> SEO Title Guidelines
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-check"></i> Good Practices</h6>
                            <ul>
                                <li>Keep titles between <strong>30-60 characters</strong></li>
                                <li>Include primary keywords early in the title</li>
                                <li>Make titles descriptive and compelling</li>
                                <li>Avoid keyword stuffing</li>
                                <li>Use unique titles for each page</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger"><i class="fas fa-times"></i> Avoid</h6>
                            <ul>
                                <li>Titles shorter than 30 characters</li>
                                <li>Titles longer than 60 characters</li>
                                <li>Generic titles like "Home" or "Page"</li>
                                <li>Duplicate titles across pages</li>
                                <li>ALL CAPS titles</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <strong>Tip:</strong> Search engines typically display 50-60 characters of a title tag. 
                        If your title is longer, it may get cut off in search results.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
