@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@push('styles')
<style>
.nav-tabs .nav-link {
    color: #495057 !important;
    background-color: #fff !important;
    border: 1px solid #dee2e6 !important;
}

.nav-tabs .nav-link:hover {
    color: #007bff !important;
    background-color: #f8f9fa !important;
    border-color: #dee2e6 #dee2e6 #fff !important;
}

.nav-tabs .nav-link.active {
    color: #007bff !important;
    background-color: #fff !important;
    border-color: #dee2e6 #dee2e6 #fff !important;
    border-bottom-color: transparent !important;
}

.nav-tabs {
    border-bottom: 1px solid #dee2e6 !important;
}

.tab-content {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-top: none;
    padding: 20px;
    border-radius: 0 0 6px 6px;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan Website</h3>
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

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="fas fa-cog me-1"></i> Umum
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                                <i class="fas fa-address-book me-1"></i> Kontak
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                                <i class="fas fa-share-alt me-1"></i> Media Sosial
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i> Tentang
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-0" id="settingsTabContent">
                        <!-- General Settings -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">Nama Website</label>
                                            <input type="text" class="form-control" id="site_name" name="settings[site_name]" 
                                                   value="{{ isset($settings['site_name']) ? $settings['site_name']->value : '' }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_url" class="form-label">URL Website</label>
                                            <input type="url" class="form-control" id="site_url" name="settings[site_url]" 
                                                   value="{{ isset($settings['site_url']) ? $settings['site_url']->value : '' }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_keywords" class="form-label">Keywords SEO</label>
                                            <input type="text" class="form-control" id="site_keywords" name="settings[site_keywords]" 
                                                   value="{{ isset($settings['site_keywords']) ? $settings['site_keywords']->value : '' }}"
                                                   placeholder="keyword1, keyword2, keyword3">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="site_logo_file" class="form-label">Logo Website</label>
                                            <input type="file" class="form-control" id="site_logo_file" name="site_logo_file" accept="image/*">
                                            @if(isset($settings['site_logo']) && $settings['site_logo']->value)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $settings['site_logo']->value) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px;">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label for="site_favicon_file" class="form-label">Favicon</label>
                                            <input type="file" class="form-control" id="site_favicon_file" name="site_favicon_file" accept=".ico,.png">
                                            @if(isset($settings['site_favicon']) && $settings['site_favicon']->value)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $settings['site_favicon']->value) }}" alt="Favicon" class="img-thumbnail" style="max-height: 32px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Deskripsi Website</label>
                                    <textarea class="form-control" id="site_description" name="settings[site_description]" rows="3">{{ isset($settings['site_description']) ? $settings['site_description']->value : '' }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Pengaturan Umum
                                </button>
                            </form>
                        </div>

                        <!-- Contact Settings -->
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_address" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="contact_address" name="settings[contact_address]" rows="3">{{ isset($settings['contact_address']) ? $settings['contact_address']->value : '' }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_phone" class="form-label">Telepon</label>
                                            <input type="text" class="form-control" id="contact_phone" name="settings[contact_phone]" 
                                                   value="{{ isset($settings['contact_phone']) ? $settings['contact_phone']->value : '' }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_fax" class="form-label">Fax</label>
                                            <input type="text" class="form-control" id="contact_fax" name="settings[contact_fax]" 
                                                   value="{{ isset($settings['contact_fax']) ? $settings['contact_fax']->value : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="contact_email" name="settings[contact_email]" 
                                                   value="{{ isset($settings['contact_email']) ? $settings['contact_email']->value : '' }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_whatsapp" class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" id="contact_whatsapp" name="settings[contact_whatsapp]" 
                                                   value="{{ isset($settings['contact_whatsapp']) ? $settings['contact_whatsapp']->value : '' }}"
                                                   placeholder="628123456789">
                                        </div>

                                        <div class="mb-3">
                                            <label for="contact_map" class="form-label">Google Maps Embed URL</label>
                                            <textarea class="form-control" id="contact_map" name="settings[contact_map]" rows="3" 
                                                      placeholder="https://www.google.com/maps/embed?pb=...">{{ isset($settings['contact_map']) ? $settings['contact_map']->value : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Pengaturan Kontak
                                </button>
                            </form>
                        </div>

                        <!-- Social Media Settings -->
                        <div class="tab-pane fade" id="social" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social_facebook" class="form-label">
                                                <i class="fab fa-facebook text-primary"></i> Facebook
                                            </label>
                                            <input type="url" class="form-control" id="social_facebook" name="settings[social_facebook]" 
                                                   value="{{ isset($settings['social_facebook']) ? $settings['social_facebook']->value : '' }}"
                                                   placeholder="https://facebook.com/username">
                                        </div>

                                        <div class="mb-3">
                                            <label for="social_twitter" class="form-label">
                                                <i class="fab fa-twitter text-info"></i> Twitter
                                            </label>
                                            <input type="url" class="form-control" id="social_twitter" name="settings[social_twitter]" 
                                                   value="{{ isset($settings['social_twitter']) ? $settings['social_twitter']->value : '' }}"
                                                   placeholder="https://twitter.com/username">
                                        </div>

                                        <div class="mb-3">
                                            <label for="social_instagram" class="form-label">
                                                <i class="fab fa-instagram text-danger"></i> Instagram
                                            </label>
                                            <input type="url" class="form-control" id="social_instagram" name="settings[social_instagram]" 
                                                   value="{{ isset($settings['social_instagram']) ? $settings['social_instagram']->value : '' }}"
                                                   placeholder="https://instagram.com/username">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social_youtube" class="form-label">
                                                <i class="fab fa-youtube text-danger"></i> YouTube
                                            </label>
                                            <input type="url" class="form-control" id="social_youtube" name="settings[social_youtube]" 
                                                   value="{{ isset($settings['social_youtube']) ? $settings['social_youtube']->value : '' }}"
                                                   placeholder="https://youtube.com/channel/...">
                                        </div>

                                        <div class="mb-3">
                                            <label for="social_linkedin" class="form-label">
                                                <i class="fab fa-linkedin text-primary"></i> LinkedIn
                                            </label>
                                            <input type="url" class="form-control" id="social_linkedin" name="settings[social_linkedin]" 
                                                   value="{{ isset($settings['social_linkedin']) ? $settings['social_linkedin']->value : '' }}"
                                                   placeholder="https://linkedin.com/company/...">
                                        </div>

                                        <div class="mb-3">
                                            <label for="social_tiktok" class="form-label">
                                                <i class="fab fa-tiktok text-dark"></i> TikTok
                                            </label>
                                            <input type="url" class="form-control" id="social_tiktok" name="settings[social_tiktok]" 
                                                   value="{{ isset($settings['social_tiktok']) ? $settings['social_tiktok']->value : '' }}"
                                                   placeholder="https://tiktok.com/@username">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Pengaturan Media Sosial
                                </button>
                            </form>
                        </div>

                        <!-- About Settings -->
                        <div class="tab-pane fade" id="about" role="tabpanel">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="about_title" class="form-label">Judul Tentang Kami</label>
                                    <input type="text" class="form-control" id="about_title" name="settings[about_title]" 
                                           value="{{ isset($settings['about_title']) ? $settings['about_title']->value : '' }}">
                                </div>

                                <div class="mb-3">
                                    <label for="about_content" class="form-label">Konten Tentang Kami</label>
                                    <textarea class="form-control" id="about_content" name="settings[about_content]" rows="10">{{ isset($settings['about_content']) ? $settings['about_content']->value : '' }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="about_vision" class="form-label">Visi</label>
                                            <textarea class="form-control" id="about_vision" name="settings[about_vision]" rows="4">{{ isset($settings['about_vision']) ? $settings['about_vision']->value : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="about_mission" class="form-label">Misi</label>
                                            <textarea class="form-control" id="about_mission" name="settings[about_mission]" rows="4">{{ isset($settings['about_mission']) ? $settings['about_mission']->value : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Pengaturan Tentang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    });
});
</script>
@endpush
@endsection
