<!-- Footer -->
<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="fw-bold mb-3">{{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}</h5>
                <p class="mb-3">{{ $globalSettings['site_description'] ?? 'Kampus modern untuk masa depan cemerlang' }}</p>
                
                @if(($globalSettings['social_facebook'] ?? false) || ($globalSettings['social_twitter'] ?? false) || ($globalSettings['social_instagram'] ?? false) || ($globalSettings['social_youtube'] ?? false))
                    <div class="d-flex gap-3">
                        @if($globalSettings['social_facebook'] ?? false)
                            <a href="{{ $globalSettings['social_facebook'] }}" class="text-light" target="_blank">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                        @endif
                        @if($globalSettings['social_twitter'] ?? false)
                            <a href="{{ $globalSettings['social_twitter'] }}" class="text-light" target="_blank">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                        @endif
                        @if($globalSettings['social_instagram'] ?? false)
                            <a href="{{ $globalSettings['social_instagram'] }}" class="text-light" target="_blank">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        @endif
                        @if($globalSettings['social_youtube'] ?? false)
                            <a href="{{ $globalSettings['social_youtube'] }}" class="text-light" target="_blank">
                                <i class="fab fa-youtube fa-lg"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                <ul class="list-unstyled">
                    @if($globalSettings['contact_address'] ?? false)
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $globalSettings['contact_address'] }}
                        </li>
                    @endif
                    @if($globalSettings['contact_phone'] ?? false)
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:{{ $globalSettings['contact_phone'] }}" class="text-light text-decoration-none">
                                {{ $globalSettings['contact_phone'] }}
                            </a>
                        </li>
                    @endif
                    @if($globalSettings['contact_email'] ?? false)
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:{{ $globalSettings['contact_email'] }}" class="text-light text-decoration-none">
                                {{ $globalSettings['contact_email'] }}
                            </a>
                        </li>
                    @endif
                    @if($globalSettings['contact_whatsapp'] ?? false)
                        <li class="mb-2">
                            <i class="fab fa-whatsapp me-2"></i>
                            <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $globalSettings['contact_whatsapp']) }}" class="text-light text-decoration-none" target="_blank">
                                {{ $globalSettings['contact_whatsapp'] }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="fw-bold mb-3">Menu Cepat</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('pages.show', 'tentang-kami') }}" class="text-light text-decoration-none">Tentang</a></li>
                    <li class="mb-2"><a href="{{ route('news.index') }}" class="text-light text-decoration-none">Berita</a></li>
                    <li class="mb-2"><a href="{{ route('announcements.index') }}" class="text-light text-decoration-none">Pengumuman</a></li>
                    <li class="mb-2"><a href="{{ route('program-studi.index') }}" class="text-light text-decoration-none">Program Studi</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-12 mb-4">
                <h6 class="fw-bold mb-3">Layanan Akademik</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Portal Mahasiswa</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">E-Learning</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Perpustakaan Digital</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Sistem Informasi</a></li>
                    <li class="mb-2"><a href="{{ route('gallery.index') }}" class="text-light text-decoration-none">Galeri</a></li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4 border-secondary">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $globalSettings['site_name'] ?? 'G0-CAMPUS' }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                @if($globalSettings['contact_website'] ?? false)
                    <a href="{{ $globalSettings['contact_website'] }}" class="text-light text-decoration-none me-3" target="_blank">
                        <i class="fas fa-globe me-1"></i> Website Resmi
                    </a>
                @endif
                <a href="{{ route('pages.show', 'kontak') }}" class="text-light text-decoration-none">
                    <i class="fas fa-envelope me-1"></i> Kontak
                </a>
            </div>
        </div>
    </div>
</footer>
