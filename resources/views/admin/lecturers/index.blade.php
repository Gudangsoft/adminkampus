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
                <div class="col-md-3">
                    <label for="structural_position" class="form-label">Jabatan Struktural</label>
                    <select class="form-select" id="structural_position" name="structural_position">
                        <option value="">Semua Jabatan Struktural</option>
                        @foreach($structuralPositions as $key => $structuralPosition)
                            <option value="{{ $key }}" 
                                    {{ request('structural_position') == $key ? 'selected' : '' }}>
                                {{ $structuralPosition }}
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
                                <th>Jabatan Akademik</th>
                                <th>Jabatan Struktural</th>
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
                                        <span class="badge 
                                            @if($lecturer->position == 'Guru Besar') bg-danger
                                            @elseif($lecturer->position == 'Lektor Kepala') bg-warning text-dark
                                            @elseif($lecturer->position == 'Lektor') bg-success
                                            @else bg-secondary
                                            @endif">
                                            {{ $lecturer->position }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($lecturer->structuralPosition)
                                            <span class="badge bg-info">
                                                {{ $lecturer->structuralPosition->name }}
                                            </span>
                                            @if($lecturer->structural_status)
                                                <br>
                                                <small class="badge 
                                                    @if($lecturer->structural_status == 'active') bg-success
                                                    @elseif($lecturer->structural_status == 'upcoming') bg-warning text-dark
                                                    @else bg-secondary
                                                    @endif">
                                                    @if($lecturer->structural_status == 'active') Aktif
                                                    @elseif($lecturer->structural_status == 'upcoming') Akan Datang
                                                    @else Berakhir
                                                    @endif
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
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
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary" 
                                                    title="Kelola Jabatan Struktural"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#structuralModal{{ $lecturer->id }}">
                                                <i class="fas fa-user-tie"></i>
                                            </button>
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

<!-- Structural Position Modals -->
@foreach($lecturers as $lecturer)
<div class="modal fade" id="structuralModal{{ $lecturer->id }}" tabindex="-1" aria-labelledby="structuralModalLabel{{ $lecturer->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.lecturers.update-structural', $lecturer) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="structuralModalLabel{{ $lecturer->id }}">
                        <i class="fas fa-user-tie me-2"></i>Kelola Jabatan Struktural
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Dosen:</strong> {{ $lecturer->full_name }}
                    </div>
                    
                    <div class="mb-3">
                        <label for="structural_position{{ $lecturer->id }}" class="form-label">Jabatan Struktural</label>
                        <select class="form-select" id="structural_position{{ $lecturer->id }}" name="structural_position_id">
                            <option value="">Tidak Ada Jabatan Struktural</option>
                            @foreach($structuralPositions as $key => $position)
                                <option value="{{ $key }}" 
                                        {{ $lecturer->structural_position_id == $key ? 'selected' : '' }}>
                                    {{ $position }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="structural_description{{ $lecturer->id }}" class="form-label">Deskripsi Jabatan</label>
                        <textarea class="form-control" 
                                  id="structural_description{{ $lecturer->id }}" 
                                  name="structural_description" 
                                  rows="3"
                                  placeholder="Deskripsi tugas dan tanggung jawab">{{ $lecturer->structural_description }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="structural_start_date{{ $lecturer->id }}" class="form-label">Tanggal Mulai</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="structural_start_date{{ $lecturer->id }}" 
                                   name="structural_start_date"
                                   value="{{ $lecturer->structural_start_date ? $lecturer->structural_start_date->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="structural_end_date{{ $lecturer->id }}" class="form-label">Tanggal Berakhir</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="structural_end_date{{ $lecturer->id }}" 
                                   name="structural_end_date"
                                   value="{{ $lecturer->structural_end_date ? $lecturer->structural_end_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
