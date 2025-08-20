@extends('layouts.admin')

@section('title', 'Kelola Fakultas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="fas fa-building me-2 text-primary"></i>
                                Kelola Fakultas
                            </h5>
                            <small class="text-muted">Kelola data fakultas di kampus</small>
                        </div>
                        <a href="{{ route('admin.faculties.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Fakultas
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filter & Search -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('admin.faculties.index') }}" class="d-flex gap-2">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari fakultas..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                
                                <select name="status" class="form-select" style="max-width: 150px;" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                
                                @if(request()->hasAny(['search', 'status']))
                                    <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <small class="text-muted">
                                Total: {{ $faculties->total() }} fakultas
                            </small>
                        </div>
                    </div>
                    
                    <!-- Faculties Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;">
                                        <i class="fas fa-sort text-muted" title="Drag untuk mengurutkan"></i>
                                    </th>
                                    <th>Nama Fakultas</th>
                                    <th>Program Studi</th>
                                    <th>Mahasiswa</th>
                                    <th>Status</th>
                                    <th>Urutan</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-table">
                                @forelse($faculties as $faculty)
                                    <tr data-id="{{ $faculty->id }}">
                                        <td>
                                            <i class="fas fa-grip-vertical text-muted handle" style="cursor: move;"></i>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-medium">{{ $faculty->name }}</div>
                                                @if($faculty->description)
                                                    <small class="text-muted">{{ Str::limit($faculty->description, 80) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $faculty->study_programs_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $faculty->students_count }}</span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.faculties.toggle-status', $faculty) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-toggle {{ $faculty->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    <i class="fas {{ $faculty->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                    {{ $faculty->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $faculty->sort_order }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.faculties.show', $faculty) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.faculties.edit', $faculty) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.faculties.destroy', $faculty) }}" 
                                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus fakultas ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-building fa-2x text-muted mb-2"></i>
                                            <div class="text-muted">
                                                @if(request()->hasAny(['search', 'status']))
                                                    Tidak ada fakultas yang sesuai dengan filter
                                                @else
                                                    Belum ada data fakultas
                                                @endif
                                            </div>
                                            @if(!request()->hasAny(['search', 'status']))
                                                <a href="{{ route('admin.faculties.create') }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fas fa-plus me-1"></i>Tambah Fakultas Pertama
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($faculties->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $faculties->links() }}
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
                fetch('{{ route("admin.faculties.update-order") }}', {
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
                        // Update sort order badges
                        rows.forEach((row, index) => {
                            const badge = row.querySelector('td:nth-child(6) .badge');
                            if (badge) badge.textContent = index;
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
});
</script>
@endpush
@endsection
