@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pengumuman</h3>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.announcements.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Excerpt -->
                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Ringkasan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt') }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Ringkasan singkat yang akan muncul dalam daftar pengumuman</div>
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                    
                                    <!-- Rich Text Editor Toolbar -->
                                    <div class="editor-toolbar mb-2">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('bold')" title="Bold">
                                                <i class="fas fa-bold"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('italic')" title="Italic">
                                                <i class="fas fa-italic"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('underline')" title="Underline">
                                                <i class="fas fa-underline"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="btn-group ms-2" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('justifyLeft')" title="Align Left">
                                                <i class="fas fa-align-left"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('justifyCenter')" title="Align Center">
                                                <i class="fas fa-align-center"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('justifyRight')" title="Align Right">
                                                <i class="fas fa-align-right"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="btn-group ms-2" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('insertUnorderedList')" title="Bullet List">
                                                <i class="fas fa-list-ul"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="execCmd('insertOrderedList')" title="Numbered List">
                                                <i class="fas fa-list-ol"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="btn-group ms-2" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertLink()" title="Insert Link">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="btn-group ms-2" role="group">
                                            <select class="form-select form-select-sm" onchange="formatHeading(this.value)" style="width: auto;">
                                                <option value="">Heading</option>
                                                <option value="h1">Heading 1</option>
                                                <option value="h2">Heading 2</option>
                                                <option value="h3">Heading 3</option>
                                                <option value="h4">Heading 4</option>
                                                <option value="p">Paragraph</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div id="content-editor" class="form-control @error('content') is-invalid @enderror" 
                                         contenteditable="true" style="min-height: 300px; max-height: 500px; overflow-y: auto;">
                                        {!! old('content') !!}
                                    </div>
                                    
                                    <textarea id="content" name="content" style="display: none;">{{ old('content') }}</textarea>
                                    
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Priority -->
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : 'selected' }}>Sedang</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Pinned -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_pinned" name="is_pinned" 
                                               value="1" {{ old('is_pinned') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_pinned">
                                            <i class="fas fa-thumbtack"></i> Pin Pengumuman
                                        </label>
                                    </div>
                                    <div class="form-text">Pengumuman yang di-pin akan muncul di bagian atas</div>
                                </div>

                                <!-- Published At -->
                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" name="published_at" value="{{ old('published_at') }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan untuk menggunakan waktu sekarang saat dipublikasi</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Pengumuman
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.editor-toolbar {
    border: 1px solid #ddd;
    border-bottom: none;
    padding: 8px;
    background-color: #f8f9fa;
    border-radius: 0.375rem 0.375rem 0 0;
}

#content-editor {
    border-radius: 0 0 0.375rem 0.375rem !important;
}

#content-editor:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
function execCmd(command, value = null) {
    document.execCommand(command, false, value);
    updateHiddenTextarea();
}

function formatHeading(tag) {
    if (tag) {
        document.execCommand('formatBlock', false, tag);
        updateHiddenTextarea();
    }
}

function insertLink() {
    const url = prompt('Masukkan URL:');
    if (url) {
        document.execCommand('createLink', false, url);
        updateHiddenTextarea();
    }
}

function updateHiddenTextarea() {
    document.getElementById('content').value = document.getElementById('content-editor').innerHTML;
}

// Update hidden textarea when content changes
document.getElementById('content-editor').addEventListener('input', updateHiddenTextarea);

// Initialize content
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('content-editor');
    const hiddenTextarea = document.getElementById('content');
    
    if (hiddenTextarea.value) {
        editor.innerHTML = hiddenTextarea.value;
    }
});
</script>
@endsection
