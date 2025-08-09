@extends('layouts.admin')

@section('title', 'Kelola Dosen')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kelola Dosen</h1>
        <a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Dosen
        </a>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.lecturers.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Dosen</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nama, NIDN, atau email...">
                </div>
                <div class="col-md-3">
                    <label for="faculty" class="form-label">Fakultas</label>
                    <select class="form-select" id="faculty" name="faculty">
                        <option value="">Semua Fakultas</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}" 
                                    {{ request('faculty') == $faculty->id ? 'selected' : '' }}>
                                {{ $faculty->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="position" class="form-label">Jabatan</label>
                    <select class="form-select" id="position" name="position">
                        <option value="">Semua Jabatan</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}" 
                                    {{ request('position') == $position ? 'selected' : '' }}>
                                {{ $position }}
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
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($lecturers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Foto</th>
                                <th>Nama Dosen</th>
                                <th>NIDN</th>
                                <th>Fakultas</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lecturers as $lecturer)
                                <tr>
                                    <td>
                                        <img src="{{ $lecturer->photo_url }}" 
                                             alt="{{ $lecturer->name }}" 
                                             class="rounded-circle" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $lecturer->full_name }}</strong>
                                            @if($lecturer->education_background)
                                                <br><small class="text-muted">{{ $lecturer->education_background }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $lecturer->nidn }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $lecturer->faculty->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($lecturer->position == 'Guru Besar') bg-danger
                                            @elseif($lecturer->position == 'Lektor Kepala') bg-warning text-dark
                                            @elseif($lecturer->position == 'Lektor') bg-success
                                            @else bg-secondary
                                            @endif">
                                            {{ $lecturer->position }}
                                        </span>
                                    </td>
                                    <td>{{ $lecturer->email ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('admin.lecturers.toggle-status', $lecturer) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $lecturer->is_active ? 'btn-success' : 'btn-secondary' }}"
                                                    title="{{ $lecturer->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas {{ $lecturer->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.lecturers.show', $lecturer) }}" 
                                               class="btn btn-sm btn-outline-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.lecturers.edit', $lecturer) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.lecturers.destroy', $lecturer) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus dosen ini?')">
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
                @if($lecturers->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $lecturers->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada dosen ditemukan</h5>
                    <p class="text-muted">Belum ada dosen yang ditambahkan atau sesuai kriteria pencarian.</p>
                    <a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Dosen Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
