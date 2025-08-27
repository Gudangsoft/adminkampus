@extends('layouts.admin')

@section('title', 'Kelola Jabatan Struktural')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-user-tie me-2"></i>Kelola Jabatan Struktural
            </h1>
            <p class="text-muted">Kelola daftar jabatan struktural yang tersedia di institusi</p>
        </div>
        <a href="{{ route('admin.structural-positions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Jabatan Struktural
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.structural-positions.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Pencarian</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nama jabatan, deskripsi, atau kategori...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $category)
                            <option value="{{ $key }}" 
                                    {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request()->hasAny(['search', 'category', 'status']))
                            <a href="{{ route('admin.structural-positions.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($structuralPositions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Kategori</th>
                                <th>Level</th>
                                <th>Jumlah Dosen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($structuralPositions as $position)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $position->name }}</strong>
                                            @if($position->description)
                                                <br><small class="text-muted">{{ Str::limit($position->description, 60) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $position->category }}</span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($position->level <= 2) bg-danger
                                            @elseif($position->level <= 4) bg-warning text-dark
                                            @else bg-secondary
                                            @endif">
                                            Level {{ $position->level }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $position->lecturers_count ?? 0 }} Dosen
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.structural-positions.toggle-status', $position) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $position->is_active ? 'btn-success' : 'btn-secondary' }}"
                                                    title="{{ $position->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas {{ $position->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.structural-positions.show', $position) }}" 
                                               class="btn btn-sm btn-outline-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.structural-positions.edit', $position) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.structural-positions.destroy', $position) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus jabatan struktural ini?')">
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
                @if($structuralPositions->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $structuralPositions->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada jabatan struktural ditemukan</h5>
                    <p class="text-muted">Belum ada jabatan struktural yang ditambahkan atau sesuai kriteria pencarian.</p>
                    <a href="{{ route('admin.structural-positions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Jabatan Struktural Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
