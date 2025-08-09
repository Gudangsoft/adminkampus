@extends('admin.layouts.app')

@section('title', 'Detail Program Studi - ' . $studyProgram->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-graduation-cap"></i>
                        Detail Program Studi
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.study-programs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.study-programs.edit', $studyProgram) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Program Image -->
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-image"></i> Gambar Program
                                    </h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($studyProgram->image)
                                        <img src="{{ $studyProgram->image_url }}" 
                                             alt="{{ $studyProgram->name }}" 
                                             class="img-fluid rounded" 
                                             style="max-height: 250px; width: 100%; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                             style="height: 250px;">
                                            <div class="text-center">
                                                <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                                                <p class="text-muted">Tidak ada gambar</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Program Details -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Informasi Program
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150"><strong>Nama Program</strong></td>
                                            <td>: {{ $studyProgram->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Slug</strong></td>
                                            <td>: {{ $studyProgram->slug }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fakultas</strong></td>
                                            <td>: {{ $studyProgram->faculty->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenjang</strong></td>
                                            <td>: 
                                                <span class="badge bg-primary">{{ $studyProgram->degree_level }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Akreditasi</strong></td>
                                            <td>: 
                                                @if($studyProgram->accreditation)
                                                    <span class="badge bg-success">{{ $studyProgram->accreditation }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Durasi</strong></td>
                                            <td>: {{ $studyProgram->duration ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Biaya Kuliah</strong></td>
                                            <td>: 
                                                @if($studyProgram->tuition_fee)
                                                    <span class="text-success fw-bold">{{ $studyProgram->formatted_tuition_fee }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>: 
                                                @if($studyProgram->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non-Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Urutan</strong></td>
                                            <td>: {{ $studyProgram->sort_order }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat</strong></td>
                                            <td>: {{ $studyProgram->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diperbarui</strong></td>
                                            <td>: {{ $studyProgram->updated_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($studyProgram->description)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-align-left"></i> Deskripsi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="program-description">
                                        {!! nl2br(e($studyProgram->description)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Career Prospects -->
                    @if($studyProgram->career_prospects)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-briefcase"></i> Prospek Karir
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="career-prospects">
                                        @if(is_array($studyProgram->career_prospects))
                                            <ul class="list-unstyled">
                                                @foreach($studyProgram->career_prospects as $prospect)
                                                    <li><i class="fas fa-check-circle text-success me-2"></i>{{ $prospect }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {!! nl2br(e($studyProgram->career_prospects)) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Lecturers -->
                    @if($studyProgram->lecturers->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chalkboard-teacher"></i> 
                                        Dosen ({{ $studyProgram->lecturers->count() }})
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($studyProgram->lecturers as $lecturer)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body text-center">
                                                    @if($lecturer->photo)
                                                        <img src="{{ $lecturer->photo_url }}" 
                                                             alt="{{ $lecturer->name }}" 
                                                             class="rounded-circle mb-2" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                    <h6 class="card-title mb-1">{{ $lecturer->name }}</h6>
                                                    <small class="text-muted">{{ $lecturer->title }}</small>
                                                    @if($lecturer->specialization)
                                                    <br><small class="text-primary">{{ $lecturer->specialization }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-tools"></i> Aksi Cepat
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.study-programs.edit', $studyProgram) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Program
                                        </a>
                                        
                                        <form method="POST" 
                                              action="{{ route('admin.study-programs.toggle-status', $studyProgram) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn {{ $studyProgram->is_active ? 'btn-danger' : 'btn-success' }}">
                                                <i class="fas fa-{{ $studyProgram->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                {{ $studyProgram->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('program-studi.show', $studyProgram->slug) }}" 
                                           class="btn btn-info" 
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i> Lihat di Frontend
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.program-description, .career-prospects {
    line-height: 1.6;
    color: #495057;
}

.table td {
    padding: 0.5rem 0.75rem;
    vertical-align: top;
}

.card-title {
    color: #495057;
}

.btn-group .btn {
    margin-right: 0.5rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection
