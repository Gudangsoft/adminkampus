@extends('layouts.admin')

@section('title', 'SEO Audit')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">SEO Audit Report</h1>
                <div>
                    <button class="btn btn-primary" onclick="runAudit(false)">
                        <i class="fas fa-search"></i> Run Audit
                    </button>
                    <button class="btn btn-success" onclick="runAudit(true)">
                        <i class="fas fa-tools"></i> Run Audit & Fix
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Controls -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs"></i> Audit Controls
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.seo.audit') }}">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-3">
                                    SEO Audit akan menganalisis semua konten untuk masalah optimasi seperti 
                                    panjang judul, meta description, gambar yang hilang, dan lainnya.
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="submit" name="run_audit" value="1" class="btn btn-outline-primary">
                                    <i class="fas fa-play"></i> Start Basic Audit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($auditResults))
    <!-- Audit Results -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie"></i> Audit Results
                    </h5>
                    <span class="badge bg-{{ $auditResults['total_issues'] > 0 ? 'warning' : 'success' }} fs-6">
                        {{ $auditResults['total_issues'] }} Issues Found
                    </span>
                </div>
                <div class="card-body">
                    @if($auditResults['total_issues'] == 0)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Excellent!</strong> No SEO issues found. Your content is well optimized.
                        </div>
                    @else
                        <!-- Issues Summary -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ count($auditResults['title_issues']) }}</h4>
                                        <p class="mb-0">Title Issues</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ count($auditResults['meta_issues']) }}</h4>
                                        <p class="mb-0">Meta Issues</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ count($auditResults['image_issues']) }}</h4>
                                        <p class="mb-0">Image Issues</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Issues -->
                        @if(count($auditResults['title_issues']) > 0)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-heading text-warning"></i> Title Length Issues
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Length</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auditResults['title_issues'] as $issue)
                                            <tr>
                                                <td><span class="badge bg-primary">{{ $issue['type'] }}</span></td>
                                                <td>{{ Str::limit($issue['title'], 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $issue['length'] < 30 ? 'danger' : 'warning' }}">
                                                        {{ $issue['length'] }} chars
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ $issue['url'] }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(count($auditResults['meta_issues']) > 0)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-tags text-info"></i> Meta Description Issues
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Meta Length</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auditResults['meta_issues'] as $issue)
                                            <tr>
                                                <td><span class="badge bg-primary">{{ $issue['type'] }}</span></td>
                                                <td>{{ Str::limit($issue['title'], 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $issue['meta_length'] == 0 ? 'danger' : 'warning' }}">
                                                        {{ $issue['meta_length'] }} chars
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ $issue['url'] }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(count($auditResults['image_issues']) > 0)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-image text-danger"></i> Missing Featured Images
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auditResults['image_issues'] as $issue)
                                            <tr>
                                                <td><span class="badge bg-primary">{{ $issue['type'] }}</span></td>
                                                <td>{{ Str::limit($issue['title'], 60) }}</td>
                                                <td>
                                                    <a href="{{ $issue['url'] }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Add Image
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- SEO Best Practices -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb"></i> SEO Best Practices
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-heading text-primary"></i> Title Optimization</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success"></i> Keep titles between 30-60 characters</li>
                                <li><i class="fas fa-check text-success"></i> Include target keywords early</li>
                                <li><i class="fas fa-check text-success"></i> Make titles compelling and descriptive</li>
                                <li><i class="fas fa-check text-success"></i> Avoid keyword stuffing</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-tags text-info"></i> Meta Description</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success"></i> Keep between 120-160 characters</li>
                                <li><i class="fas fa-check text-success"></i> Include call-to-action</li>
                                <li><i class="fas fa-check text-success"></i> Summarize content accurately</li>
                                <li><i class="fas fa-check text-success"></i> Make each description unique</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-image text-warning"></i> Images</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success"></i> Always include featured images</li>
                                <li><i class="fas fa-check text-success"></i> Use descriptive alt text</li>
                                <li><i class="fas fa-check text-success"></i> Optimize image file sizes</li>
                                <li><i class="fas fa-check text-success"></i> Use appropriate image formats</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-link text-success"></i> Internal Linking</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success"></i> Link to related content</li>
                                <li><i class="fas fa-check text-success"></i> Use descriptive anchor text</li>
                                <li><i class="fas fa-check text-success"></i> Maintain logical site structure</li>
                                <li><i class="fas fa-check text-success"></i> Check for broken links regularly</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function runAudit(autoFix = false) {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + (autoFix ? 'Running & Fixing...' : 'Running...');
    btn.disabled = true;
    
    const formData = new FormData();
    if (autoFix) {
        formData.append('fix', '1');
    }
    
    fetch('{{ route("admin.seo.run-audit") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Audit Completed',
                text: data.message,
                icon: 'success',
                html: '<pre style="text-align: left; font-size: 12px; max-height: 300px; overflow-y: auto;">' + data.output + '</pre>',
                confirmButtonText: 'Refresh Page'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire('Error', 'Failed to run audit', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Network error occurred', 'error');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
@endpush
@endsection
