@extends('layouts.admin')

@section('title', 'Kelola Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Slider</h3>
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Slider
                    </a>
                </div>
                <div class="card-body">
                    @if($sliders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="sliders-table">
                            <thead>
                                <tr>
                                    <th width="80px">
                                        <i class="fas fa-sort me-1"></i>Urutan
                                    </th>
                                    <th width="120px">Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th width="100px">Status</th>
                                    <th width="80px">Link</th>
                                    <th width="120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-sliders">
                                @foreach($sliders as $slider)
                                <tr data-id="{{ $slider->id }}">
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-grip-vertical text-muted me-2 drag-handle" style="cursor: move;"></i>
                                            <span class="badge bg-secondary">{{ $slider->sort_order }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($slider->image)
                                            <img src="{{ asset('storage/' . $slider->image) }}" 
                                                 alt="{{ $slider->title }}" 
                                                 class="img-thumbnail"
                                                 style="max-width: 100px; max-height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light p-3 text-center" style="width: 100px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $slider->title }}</strong>
                                        @if($slider->button_text)
                                            <br><small class="text-muted">
                                                <i class="fas fa-mouse-pointer me-1"></i>{{ $slider->button_text }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Str::limit($slider->description, 80) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.sliders.toggle-active', $slider) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $slider->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                @if($slider->is_active)
                                                    <i class="fas fa-eye me-1"></i>Aktif
                                                @else
                                                    <i class="fas fa-eye-slash me-1"></i>Nonaktif
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        @if($slider->link)
                                            <a href="{{ $slider->link }}" 
                                               target="{{ $slider->link_target }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="Buka Link">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sliders.show', $slider) }}" 
                                               class="btn btn-sm btn-info"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" 
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.sliders.destroy', $slider) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus">
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

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $sliders->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-images text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-muted">Belum ada slider</h4>
                        <p class="text-muted">Tambahkan slider pertama untuk mulai menampilkan konten di homepage.</p>
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah Slider Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make table sortable
    const sortableElement = document.getElementById('sortable-sliders');
    if (sortableElement) {
        new Sortable(sortableElement, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                updateSliderOrder();
            }
        });
    }

    function updateSliderOrder() {
        const rows = document.querySelectorAll('#sortable-sliders tr');
        const items = [];
        
        rows.forEach((row, index) => {
            items.push({
                id: row.dataset.id,
                sort_order: index + 1
            });
        });

        // Update sort order badges
        rows.forEach((row, index) => {
            const badge = row.querySelector('.badge');
            if (badge) {
                badge.textContent = index + 1;
            }
        });

        // Send AJAX request to update order
        fetch('{{ route("admin.sliders.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat mengupdate urutan slider.');
        });
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto dismiss after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
});
</script>
@endpush

@push('styles')
<style>
.drag-handle {
    cursor: move;
}

.sortable-chosen {
    background-color: #f8f9fa;
}

.table tbody tr:hover {
    background-color: rgba(0,0,0,.05);
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}
</style>
@endpush
@endsection
