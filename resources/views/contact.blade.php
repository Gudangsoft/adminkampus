@extends('layouts.app')

@section('title', 'Kontak Kami - ' . setting('site_name', config('app.name')))

@section('meta_description', 'Hubungi kami untuk informasi lebih lanjut tentang ' . setting('site_name', config('app.name')) . '. Kami siap membantu Anda.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">Kontak Kami</h1>
                <p class="lead text-muted">
                    Hubungi kami untuk informasi lebih lanjut atau jika Anda memiliki pertanyaan. 
                    Kami akan merespons dalam waktu 1x24 jam pada hari kerja.
                </p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-envelope me-2"></i>
                                Kirim Pesan
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                Nama Lengkap <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email') }}" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="tel" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone') }}"
                                                   placeholder="Contoh: 08123456789">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subjek</label>
                                            <input type="text" 
                                                   class="form-control @error('subject') is-invalid @enderror" 
                                                   id="subject" 
                                                   name="subject" 
                                                   value="{{ old('subject') }}"
                                                   placeholder="Subjek pesan">
                                            @error('subject')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">
                                        Pesan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="6" 
                                              required 
                                              placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                                    <div class="form-text">Maksimal 2000 karakter</div>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Kontak
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(setting('contact_address'))
                                <div class="d-flex align-items-start mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                    <div>
                                        <strong>Alamat:</strong><br>
                                        <span class="text-muted">{{ setting('contact_address') }}</span>
                                    </div>
                                </div>
                            @endif

                            @if(setting('contact_phone'))
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-phone text-primary me-3"></i>
                                    <div>
                                        <strong>Telepon:</strong><br>
                                        <a href="tel:{{ setting('contact_phone') }}" class="text-decoration-none">
                                            {{ setting('contact_phone') }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if(setting('contact_email'))
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-envelope text-primary me-3"></i>
                                    <div>
                                        <strong>Email:</strong><br>
                                        <a href="mailto:{{ setting('contact_email') }}" class="text-decoration-none">
                                            {{ setting('contact_email') }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-clock text-primary me-3"></i>
                                <div>
                                    <strong>Jam Operasional:</strong><br>
                                    <span class="text-muted">
                                        Senin - Jumat: 08:00 - 17:00 WIB<br>
                                        Sabtu - Minggu: Tutup
                                    </span>
                                </div>
                            </div>

                            <!-- Social Media Links -->
                            @if(setting('social_facebook') || setting('social_twitter') || setting('social_instagram') || setting('social_youtube'))
                                <hr>
                                <div>
                                    <strong class="d-block mb-2">Ikuti Kami:</strong>
                                    <div class="d-flex gap-2">
                                        @if(setting('social_facebook'))
                                            <a href="{{ setting('social_facebook') }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        @endif
                                        @if(setting('social_twitter'))
                                            <a href="{{ setting('social_twitter') }}" 
                                               class="btn btn-outline-info btn-sm" 
                                               target="_blank">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if(setting('social_instagram'))
                                            <a href="{{ setting('social_instagram') }}" 
                                               class="btn btn-outline-danger btn-sm" 
                                               target="_blank">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if(setting('social_youtube'))
                                            <a href="{{ setting('social_youtube') }}" 
                                               class="btn btn-outline-dark btn-sm" 
                                               target="_blank">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section (if needed) -->
            @if(setting('contact_map_embed'))
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-map-marked-alt me-2"></i>
                                    Lokasi Kami
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="ratio ratio-16x9">
                                    {!! setting('contact_map_embed') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for message textarea
    const messageTextarea = document.getElementById('message');
    const maxLength = 2000;
    
    if (messageTextarea) {
        const helpText = messageTextarea.nextElementSibling;
        
        messageTextarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            helpText.textContent = `${currentLength}/${maxLength} karakter`;
            
            if (remaining < 100) {
                helpText.classList.add('text-warning');
            } else {
                helpText.classList.remove('text-warning');
            }
            
            if (remaining < 0) {
                helpText.classList.add('text-danger');
                helpText.classList.remove('text-warning');
            } else {
                helpText.classList.remove('text-danger');
            }
        });
    }
    
    // Form validation enhancement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        });
    }
});
</script>
@endpush
@endsection
