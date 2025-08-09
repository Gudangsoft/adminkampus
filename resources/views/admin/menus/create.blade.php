@extends('layouts.admin')

@section('title', 'Tambah Menu')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Menu</h1>
        <a href="{{ route('admin.menus.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Menu</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="name">Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="icon">Icon CSS Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" value="{{ old('icon') }}" 
                                   placeholder="Contoh: fas fa-home">
                            <small class="form-text text-muted">
                                Gunakan Font Awesome classes. 
                                <a href="https://fontawesome.com/icons" target="_blank">Lihat icons</a>
                            </small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Tipe Link</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="link_type" 
                                               id="link_type_url" value="url" checked>
                                        <label class="form-check-label" for="link_type_url">
                                            URL Custom
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="link_type" 
                                               id="link_type_page" value="page">
                                        <label class="form-check-label" for="link_type_page">
                                            Halaman Website
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="target">Target Link</label>
                                    <select class="form-control @error('target') is-invalid @enderror" 
                                            id="target" name="target">
                                        <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>
                                            Same Window (_self)
                                        </option>
                                        <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>
                                            New Window (_blank)
                                        </option>
                                    </select>
                                    @error('target')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3" id="url_field">
                            <label for="url">URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                   id="url" name="url" value="{{ old('url') }}" 
                                   placeholder="https://example.com atau /path">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3" id="page_field" style="display: none;">
                            <label for="page_id">Pilih Halaman <span class="text-danger">*</span></label>
                            <select class="form-control @error('page_id') is-invalid @enderror" 
                                    id="page_id" name="page_id">
                                <option value="">-- Pilih Halaman --</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Simpan Menu</button>
                                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Settings Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan Menu</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="location">Lokasi Menu <span class="text-danger">*</span></label>
                        <select class="form-control @error('location') is-invalid @enderror" 
                                id="location" name="location" form="menuForm" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="header" {{ old('location') === 'header' ? 'selected' : '' }}>Header</option>
                            <option value="footer" {{ old('location') === 'footer' ? 'selected' : '' }}>Footer</option>
                            <option value="sidebar" {{ old('location') === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        </select>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="parent_id">Parent Menu</label>
                        <select class="form-control @error('parent_id') is-invalid @enderror" 
                                id="parent_id" name="parent_id" form="menuForm">
                            <option value="">-- Root Menu --</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }} ({{ ucfirst($parent->location) }})
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Kosongkan jika ini adalah menu utama</small>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="sort_order">Urutan</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                               min="0" form="menuForm">
                        <small class="form-text text-muted">Urutan tampil menu (0 = paling atas)</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" 
                               id="is_active" name="is_active" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }} form="menuForm">
                        <label class="form-check-label" for="is_active">
                            Menu Aktif
                        </label>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bantuan</h6>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-question-circle me-2"></i>Cara Membuat Menu:</h6>
                    <ol class="small">
                        <li>Isi nama menu yang akan ditampilkan</li>
                        <li>Pilih tipe link (URL custom atau halaman website)</li>
                        <li>Tentukan lokasi menu (header, footer, atau sidebar)</li>
                        <li>Atur parent jika ingin membuat submenu</li>
                        <li>Set urutan untuk mengatur posisi menu</li>
                    </ol>
                    
                    <hr>
                    
                    <h6><i class="fas fa-lightbulb me-2"></i>Tips:</h6>
                    <ul class="small">
                        <li>Gunakan icon dari Font Awesome untuk mempercantik menu</li>
                        <li>URL bisa berupa link eksternal atau path internal</li>
                        <li>Target "_blank" akan membuka link di tab baru</li>
                        <li>Submenu hanya akan tampil jika parent menu aktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for sidebar inputs -->
<form id="menuForm" style="display: none;"></form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle link type toggle
    const urlRadio = document.getElementById('link_type_url');
    const pageRadio = document.getElementById('link_type_page');
    const urlField = document.getElementById('url_field');
    const pageField = document.getElementById('page_field');
    
    function toggleLinkType() {
        if (urlRadio.checked) {
            urlField.style.display = 'block';
            pageField.style.display = 'none';
            document.getElementById('url').required = true;
            document.getElementById('page_id').required = false;
        } else {
            urlField.style.display = 'none';
            pageField.style.display = 'block';
            document.getElementById('url').required = false;
            document.getElementById('page_id').required = true;
        }
    }
    
    urlRadio.addEventListener('change', toggleLinkType);
    pageRadio.addEventListener('change', toggleLinkType);
    
    // Connect sidebar form elements
    const mainForm = document.querySelector('form[action*="store"]');
    const sidebarInputs = document.querySelectorAll('#menuForm input, #menuForm select');
    
    sidebarInputs.forEach(input => {
        const cloned = input.cloneNode(true);
        cloned.style.display = 'none';
        mainForm.appendChild(cloned);
        
        input.addEventListener('input', function() {
            cloned.value = this.value;
        });
        
        input.addEventListener('change', function() {
            cloned.value = this.value;
            if (this.type === 'checkbox') {
                cloned.checked = this.checked;
            }
        });
    });
});
</script>
@endpush
