@extends('layouts.admin')

@section('title', 'Kelola Program Studi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                Kelola Program Studi
                            </h5>
                            <small class="text-muted">Kelola data program studi di kampus</small>
                        </div>
                        <a href="{{ route('admin.study-programs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Program Studi
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <!-- Filter & Search -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" action="{{ route('admin.study-programs.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Cari program studi..." value="{{ request('search') }}">
                                    </div>
                                    
                                   
                                    
                                    <div class="col-md-2">
                                        <select name="degree" class="form-select">
                                            <option value="">Semua Jenjang</option>
                                            @foreach($degrees as $degree)
                                                <option value="{{ $degree }}" 
                                                        {{ request('degree') == $degree ? 'selected' : '' }}>
                                                    {{ $degree }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <select name="status" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-outline-primary">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                            @if(request()->hasAny(['search', 'degree', 'status']))
                                                <a href="{{ route('admin.study-programs.index') }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i> Reset
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <small class="text-muted">
                                Menampilkan {{ $studyPrograms->firstItem() ?? 0 }} - {{ $studyPrograms->lastItem() ?? 0 }} 
                                dari {{ $studyPrograms->total() }} program studi
                            </small>
                        </div>
                    </div>
                    
                    <!-- Study Programs Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;">
                                        <i class="fas fa-sort text-muted" title="Drag untuk mengurutkan"></i>
                                    </th>
                                    <th>Program Studi</th>
                                    <th>Kode</th>
                                    <th>Jenjang</th>
                                    <th>Akreditasi</th>
                                    <th>Mahasiswa</th>
                                    <th>Dosen</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-table">
                                @forelse($studyPrograms as $program)
                                    <tr data-id="{{ $program->id }}">
                                        <td>
                                            <i class="fas fa-grip-vertical text-muted handle" style="cursor: move;"></i>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-medium">{{ $program->name }}</div>
                                                @if($program->description)
                                                    <small class="text-muted">{{ Str::limit($program->description, 60) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($program->code)
                                                <span class="badge bg-info">{{ $program->code }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $program->degree }}</span>
                                        </td>
                                        <td>
                                            @if($program->accreditation)
                                                <span class="badge bg-success">{{ $program->accreditation }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $program->students_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $program->lecturers_count }}</span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.study-programs.toggle-status', $program) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-toggle {{ $program->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    <i class="fas {{ $program->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                    {{ $program->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.study-programs.show', $program) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.study-programs.edit', $program) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.study-programs.destroy', $program) }}" 
                                                      class="d-inline delete-form" data-program-name="{{ $program->name }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn" 
                                                            title="Hapus" data-program-name="{{ $program->name }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="fas fa-graduation-cap fa-2x text-muted mb-2"></i>
                                            <div class="text-muted">
                                                @if(request()->hasAny(['search', 'degree', 'status']))
                                                    Tidak ada program studi yang sesuai dengan filter
                                                @else
                                                    Belum ada data program studi
                                                @endif
                                            </div>
                                            @if(!request()->hasAny(['search', 'degree', 'status']))
                                                <a href="{{ route('admin.study-programs.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fas fa-plus me-1"></i>Tambah Program Studi Pertama
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($studyPrograms->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $studyPrograms->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.btn-toggle {
    border: none;
    transition: all 0.3s ease;
}
.handle {
    cursor: move !important;
}
.sortable-ghost {
    opacity: 0.5;
}
.delete-btn:hover {
    background-color: #dc3545 !important;
    color: white !important;
    transform: scale(1.05);
    transition: all 0.2s ease;
}
.btn-group .btn {
    transition: all 0.2s ease;
}
.btn-group .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable
    const table = document.getElementById('sortable-table');
    if (table) {
        const sortable = Sortable.create(table, {
            handle: '.handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                // Update sort order
                const items = [];
                const rows = table.querySelectorAll('tr[data-id]');
                rows.forEach((row, index) => {
                    items.push({
                        id: row.dataset.id,
                        sort_order: index
                    });
                });
                
                // Send AJAX request to update order
                fetch('{{ route("admin.study-programs.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order updated successfully');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
    
    // Handle delete confirmation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            e.preventDefault();
            
            const button = e.target.closest('.delete-btn');
            const form = button.closest('.delete-form');
            const programName = button.getAttribute('data-program-name');
            
            if (confirm(`Yakin ingin menghapus program studi "${programName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                // Show loading state
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                // Submit the form
                form.submit();
            }
        }
    });
    
    // Handle toggle status with loading
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-toggle')) {
            const button = e.target.closest('.btn-toggle');
            const originalHtml = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            button.disabled = true;
            
            // Let the form submit naturally, it will reload the page
        }
    });
});
</script>
@endpush
@endsection
