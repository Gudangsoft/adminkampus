@extends('layouts.admin')

@section('title', 'Kelola Sections')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kelola Sections</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sections</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Sections</h5>
                    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Tambah Section
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="sections-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-sections">
                                @foreach($sections as $section)
                                    <tr data-id="{{ $section->id }}">
                                        <td>
                                            <span class="badge bg-secondary">{{ $section->order }}</span>
                                            <i class="bx bx-move-vertical ms-2 text-muted" style="cursor: move;"></i>
                                        </td>
                                        <td>
                                            <strong>{{ $section->title }}</strong>
                                            @if($section->subtitle)
                                                <br><small class="text-muted">{{ $section->subtitle }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($section->type == 'hero') bg-primary
                                                @elseif($section->type == 'content') bg-info
                                                @elseif($section->type == 'feature') bg-success
                                                @elseif($section->type == 'cta') bg-warning
                                                @else bg-secondary @endif">
                                                {{ ucfirst($section->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($section->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($section->image)
                                                <img src="{{ asset('storage/' . $section->image) }}" 
                                                     alt="{{ $section->title }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Action buttons">
                                                <a href="{{ route('admin.sections.edit', $section) }}" 
                                                   class="btn btn-outline-primary"
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top" 
                                                   title="Edit Section">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-info"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#previewModal{{ $section->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Preview Section">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <form action="{{ route('admin.sections.destroy', $section) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus section ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="Hapus Section">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
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
</div>

<!-- Preview Modals -->
@foreach($sections as $section)
<div class="modal fade" id="previewModal{{ $section->id }}" tabindex="-1" aria-labelledby="previewModalLabel{{ $section->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel{{ $section->id }}">
                    <i class="fas fa-eye me-2"></i>Preview: {{ $section->title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6><strong>Title:</strong> {{ $section->title }}</h6>
                        @if($section->subtitle)
                            <h6><strong>Subtitle:</strong> {{ $section->subtitle }}</h6>
                        @endif
                        @if($section->content)
                            <p><strong>Content:</strong></p>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($section->content)) !!}
                            </div>
                        @endif
                        @if($section->link && $section->link_text)
                            <p class="mt-3"><strong>Button:</strong> 
                                <a href="{{ $section->link }}" class="btn btn-sm btn-primary" target="_blank">
                                    @if($section->icon)
                                        <i class="{{ $section->icon }} me-1"></i>
                                    @endif
                                    {{ $section->link_text }}
                                </a>
                            </p>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <strong>Details</strong>
                            </div>
                            <div class="card-body">
                                <p><strong>Type:</strong> 
                                    <span class="badge 
                                        @if($section->type == 'hero') bg-primary
                                        @elseif($section->type == 'content') bg-info
                                        @elseif($section->type == 'feature') bg-success
                                        @elseif($section->type == 'cta') bg-warning
                                        @else bg-secondary @endif">
                                        {{ ucfirst($section->type) }}
                                    </span>
                                </p>
                                <p><strong>Status:</strong> 
                                    @if($section->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </p>
                                <p><strong>Order:</strong> {{ $section->order }}</p>
                                @if($section->background_color)
                                    <p><strong>Background:</strong> 
                                        <span class="badge" style="background-color: {{ $section->background_color }}; color: {{ $section->text_color ?? '#000000' }};">
                                            {{ $section->background_color }}
                                        </span>
                                    </p>
                                @endif
                                @if($section->image)
                                    <p><strong>Image:</strong></p>
                                    <img src="{{ asset('storage/' . $section->image) }}" 
                                         alt="{{ $section->title }}" 
                                         class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>Edit Section
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize sortable
    const sortable = new Sortable(document.getElementById('sortable-sections'), {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.bx-move-vertical',
        onEnd: function(evt) {
            const sections = Array.from(evt.to.children).map(tr => tr.dataset.id);
            
            fetch('{{ route("admin.sections.update-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sections: sections })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update order badges
                    sections.forEach((id, index) => {
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        const badge = row.querySelector('.badge.bg-secondary');
                        badge.textContent = index + 1;
                    });
                    
                    // Show success toast
                    showToast('Order updated successfully!', 'success');
                } else {
                    showToast('Failed to update order', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to update order', 'error');
            });
        }
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '1055';
        document.body.appendChild(container);
        return container;
    }
});
</script>

<style>
.sortable-ghost {
    opacity: 0.4;
}

.btn-group-sm .btn {
    padding: 0.375rem 0.75rem;
    margin-right: 2px;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.btn-group-sm .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.table td {
    vertical-align: middle;
}

.img-thumbnail {
    border: 2px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

/* Action buttons styling */
.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.btn-outline-info:hover {
    background-color: #0dcaf0;
    border-color: #0dcaf0;
    color: white;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

/* Modal improvements */
.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modal-header .btn-close {
    filter: invert(1);
}

/* Improved table styling */
.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Better spacing for action buttons */
.btn-group-sm {
    gap: 2px;
}
</style>
@endpush
