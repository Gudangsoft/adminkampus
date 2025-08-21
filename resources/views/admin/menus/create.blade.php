                    <!-- Settings Card Fields moved inside the form -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="location">Lokasi Menu <span class="text-danger">*</span></label>
                                <select class="form-control @error('location') is-invalid @enderror" id="location" name="location" required>
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
                                <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
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
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                <small class="form-text text-muted">Urutan tampil menu (0 = paling atas)</small>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Menu Aktif</label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    </form>
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
