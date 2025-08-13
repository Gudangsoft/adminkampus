@extends('admin.layouts.app')

@section('title', 'Database Backup Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">💾 Database Backup Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Backups</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Backups</h5>
                            <h3 class="my-2 py-1">{{ $stats['total_backups'] }}</h3>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-database avatar-title font-20 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Size</h5>
                            <h3 class="my-2 py-1">{{ $stats['total_size'] }}</h3>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-hdd avatar-title font-20 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Latest Backup</h5>
                            <h6 class="my-2 py-1">
                                @if($stats['latest_backup'])
                                    {{ $stats['latest_backup']['created_at']->format('M d, Y') }}
                                @else
                                    No backups
                                @endif
                            </h6>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-clock avatar-title font-20 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Database</h5>
                            <h6 class="my-2 py-1">{{ config('database.connections.mysql.database') }}</h6>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-server avatar-title font-20 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Backup Form -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create New Backup
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.backups.create') }}" method="POST" id="backupForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="compress" id="compress" checked>
                                        <label class="form-check-label" for="compress">
                                            <strong>Compress backup file</strong>
                                            <br><small class="text-muted">Reduces file size significantly</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg" id="createBackupBtn">
                                        <i class="fas fa-download me-2"></i>
                                        Create Backup Now
                                    </button>
                                    <div class="spinner-border spinner-border-sm ms-2 d-none" role="status" id="backupSpinner">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Backups List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Backup Files
                        </h5>
                        @if(count($backups) > 0)
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="cleanupOldBackups()">
                                    <i class="fas fa-trash me-1"></i> Cleanup Old
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="location.reload()">
                                    <i class="fas fa-sync me-1"></i> Refresh
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(count($backups) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Filename</th>
                                        <th>Size</th>
                                        <th>Created</th>
                                        <th>Age</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($backups as $backup)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-archive text-primary me-2"></i>
                                                <div>
                                                    <div class="fw-bold">{{ $backup['name'] }}</div>
                                                    @if(str_contains($backup['name'], '.gz'))
                                                        <small class="text-success">
                                                            <i class="fas fa-compress-arrows-alt me-1"></i>Compressed
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $backup['size'] }}</span>
                                        </td>
                                        <td>{{ $backup['created_at']->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="text-muted">{{ $backup['created_at']->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.backups.download', $backup['name']) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteBackup('{{ $backup['name'] }}')"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-database text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted">No Backups Found</h4>
                            <p class="text-muted">
                                Create your first backup to protect your data.
                            </p>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('backupForm').submit()">
                                <i class="fas fa-plus me-1"></i> Create First Backup
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this backup file?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteBackup(filename) {
    document.getElementById('deleteForm').action = '{{ route("admin.backups.destroy", ":filename") }}'.replace(':filename', filename);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function cleanupOldBackups() {
    if (confirm('This will delete all backup files older than 30 days. Continue?')) {
        // Add cleanup functionality
        alert('Cleanup functionality will be implemented in next update');
    }
}

document.getElementById('backupForm').addEventListener('submit', function() {
    const btn = document.getElementById('createBackupBtn');
    const spinner = document.getElementById('backupSpinner');
    
    btn.disabled = true;
    spinner.classList.remove('d-none');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Backup...';
});
</script>
@endpush

@push('styles')
<style>
.avatar-sm {
    height: 3rem;
    width: 3rem;
}

.avatar-title {
    align-items: center;
    background-color: transparent;
    color: #6c757d;
    display: flex;
    font-weight: 500;
    height: 100%;
    justify-content: center;
    width: 100%;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}
</style>
@endpush
