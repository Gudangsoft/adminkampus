@extends('layouts.admin')

@section('title', 'Edit Program Studi - ' . $studyProgram->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Edit Program Studi
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.study-programs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.study-programs.update', $studyProgram) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Nama Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $studyProgram->name) }}" 
                                           required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="code">Kode Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('code') is-invalid @enderror" 
                                           id="code" 
                                           name="code" 
                                           value="{{ old('code', $studyProgram->code) }}" 
                                           placeholder="Contoh: TI, SI, MI, TE"
                                           maxlength="10"
                                           style="text-transform: uppercase;"
                                           required>
                                    @error('code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Kode unik untuk program studi (maksimal 10 karakter)</small>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" 
                                           name="slug" 
                                           value="{{ old('slug', $studyProgram->slug) }}" 
                                           required>
                                    @error('slug')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="degree">Jenjang <span class="text-danger">*</span></label>
                                            <select class="form-select @error('degree') is-invalid @enderror" 
                                                    id="degree" 
                                                    name="degree" 
                                                    required>
                                                <option value="">Pilih Jenjang</option>
                                                <option value="D3" {{ old('degree', $studyProgram->degree) == 'D3' ? 'selected' : '' }}>D3 (Diploma 3)</option>
                                                <option value="D4" {{ old('degree', $studyProgram->degree) == 'D4' ? 'selected' : '' }}>D4 (Diploma 4)</option>
                                                <option value="S1" {{ old('degree', $studyProgram->degree) == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                                                <option value="S2" {{ old('degree', $studyProgram->degree) == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                                                <option value="S3" {{ old('degree', $studyProgram->degree) == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                                            </select>
                                            @error('degree')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="accreditation">Akreditasi</label>
                                            <select class="form-select @error('accreditation') is-invalid @enderror" 
                                                    id="accreditation" 
                                                    name="accreditation">
                                                <option value="">Pilih Akreditasi</option>
                                                <option value="A" {{ old('accreditation', $studyProgram->accreditation) == 'A' ? 'selected' : '' }}>A (Unggul)</option>
                                                <option value="B" {{ old('accreditation', $studyProgram->accreditation) == 'B' ? 'selected' : '' }}>B (Baik Sekali)</option>
                                                <option value="C" {{ old('accreditation', $studyProgram->accreditation) == 'C' ? 'selected' : '' }}>C (Baik)</option>
                                                <option value="Baik Sekali" {{ old('accreditation', $studyProgram->accreditation) == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                                <option value="Baik" {{ old('accreditation', $studyProgram->accreditation) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            </select>
                                            @error('accreditation')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Deskripsi program studi">{{ old('description', $studyProgram->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="career_prospects">Prospek Karir</label>
                                    <textarea class="form-control @error('career_prospects') is-invalid @enderror" 
                                              id="career_prospects" 
                                              name="career_prospects" 
                                              rows="4" 
                                              placeholder="Prospek karir lulusan (satu per baris)">{{ old('career_prospects', is_array($studyProgram->career_prospects) ? implode("\n", $studyProgram->career_prospects) : $studyProgram->career_prospects) }}</textarea>
                                    @error('career_prospects')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Masukkan satu prospek karir per baris.</small>
                                </div>

                                <div class="form-group">
                                    <label for="curriculum">Kurikulum</label>
                                    <textarea class="form-control @error('curriculum') is-invalid @enderror" 
                                              id="curriculum" 
                                              name="curriculum" 
                                              rows="4" 
                                              placeholder="Informasi kurikulum program studi">{{ old('curriculum', $studyProgram->curriculum) }}</textarea>
                                    @error('curriculum')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="facilities">Fasilitas</label>
                                    <textarea class="form-control @error('facilities') is-invalid @enderror" 
                                              id="facilities" 
                                              name="facilities" 
                                              rows="4" 
                                              placeholder="Fasilitas program studi (satu per baris)">{{ old('facilities', is_array($studyProgram->facilities) ? implode("\n", $studyProgram->facilities) : $studyProgram->facilities) }}</textarea>
                                    @error('facilities')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Masukkan satu fasilitas per baris.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website">Website</label>
                                            <input type="url" 
                                                   class="form-control @error('website') is-invalid @enderror" 
                                                   id="website" 
                                                   name="website" 
                                                   value="{{ old('website', $studyProgram->website) }}" 
                                                   placeholder="https://example.com">
                                            @error('website')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $studyProgram->email) }}" 
                                                   placeholder="prodi@example.com">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Telepon</label>
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $studyProgram->phone) }}" 
                                                   placeholder="021-12345678">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="head_of_program">Kepala Program</label>
                                            <input type="text" 
                                                   class="form-control @error('head_of_program') is-invalid @enderror" 
                                                   id="head_of_program" 
                                                   name="head_of_program" 
                                                   value="{{ old('head_of_program', $studyProgram->head_of_program) }}" 
                                                   placeholder="Dr. Nama Kepala Program">
                                            @error('head_of_program')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="credit_total">Total SKS</label>
                                            <input type="number" 
                                                   class="form-control @error('credit_total') is-invalid @enderror" 
                                                   id="credit_total" 
                                                   name="credit_total" 
                                                   value="{{ old('credit_total', $studyProgram->credit_total) }}" 
                                                   placeholder="144" 
                                                   min="0">
                                            @error('credit_total')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="semester_total">Total Semester</label>
                                            <input type="number" 
                                                   class="form-control @error('semester_total') is-invalid @enderror" 
                                                   id="semester_total" 
                                                   name="semester_total" 
                                                   value="{{ old('semester_total', $studyProgram->semester_total) }}" 
                                                   placeholder="8" 
                                                   min="1">
                                            @error('semester_total')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="accreditation_year">Tahun Akreditasi</label>
                                            <input type="number" 
                                                   class="form-control @error('accreditation_year') is-invalid @enderror" 
                                                   id="accreditation_year" 
                                                   name="accreditation_year" 
                                                   value="{{ old('accreditation_year', $studyProgram->accreditation_year) }}" 
                                                   placeholder="2023" 
                                                   min="2000" 
                                                   max="{{ date('Y') + 1 }}">
                                            @error('accreditation_year')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sort_order">Urutan</label>
                                    <input type="number" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="{{ old('sort_order', $studyProgram->sort_order) }}" 
                                           min="0">
                                    @error('sort_order')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $studyProgram->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Program Studi
                            </button>
                            <a href="{{ route('admin.study-programs.show', $studyProgram) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto generate slug from name
    $('#name').on('input', function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
                      .replace(/[^a-z0-9\s-]/g, '')
                      .replace(/\s+/g, '-')
                      .replace(/-+/g, '-')
                      .trim('-');
        $('#slug').val(slug);
    });

    // Auto-uppercase for code input
    $('#code').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
});
</script>
@endsection
