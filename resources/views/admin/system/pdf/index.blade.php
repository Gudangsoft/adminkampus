@extends('layouts.admin')

@section('title', 'PDF Generator')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-pdf"></i> PDF Generator
        </h1>
        <div class="text-muted">
            Generate PDF reports for various data
        </div>
    </div>

    <div class="row">
        <!-- News Report -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-newspaper"></i> News Report
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.pdf.news') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="news_date_from" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="news_date_from" name="date_from">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="news_date_to" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="news_date_to" name="date_to">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="news_status" class="form-label">Status</label>
                            <select class="form-select" id="news_status" name="status">
                                <option value="">All Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-download"></i> Generate News PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lecturers Report -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chalkboard-teacher"></i> Lecturers Report
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.pdf.lecturers') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="lecturer_faculty" class="form-label">Faculty</label>
                            <select class="form-select" id="lecturer_faculty" name="faculty_id">
                                <option value="">All Faculties</option>
                                @foreach(\App\Models\Faculty::active()->orderBy('name')->get() as $faculty)
                                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="lecturer_status" class="form-label">Status</label>
                            <select class="form-select" id="lecturer_status" name="status">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-download"></i> Generate Lecturers PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Gallery Report -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-images"></i> Gallery Report
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.pdf.gallery') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gallery_date_from" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="gallery_date_from" name="date_from">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gallery_date_to" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="gallery_date_to" name="date_to">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gallery_category" class="form-label">Category</label>
                            <select class="form-select" id="gallery_category" name="category_id">
                                <option value="">All Categories</option>
                                @foreach(\App\Models\GalleryCategory::orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-download"></i> Generate Gallery PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Users Report -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-users"></i> Users Report
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.pdf.users') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_role" class="form-label">Role</label>
                            <select class="form-select" id="user_role" name="role">
                                <option value="">All Roles</option>
                                <option value="admin">Administrator</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="user_status" class="form-label">Status</label>
                            <select class="form-select" id="user_status" name="status">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-download"></i> Generate Users PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom PDF Generator -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-file-alt"></i> Custom PDF Generator
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.pdf.custom') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="custom_title" class="form-label">Document Title *</label>
                                    <input type="text" class="form-control" id="custom_title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="orientation" class="form-label">Orientation</label>
                                    <select class="form-select" id="orientation" name="orientation">
                                        <option value="portrait">Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="paper_size" class="form-label">Paper Size</label>
                                    <select class="form-select" id="paper_size" name="paper_size">
                                        <option value="a4">A4</option>
                                        <option value="a3">A3</option>
                                        <option value="letter">Letter</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="custom_content" class="form-label">Content *</label>
                            <textarea class="form-control" id="custom_content" name="content" rows="10" required 
                                      placeholder="Enter your content here. You can use HTML tags for formatting."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-download"></i> Generate Custom PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-set today's date as default for date inputs
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        if (!input.value) {
            input.value = today;
        }
    });
});
</script>
@endpush
