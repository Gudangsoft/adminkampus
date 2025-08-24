@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Mahasiswa</a></li>
                        <li class="breadcrumb-item active">{{ $student->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Detail Mahasiswa</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Student Profile -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" 
                             class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 class="card-title mb-1">{{ $student->name }}</h5>
                    <p class="card-text text-muted mb-2">{{ $student->nim }}</p>
                    <span class="badge bg-{{ $student->is_active ? 'success' : 'danger' }} mb-3">
                        {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    
                    @if($student->studyProgram)
                        <div class="text-start">
                            <div class="mb-2">
                                <small class="text-muted">Program Studi:</small><br>
                                <strong>{{ $student->studyProgram->name }}</strong>
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">
                            <i class="ri-edit-line me-2"></i>Edit Mahasiswa
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                            <i class="ri-arrow-left-line me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Statistik Akademik</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-2">
                                <h4 class="text-primary mb-0">{{ $student->semester ?? 'N/A' }}</h4>
                                <small class="text-muted">Semester</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <h4 class="text-success mb-0">{{ $student->gpa ? number_format($student->gpa, 2) : 'N/A' }}</h4>
                                <small class="text-muted">IPK</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <h4 class="text-info mb-0">{{ $student->credits_taken ?? 'N/A' }}</h4>
                                <small class="text-muted">SKS</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <h4 class="text-warning mb-0">{{ $student->entry_year ?? 'N/A' }}</h4>
                                <small class="text-muted">Angkatan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Details -->
        <div class="col-md-8">
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ri-user-line me-2"></i>Informasi Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">NIM:</td>
                                    <td><strong>{{ $student->nim }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nama Lengkap:</td>
                                    <td><strong>{{ $student->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis Kelamin:</td>
                                    <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tempat Lahir:</td>
                                    <td>{{ $student->place_of_birth ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Lahir:</td>
                                    <td>{{ $student->date_of_birth ? $student->date_of_birth->format('d M Y') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Email:</td>
                                    <td>
                                        @if($student->email)
                                            <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">No. Telepon:</td>
                                    <td>
                                        @if($student->phone)
                                            <a href="tel:{{ $student->phone }}">{{ $student->phone }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Alamat:</td>
                                    <td>{{ $student->address ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Asal Sekolah:</td>
                                    <td>{{ $student->school_origin ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status:</td>
                                    <td>
                                        <span class="badge bg-{{ $student->is_active ? 'success' : 'danger' }}">
                                            {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Information -->
            @if($student->parent_name || $student->parent_phone)
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ri-group-line me-2"></i>Informasi Keluarga
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Nama Orang Tua/Wali:</td>
                                    <td><strong>{{ $student->parent_name ?: '-' }}</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">No. Telepon:</td>
                                    <td>
                                        @if($student->parent_phone)
                                            <a href="tel:{{ $student->parent_phone }}">{{ $student->parent_phone }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Academic Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ri-book-open-line me-2"></i>Informasi Akademik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Program Studi:</td>
                                    <td><strong>{{ $student->studyProgram->name ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tahun Masuk:</td>
                                    <td>{{ $student->entry_year ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Semester Saat Ini:</td>
                                    <td>{{ $student->semester ? 'Semester ' . $student->semester : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">IPK:</td>
                                    <td>
                                        @if($student->gpa)
                                            <strong class="text-{{ $student->gpa >= 3.5 ? 'success' : ($student->gpa >= 3.0 ? 'warning' : 'danger') }}">
                                                {{ number_format($student->gpa, 2) }}
                                            </strong>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">SKS Diambil:</td>
                                    <td>{{ $student->credits_taken ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Lulus:</td>
                                    <td>
                                        @if($student->graduation_date)
                                            {{ $student->graduation_date->format('d M Y') }}
                                            <span class="badge bg-success ms-2">Lulus</span>
                                        @else
                                            <span class="badge bg-primary">Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Masa Studi:</td>
                                    <td>
                                        @if($student->graduation_date && $student->entry_year)
                                            {{ $student->graduation_date->year - $student->entry_year }} tahun
                                        @elseif($student->entry_year)
                                            {{ date('Y') - $student->entry_year }} tahun (berlangsung)
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="ri-settings-line me-2"></i>Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Dibuat:</td>
                                    <td>{{ $student->created_at?->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Terakhir Diupdate:</td>
                                    <td>{{ $student->updated_at?->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Slug:</td>
                                    <td><code>{{ $student->slug ?: '-' }}</code></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">ID:</td>
                                    <td><code>{{ $student->id }}</code></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">
                            <i class="ri-edit-line me-2"></i>Edit Mahasiswa
                        </a>
                        
                        @if($student->is_active)
                            <form action="{{ route('admin.students.toggle-status', $student) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning" 
                                        onclick="return confirm('Yakin ingin menonaktifkan mahasiswa ini?')">
                                    <i class="ri-pause-circle-line me-2"></i>Nonaktifkan
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.students.toggle-status', $student) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" 
                                        onclick="return confirm('Yakin ingin mengaktifkan mahasiswa ini?')">
                                    <i class="ri-play-circle-line me-2"></i>Aktifkan
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus mahasiswa ini? Data yang dihapus tidak dapat dikembalikan!')">
                                <i class="ri-delete-bin-line me-2"></i>Hapus
                            </button>
                        </form>

                        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                            <i class="ri-arrow-left-line me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
