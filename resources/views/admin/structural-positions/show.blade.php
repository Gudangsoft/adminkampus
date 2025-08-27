@extends('layouts.admin')

@section('title', 'Detail Jabatan Struktural - ' . $structuralPosition->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-user-tie me-2"></i>Detail Jabatan Struktural
            </h1>
            <p class="text-muted">Informasi lengkap jabatan struktural: {{ $structuralPosition->name }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.structural-positions.edit', $structuralPosition) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.structural-positions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Information -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Jabatan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama Jabatan</strong></td>
                                    <td>: {{ $structuralPosition->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Slug</strong></td>
                                    <td>: {{ $structuralPosition->slug }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori</strong></td>
                                    <td>: <span class="badge bg-info">{{ $structuralPosition->category }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Level Hierarki</strong></td>
                                    <td>: 
                                        <span class="badge 
                                            @if($structuralPosition->level <= 2) bg-danger
                                            @elseif($structuralPosition->level <= 4) bg-warning text-dark
                                            @else bg-secondary
                                            @endif">
                                            Level {{ $structuralPosition->level }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Urutan Tampil</strong></td>
                                    <td>: {{ $structuralPosition->sort_order }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: 
                                        <span class="badge {{ $structuralPosition->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $structuralPosition->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat</strong></td>
                                    <td>: {{ $structuralPosition->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diperbarui</strong></td>
                                    <td>: {{ $structuralPosition->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($structuralPosition->description)
                        <div class="mt-3">
                            <h6><strong>Deskripsi:</strong></h6>
                            <div class="bg-light p-3 rounded">
                                {{ $structuralPosition->description }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lecturers with this position -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Dosen dengan Jabatan Ini
                        <span class="badge bg-primary ms-2">{{ $structuralPosition->lecturers_count ?? 0 }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($lecturers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nama Dosen</th>
                                        <th>NIDN</th>
                                        <th>Periode Jabatan</th>
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
                                                     style="width: 40px; height: 40px; object-fit: cover;">
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
                                                @if($lecturer->structural_start_date || $lecturer->structural_end_date)
                                                    <small>
                                                        {{ $lecturer->structural_start_date ? $lecturer->structural_start_date->format('d/m/Y') : '-' }}
                                                        s/d
                                                        {{ $lecturer->structural_end_date ? $lecturer->structural_end_date->format('d/m/Y') : 'Sekarang' }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $lecturer->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $lecturer->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.lecturers.show', $lecturer) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($structuralPosition->lecturers()->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.lecturers.index', ['structural_position' => $structuralPosition->name]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-users me-1"></i>Lihat Semua Dosen ({{ $structuralPosition->lecturers()->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Belum ada dosen yang menggunakan jabatan struktural ini.</p>
                            <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-1"></i>Kelola Dosen
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.structural-positions.edit', $structuralPosition) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit Jabatan
                        </a>
                        
                        <form action="{{ route('admin.structural-positions.toggle-status', $structuralPosition) }}" 
                              method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="btn {{ $structuralPosition->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }} w-100">
                                <i class="fas {{ $structuralPosition->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} me-1"></i>
                                {{ $structuralPosition->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        
                        @if($structuralPosition->lecturers()->count() == 0)
                            <form action="{{ route('admin.structural-positions.destroy', $structuralPosition) }}" 
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-outline-danger w-100"
                                        onclick="return confirm('Yakin ingin menghapus jabatan struktural ini?')">
                                    <i class="fas fa-trash me-1"></i>Hapus Jabatan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">{{ $structuralPosition->lecturers_count ?? 0 }}</h4>
                                <small class="text-muted">Total Dosen</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-0">{{ $structuralPosition->level }}</h4>
                            <small class="text-muted">Level Hierarki</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
