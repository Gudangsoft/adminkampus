@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Menu</h1>
        <a href="{{ route('admin.menus.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Menu
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- DataTable -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>URL/Halaman</th>
                            <th>Lokasi</th>
                            <th>Parent</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($menu->icon)
                                        <i class="{{ $menu->icon }} me-2"></i>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $menu->name }}</div>
                                        @if($menu->children->count() > 0)
                                            <small class="text-muted">{{ $menu->children->count() }} submenu</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($menu->page)
                                    <span class="badge bg-info">{{ $menu->page->title }}</span>
                                @elseif($menu->url)
                                    <a href="{{ $menu->url }}" target="_blank" class="text-primary">
                                        {{ $menu->url }}
                                        @if($menu->target === '_blank')
                                            <i class="fas fa-external-link-alt fa-xs"></i>
                                        @endif
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($menu->location) }}</span>
                            </td>
                            <td>
                                @if($menu->parent)
                                    {{ $menu->parent->name }}
                                @else
                                    <span class="text-muted">Root</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $menu->sort_order }}</span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" 
                                           data-id="{{ $menu->id }}" 
                                           {{ $menu->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.menus.show', $menu) }}" 
                                       class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.menus.edit', $menu) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        @foreach($menu->children as $child)
                        <tr class="table-secondary">
                            <td style="padding-left: 2rem;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-arrow-right me-2 text-muted"></i>
                                    @if($child->icon)
                                        <i class="{{ $child->icon }} me-2"></i>
                                    @endif
                                    {{ $child->name }}
                                </div>
                            </td>
                            <td>
                                @if($child->page)
                                    <span class="badge bg-info">{{ $child->page->title }}</span>
                                @elseif($child->url)
                                    <a href="{{ $child->url }}" target="_blank" class="text-primary">
                                        {{ $child->url }}
                                        @if($child->target === '_blank')
                                            <i class="fas fa-external-link-alt fa-xs"></i>
                                        @endif
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($child->location) }}</span>
                            </td>
                            <td>{{ $menu->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $child->sort_order }}</span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" 
                                           data-id="{{ $child->id }}" 
                                           {{ $child->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $child->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.menus.show', $child) }}" 
                                       class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.menus.edit', $child) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $child) }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus submenu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#dataTable').DataTable({
        "pageLength": 25,
        "order": [[ 4, "asc" ]], // Sort by sort_order
        "columnDefs": [
            { "orderable": false, "targets": [5, 6] } // Disable ordering for Status and Action columns
        ]
    });
    
    // Status toggle
    $('.status-toggle').change(function() {
        var menuId = $(this).data('id');
        var isActive = $(this).is(':checked');
        var label = $(this).siblings('label');
        
        $.ajax({
            url: '/admin/menus/' + menuId + '/toggle-status',
            type: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    label.text(response.is_active ? 'Aktif' : 'Nonaktif');
                    
                    // Show success message
                    var alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                               response.message +
                               '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                               '</div>';
                    $('.container-fluid').prepend(alert);
                    
                    // Auto dismiss after 3 seconds
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 3000);
                }
            },
            error: function() {
                // Revert checkbox if error
                $(this).prop('checked', !isActive);
                alert('Terjadi kesalahan saat mengubah status menu');
            }
        });
    });
});
</script>
@endpush

@push('styles')
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush
