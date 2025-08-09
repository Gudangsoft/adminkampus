@extends('layouts.admin')

@section('title', 'Manajemen Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Manajemen Pengumuman</h3>
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pengumuman
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Filter and Search -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.announcements.index') }}">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <input type="hidden" name="priority" value="{{ request('priority') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari pengumuman..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.announcements.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="priority" value="{{ request('priority') }}">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.announcements.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <select name="priority" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Prioritas</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Judul</th>
                                    <th width="10%">Prioritas</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Pinned</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="10%">Views</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($announcements->currentPage() - 1) * $announcements->perPage() }}</td>
                                        <td>
                                            <h6 class="mb-1">{{ Str::limit($item->title, 50) }}</h6>
                                            <small class="text-muted">{{ Str::limit($item->excerpt, 80) }}</small>
                                        </td>
                                        <td>
                                            @if($item->priority == 'urgent')
                                                <span class="badge bg-danger">Urgent</span>
                                            @elseif($item->priority == 'high')
                                                <span class="badge bg-warning">Tinggi</span>
                                            @elseif($item->priority == 'medium')
                                                <span class="badge bg-info">Sedang</span>
                                            @else
                                                <span class="badge bg-secondary">Rendah</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 'published')
                                                <span class="badge bg-success">Dipublikasi</span>
                                            @elseif($item->status == 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @else
                                                <span class="badge bg-secondary">Diarsipkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->is_pinned)
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-thumbtack"></i> Ya
                                                </span>
                                            @else
                                                <span class="text-muted">Tidak</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>{{ number_format($item->views) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.announcements.show', $item) }}" 
                                                   class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.announcements.edit', $item) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.announcements.destroy', $item) }}" 
                                                      style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada pengumuman</h5>
                                            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Tambah Pengumuman Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($announcements->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $announcements->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
