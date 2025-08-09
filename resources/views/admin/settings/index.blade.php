@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pengaturan Website</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Informasi Dasar</h6>
                                
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Nama Website</label>
                                    <input type="text" class="form-control" name="settings[site_name]" 
                                           value="{{ $settings['site_name']->value ?? 'G0-CAMPUS' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Deskripsi Website</label>
                                    <textarea class="form-control" name="settings[site_description]" rows="3">{{ $settings['site_description']->value ?? 'Kampus modern untuk masa depan cemerlang' }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="site_keywords" class="form-label">Keywords SEO</label>
                                    <input type="text" class="form-control" name="settings[site_keywords]" 
                                           value="{{ $settings['site_keywords']->value ?? 'kampus, universitas, pendidikan, akademik' }}">
                                    <div class="form-text">Pisahkan dengan koma</div>
                                </div>

                                <div class="mb-3">
                                    <label for="site_logo" class="form-label">Logo Website</label>
                                    @if(isset($settings['site_logo']) && $settings['site_logo']->value)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $settings['site_logo']->value) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                                            <p class="text-muted small mt-1">Logo saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="site_logo_file" accept="image/*">
                                    <div class="form-text">Upload logo baru (JPG, PNG, GIF - Max: 2MB)</div>
                                    <input type="hidden" name="settings[site_logo]" value="{{ $settings['site_logo']->value ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="site_favicon" class="form-label">Favicon Website</label>
                                    @if(isset($settings['site_favicon']) && $settings['site_favicon']->value)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($settings['site_favicon']->value) }}" alt="Current Favicon" class="img-thumbnail" style="max-height: 32px;">
                                            <p class="text-muted small mt-1">Favicon saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="site_favicon_file" accept="image/*">
                                    <div class="form-text">Upload favicon baru (ICO, PNG - Max: 1MB, Rekomendasi: 32x32px)</div>
                                    <input type="hidden" name="settings[site_favicon]" value="{{ $settings['site_favicon']->value ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-primary mb-3">Mode Maintenance</h6>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" name="settings[maintenance_mode]" 
                                               id="maintenance_mode" value="1" 
                                               {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode']->value == '1') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            <strong>Aktifkan Mode Maintenance</strong>
                                        </label>
                                        <div class="form-text">Website akan menampilkan halaman maintenance untuk visitor</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="maintenance_title" class="form-label">Judul Halaman Maintenance</label>
                                        <input type="text" class="form-control" name="settings[maintenance_title]" 
                                               value="{{ $settings['maintenance_title']->value ?? 'Website Sedang Dalam Perbaikan' }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="maintenance_message" class="form-label">Pesan Maintenance</label>
                                        <textarea class="form-control" name="settings[maintenance_message]" rows="3">{{ $settings['maintenance_message']->value ?? 'Mohon maaf, website sedang dalam perbaikan. Silakan kembali lagi nanti.' }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="maintenance_estimated_time" class="form-label">Estimasi Waktu Selesai</label>
                                        <input type="datetime-local" class="form-control" name="settings[maintenance_estimated_time]" 
                                               value="{{ $settings['maintenance_estimated_time']->value ?? '' }}">
                                        <div class="form-text">Kosongkan jika tidak ada estimasi waktu</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Informasi Kontak</h6>
                                
                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="settings[contact_address]" rows="3">{{ $settings['contact_address']->value ?? 'Jl. Pendidikan No. 123, Kota Pendidikan' }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" name="settings[contact_phone]" 
                                           value="{{ $settings['contact_phone']->value ?? '+62 21 1234567' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="settings[contact_email]" 
                                           value="{{ $settings['contact_email']->value ?? 'info@g0campus.ac.id' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="contact_whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" name="settings[contact_whatsapp]" 
                                           value="{{ $settings['contact_whatsapp']->value ?? '+6281234567890' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="contact_website" class="form-label">Website</label>
                                    <input type="url" class="form-control" name="settings[contact_website]" 
                                           value="{{ $settings['contact_website']->value ?? 'https://g0campus.ac.id' }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Media Sosial</h6>
                                
                                <div class="mb-3">
                                    <label for="social_facebook" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" name="settings[social_facebook]" 
                                           value="{{ $settings['social_facebook']->value ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="social_twitter" class="form-label">Twitter</label>
                                    <input type="url" class="form-control" name="settings[social_twitter]" 
                                           value="{{ $settings['social_twitter']->value ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="social_instagram" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" name="settings[social_instagram]" 
                                           value="{{ $settings['social_instagram']->value ?? '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="social_youtube" class="form-label">YouTube</label>
                                    <input type="url" class="form-control" name="settings[social_youtube]" 
                                           value="{{ $settings['social_youtube']->value ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Pengaturan Lainnya</h6>
                                
                                <div class="mb-3">
                                    <label for="site_maintenance" class="form-label">Mode Maintenance</label>
                                    <select class="form-select" name="settings[site_maintenance]">
                                        <option value="0" {{ ($settings['site_maintenance']->value ?? '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                        <option value="1" {{ ($settings['site_maintenance']->value ?? '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="news_per_page" class="form-label">Berita per Halaman</label>
                                    <input type="number" class="form-control" name="settings[news_per_page]" 
                                           value="{{ $settings['news_per_page']->value ?? '12' }}" min="1" max="50">
                                </div>

                                <div class="mb-3">
                                    <label for="allow_comments" class="form-label">Izinkan Komentar</label>
                                    <select class="form-select" name="settings[allow_comments]">
                                        <option value="1" {{ ($settings['allow_comments']->value ?? '1') == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ ($settings['allow_comments']->value ?? '1') == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="google_analytics" class="form-label">Google Analytics ID</label>
                                    <input type="text" class="form-control" name="settings[google_analytics]" 
                                           value="{{ $settings['google_analytics']->value ?? '' }}"
                                           placeholder="G-XXXXXXXXXX">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview logo image
document.querySelector('input[name="site_logo_file"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file size
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file logo terlalu besar. Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.querySelector('#logo-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'logo-preview';
                preview.className = 'mt-3 p-2 border rounded';
                preview.innerHTML = `
                    <p class="text-success small mb-2"><i class="fas fa-check"></i> Preview logo baru:</p>
                    <img class="img-thumbnail" style="max-height: 100px;">
                `;
                document.querySelector('input[name="site_logo_file"]').closest('.mb-3').appendChild(preview);
            }
            preview.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Preview favicon image
document.querySelector('input[name="site_favicon_file"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file size
        if (file.size > 1024 * 1024) {
            alert('Ukuran file favicon terlalu besar. Maksimal 1MB.');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.querySelector('#favicon-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'favicon-preview';
                preview.className = 'mt-3 p-2 border rounded';
                preview.innerHTML = `
                    <p class="text-success small mb-2"><i class="fas fa-check"></i> Preview favicon baru:</p>
                    <img class="img-thumbnail" style="max-height: 32px;">
                `;
                document.querySelector('input[name="site_favicon_file"]').closest('.mb-3').appendChild(preview);
            }
            preview.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
