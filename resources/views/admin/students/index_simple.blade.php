@extends('layouts.admin_simple')

@section('title', 'Kelola Mahasiswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mb-4">Kelola Mahasiswa (Simple Version)</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Mahasiswa</h5>
                    <h2 class="text-primary">{{ $students->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Program Studi</h5>
                    <h2 class="text-success">{{ $studyPrograms->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5>Daftar Mahasiswa</h5>
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Program Studi</th>
                                <th>Tahun Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                                <tr>
                                    <td>{{ $students->firstItem() + $index }}</td>
                                    <td>{{ $student->nim }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email ?? '-' }}</td>
                                    <td>
                                        @if($student->studyProgram)
                                            {{ $student->studyProgram->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $student->entry_year }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ $student->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $students->links() }}
            @else
                <div class="text-center py-4">
                    <p class="text-muted">Tidak ada data mahasiswa</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
