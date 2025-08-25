@extends('layouts.admin')

@section('title', 'Kelola Mahasiswa')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users me-2"></i>Kelola Mahasiswa
        </h1>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Mahasiswa
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Mahasiswa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($students->total()) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Mahasiswa Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($students->where('is_active', true)->count()) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Program Studi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $studyPrograms->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Mahasiswa Baru ({{ date('Y') }})
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($students->where('entry_year', date('Y'))->count()) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa</h6>
        </div>
        <div class="card-body">
            <!-- Filter Section -->
            <form method="GET" action="{{ route('admin.students.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Cari</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama, NIM, atau Email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="study_program">Program Studi</label>
                            <select class="form-control" id="study_program" name="study_program">
                                <option value="">Semua Program Studi</option>
                                @foreach($studyPrograms as $program)
                                    <option value="{{ $program->id }}" 
                                            {{ request('study_program') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="entry_year">Tahun Masuk</label>
                            <select class="form-control" id="entry_year" name="entry_year">
                                <option value="">Semua Tahun</option>
                                @foreach($entryYears as $year)
                                    <option value="{{ $year }}" 
                                            {{ request('entry_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Tahun Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->nim }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->studyProgram->name ?? '-' }}</td>
                                <td>{{ $student->entry_year }}</td>
                                <td>
                                    @if($student->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-500">Belum ada data mahasiswa</h5>
                                    <p class="text-gray-400">Silakan tambah mahasiswa baru untuk memulai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            