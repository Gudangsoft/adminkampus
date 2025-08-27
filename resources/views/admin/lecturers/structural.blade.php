@extends('layouts.admin')

@section('title', 'Dosen dengan Jabatan Struktural')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dosen dengan Jabatan Struktural</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.lecturers.index') }}">Dosen</a></li>
                        <li class="breadcrumb-item active">Jabatan Struktural</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Jabatan</p>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-user-check font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Aktif</p>
                            <h4 class="mb-0 text-success">{{ $stats['active'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                <span class="avatar-title">
                                    <i class="bx bx-check-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Akan Datang</p>
                            <h4 class="mb-0 text-warning">{{ $stats['upcoming'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                <span class="avatar-title">
                                    <i class="bx bx-time-five font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Berakhir</p>
                            <h4 class="mb-0 text-danger">{{ $stats['expired'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                <span class="avatar-title">
                                    <i class="bx bx-x-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Daftar Dosen dengan Jabatan Struktural</h4>
                            <p class="card-title-desc">Kelola dan monitor jabatan struktural dosen</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline-primary">
                                <i class="bx bx-list-ul"></i> Semua Dosen
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.lecturers.structural') }}" class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Cari</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Nama, NIDN, atau Jabatan..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jabatan Struktural</label>
                            <select name="structural_position" class="form-select">
                                <option value="">Semua Jabatan</option>
                                @foreach($structuralPositions as $id => $name)
                                    <option value="{{ $id }}" {{ request('structural_position') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $key => $value)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Berakhir</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-search-alt"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(request()->hasAny(['search', 'structural_position', 'category', 'status']))
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">
                                Menampilkan {{ $lecturers->count() }} dari {{ $lecturers->total() }} hasil
                            </span>
                            <a href="{{ route('admin.lecturers.structural') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bx bx-x"></i> Reset Filter
                            </a>
                        </div>
                    @endif

                    <!-- Lecturers Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless table-centered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama & NIDN</th>
                                    <th>Jabatan Struktural</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lecturers as $lecturer)
                                <tr>
                                    <td>
                                        <div class="avatar-sm">
                                            @if($lecturer->photo)
                                                <img src="{{ $lecturer->photo_url }}" alt="{{ $lecturer->name }}" 
                                                     class="img-thumbnail rounded-circle">
                                            @else
                                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                    <span class="text-white">{{ substr($lecturer->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h5 class="font-size-14 mb-1">{{ $lecturer->full_name }}</h5>
                                            <p class="text-muted mb-0">
                                                @if($lecturer->nidn)
                                                    NIDN: {{ $lecturer->nidn }}
                                                @else
                                                    <span class="text-muted">NIDN belum diisi</span>
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h5 class="font-size-14 mb-1">{{ $lecturer->structuralPosition->name ?? 'Tidak Ada' }}</h5>
                                            @if($lecturer->structuralPosition)
                                                <span class="badge badge-soft-info">{{ $lecturer->structuralPosition->category }}</span>
                                            @endif
                                            @if($lecturer->structural_description)
                                                <p class="text-muted mb-0 mt-1 small">{{ Str::limit($lecturer->structural_description, 50) }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            @if($lecturer->structural_start_date)
                                                <small>Mulai: {{ $lecturer->structural_start_date->format('d/m/Y') }}</small><br>
                                            @endif
                                            @if($lecturer->structural_end_date)
                                                <small>Selesai: {{ $lecturer->structural_end_date->format('d/m/Y') }}</small>
                                            @else
                                                <small class="text-info">Tidak terbatas</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $status = $lecturer->structural_status;
                                            $badgeClass = [
                                                'active' => 'badge-soft-success',
                                                'upcoming' => 'badge-soft-warning', 
                                                'expired' => 'badge-soft-danger'
                                            ][$status] ?? 'badge-soft-secondary';
                                            
                                            $statusText = [
                                                'active' => 'Aktif',
                                                'upcoming' => 'Akan Datang',
                                                'expired' => 'Berakhir'
                                            ][$status] ?? 'Tidak Diketahui';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.lecturers.show', $lecturer) }}" 
                                               class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('admin.lecturers.edit', $lecturer) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-search font-size-48"></i>
                                            <p class="mt-2">Tidak ada dosen dengan jabatan struktural ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($lecturers->hasPages())
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    Menampilkan {{ $lecturers->firstItem() }} hingga {{ $lecturers->lastItem() }} 
                                    dari {{ $lecturers->total() }} data
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate">
                                    {{ $lecturers->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.mini-stats-wid .mini-stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-sm img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.table-centered td {
    vertical-align: middle;
}
</style>
@endpush
