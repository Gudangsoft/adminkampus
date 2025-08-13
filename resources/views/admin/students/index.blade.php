@extends('layouts.admin')

@section('title', 'Kelola Mahasiswa')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kelola Mahasiswa</h1>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Mahasiswa
        </a>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.students.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Mahasiswa</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nama, NIM, atau email...">
                </div>
                <div class="col-md-2">
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
                    <label for="study_program" class="form-label">Program Studi</label>
                    <select class="form-select" id="study_program" name="study_program">
                        <option value="">Semua Prodi</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program->id }}" 
                                    {{ request('study_program') == $program->id ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="entry_year" class="form-label">Angkatan</label>
                    <select class="form-select" id="entry_year" name="entry_year">
                        <option value="">Semua Angkatan</option>
                        @foreach($entryYears as $year)
                            <option value="{{ $year }}" 
                                    {{ request('entry_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
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
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Mahasiswa</h6>
                            <h3 class="mb-0">{{ number_format($students->total()) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Mahasiswa Aktif</h6>
                            <h3 class="mb-0">{{ number_format(\App\Models\Student::where('status', 'active')->count()) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Angkatan Terbaru</h6>
                            <h3 class="mb-0">{{ \App\Models\Student::max('entry_year') ?? '-' }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Program Studi</h6>
                            <h3 class="mb-0">{{ \App\Models\StudyProgram::count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Foto</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Program Studi</th>
                                <th>Angkatan</th>
                                <th>Semester</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <img src="{{ $student->photo_url }}" 
                                             alt="{{ $student->name }}" 
                                             class="rounded-circle" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $student->student_id }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $student->name }}</strong>
                                            @if($student->gpa)
                                                <br><small class="text-muted">IPK: {{ number_format($student->gpa, 2) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge bg-info text-dark">{{ $student->studyProgram->name }}</span>
                                            <br><small class="text-muted">{{ $student->studyProgram->faculty->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $student->entry_year }}</span>
                                    </td>
                                    <td>
                                        {{ $student->semester ? 'Semester ' . $student->semester : '-' }}
                                    </td>
                                    <td>{{ $student->email ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('admin.students.toggle-status', $student) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $student->status === 'active' ? 'btn-success' : 'btn-secondary' }}"
                                                    title="{{ $student->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas {{ $student->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.students.show', $student) }}" 
                                               class="btn btn-sm btn-outline-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.students.edit', $student) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.students.destroy', $student) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">
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
                @if($students->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $students->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada mahasiswa ditemukan</h5>
                    <p class="text-muted">Belum ada mahasiswa yang ditambahkan atau sesuai kriteria pencarian.</p>
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Mahasiswa Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
