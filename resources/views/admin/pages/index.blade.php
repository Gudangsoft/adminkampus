@extends('layouts.admin')

@section('title', 'Manajemen Halaman')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Halaman</h1>
        <a href="{{ route('admin.pages.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Halaman
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Halaman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Di Menu</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                <strong>{{ $page->title }}</strong>
                                @if($page->featured_image)
                                    <br><small class="text-muted"><i class="fas fa-image"></i> Ada gambar</small>
                                @endif
                            </td>
                            <td>
                                <code>{{ $page->slug }}</code>
                                <br>
                                <small>
                                    <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="text-primary">
                                        <i class="fas fa-external-link-alt"></i> Lihat
                                    </a>
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-{{ $page->status === 'published' ? 'success' : 'warning' }}">
                                    {{ $page->status === 'published' ? 'Terbit' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $page->show_in_menu ? 'info' : 'secondary' }}">
                                    {{ $page->show_in_menu ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td>{{ $page->user->name ?? 'Admin' }}</td>
                            <td>{{ $page->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-{{ $page->status === 'published' ? 'secondary' : 'success' }} btn-sm" 
                                            onclick="toggleStatus({{ $page->id }})" title="Toggle Status">
                                        <i class="fas fa-{{ $page->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
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
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $pages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(pageId) {
    fetch(`/admin/pages/${pageId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

// Initialize DataTable
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "order": [[ 5, "desc" ]]
    });
});
</script>
@endpush
