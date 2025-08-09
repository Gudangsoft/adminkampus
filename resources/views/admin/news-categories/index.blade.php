@extends('layouts.admin')

@section('title', 'Kategori Berita')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Data Kategori Berita</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Nama Kategori</th>
                                    <th width="25%">Slug</th>
                                    <th width="15%">Jumlah Berita</th>
                                    <th width="15%">Tanggal Dibuat</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <h6 class="mb-1">{{ $category->name }}</h6>
                                            @if($category->description)
                                                <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <code>{{ $category->slug }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $category->news_count }} berita</span>
                                        </td>
                                        <td>
                                            <small>{{ $category->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.news-categories.edit', $category) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($category->news_count == 0)
                                                    <form method="POST" action="{{ route('admin.news-categories.destroy', $category) }}" 
                                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada kategori berita</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ isset($editCategory) ? 'Edit' : 'Tambah' }} Kategori</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($editCategory) ? route('admin.news-categories.update', $editCategory) : route('admin.news-categories.store') }}">
                        @csrf
                        @if(isset($editCategory))
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $editCategory->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $editCategory->slug ?? '') }}">
                            <div class="form-text">Biarkan kosong untuk generate otomatis dari nama</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $editCategory->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($editCategory) ? 'Update' : 'Simpan' }}
                            </button>
                            @if(isset($editCategory))
                                <a href="{{ route('admin.news-categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Statistik Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Kategori:</span>
                            <span class="font-weight-bold">{{ $categories->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Kategori Terisi:</span>
                            <span class="font-weight-bold">{{ $categories->where('news_count', '>', 0)->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kategori Kosong:</span>
                            <span class="font-weight-bold">{{ $categories->where('news_count', 0)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.manual !== 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });
    
    slugInput.addEventListener('input', function() {
        this.dataset.manual = 'true';
    });
});
</script>
@endsection
