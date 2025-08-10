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

                                <div class="form-group">
                                    <label for="faculty_id">Fakultas <span class="text-danger">*</span></label>
                                    <select class="form-control @error('faculty_id') is-invalid @enderror" 
                                            id="faculty_id" 
                                            name="faculty_id" 
                                            required>
                                        <option value="">Pilih Fakultas</option>
                                        @foreach(\App\Models\Faculty::active()->get() as $faculty)
                                            <option value="{{ $faculty->id }}" 
                                                    {{ old('faculty_id', $studyProgram->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                                {{ $faculty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('faculty_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="degree_level">Jenjang <span class="text-danger">*</span></label>
                                            <select class="form-control @error('degree_level') is-invalid @enderror" 
                                                    id="degree_level" 
                                                    name="degree_level" 
                                                    required>
                                                <option value="">Pilih Jenjang</option>
                                                <option value="Diploma 3" {{ old('degree_level', $studyProgram->degree_level) == 'Diploma 3' ? 'selected' : '' }}>Diploma 3</option>
                                                <option value="Sarjana" {{ old('degree_level', $studyProgram->degree_level) == 'Sarjana' ? 'selected' : '' }}>Sarjana (S1)</option>
                                                <option value="Magister" {{ old('degree_level', $studyProgram->degree_level) == 'Magister' ? 'selected' : '' }}>Magister (S2)</option>
                                                <option value="Doktor" {{ old('degree_level', $studyProgram->degree_level) == 'Doktor' ? 'selected' : '' }}>Doktor (S3)</option>
                                            </select>
                                            @error('degree_level')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="accreditation">Akreditasi</label>
                                            <select class="form-control @error('accreditation') is-invalid @enderror" 
                                                    id="accreditation" 
                                                    name="accreditation">
                                                <option value="">Pilih Akreditasi</option>
                                                <option value="A" {{ old('accreditation', $studyProgram->accreditation) == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ old('accreditation', $studyProgram->accreditation) == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="C" {{ old('accreditation', $studyProgram->accreditation) == 'C' ? 'selected' : '' }}>C</option>
                                                <option value="Unggul" {{ old('accreditation', $studyProgram->accreditation) == 'Unggul' ? 'selected' : '' }}>Unggul</option>
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
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Gambar Program</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    @error('image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                                    
                                    @if($studyProgram->image)
                                    <div class="mt-2">
                                        <img src="{{ $studyProgram->image_url }}" 
                                             alt="Current image" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                        <p class="small text-muted mt-1">Gambar saat ini</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="duration">Durasi Studi</label>
                                    <input type="text" 
                                           class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" 
                                           name="duration" 
                                           value="{{ old('duration', $studyProgram->duration) }}" 
                                           placeholder="Contoh: 4 Tahun">
                                    @error('duration')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tuition_fee">Biaya Kuliah (Rp)</label>
                                    <input type="number" 
                                           class="form-control @error('tuition_fee') is-invalid @enderror" 
                                           id="tuition_fee" 
                                           name="tuition_fee" 
                                           value="{{ old('tuition_fee', $studyProgram->tuition_fee) }}" 
                                           placeholder="5000000">
                                    @error('tuition_fee')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

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

    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
});
</script>
@endsection
