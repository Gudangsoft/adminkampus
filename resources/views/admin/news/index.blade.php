@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Berita</h5>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Berita
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filter dan Search -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('admin.news.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Cari berita..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.news.index') }}">
                                <select name="category" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.news.index') }}">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Gambar</th>
                                    <th width="30%">Judul</th>
                                    <th width="15%">Kategori</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="10%">Views</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($news->currentPage() - 1) * $news->perPage() }}</td>
                                        <td>
                                            @if($item->featured_image)
                                                <img src="{{ $item->featured_image_url }}" class="img-thumbnail" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="mb-1">{{ Str::limit($item->title, 50) }}</h6>
                                            <small class="text-muted">{{ Str::limit($item->excerpt, 80) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->category->name }}</span>
                                        </td>
                                        <td>
                                            @if($item->status == 'published')
                                                <span class="badge bg-success">Dipublikasi</span>
                                            @else
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }}</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-eye text-muted"></i> {{ number_format($item->views_count) }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.news.show', $item) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.news.edit', $item) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.news.destroy', $item) }}" 
                                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data berita</p>
                                            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Tambah Berita Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($news->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $news->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
