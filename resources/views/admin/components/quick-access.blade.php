@extends('admin.layouts.app')

@section('title', 'Quick Access Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Quick Access Management</h1>
            <p class="text-muted">Kelola layanan quick access yang tampil di floating button</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.components.index') }}">Components</a></li>
                <li class="breadcrumb-item active">Quick Access</li>
            </ol>
        </nav>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.components.quick-access.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- General Settings -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog me-2"></i>Pengaturan Umum
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Enable/Disable -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enabled" id="enabled" 
                                       {{ ($config['enabled'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enabled">
                                    Aktifkan Quick Access
                                </label>
                            </div>
                        </div>

                        <!-- Button Text -->
                        <div class="mb-3">
                            <label for="button_text" class="form-label fw-bold">Teks Tombol</label>
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                   id="button_text" name="button_text" 
                                   value="{{ old('button_text', $config['button_text'] ?? 'Layanan Cepat') }}"
                                   placeholder="Layanan Cepat">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="mb-3">
                            <label for="position" class="form-label fw-bold">Posisi</label>
                            <select class="form-select @error('position') is-invalid @enderror" id="position" name="position">
                                <option value="right" {{ ($config['position'] ?? 'right') === 'right' ? 'selected' : '' }}>Kanan</option>
                                <option value="left" {{ ($config['position'] ?? 'right') === 'left' ? 'selected' : '' }}>Kiri</option>
                            </select>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Test Button -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-info w-100" onclick="testQuickAccess()">
                                <i class="fas fa-vial me-2"></i>Test Quick Access
                            </button>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Simpan Pengaturan
                        </button>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-eye me-2"></i>Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <p class="mb-0 small" id="previewButtonText">{{ $config['button_text'] ?? 'Layanan Cepat' }}</p>
                            <small class="text-muted">Posisi: <span id="previewPosition">{{ ($config['position'] ?? 'right') === 'right' ? 'Kanan' : 'Kiri' }}</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Categories -->
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <!-- Academic Services -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <h6 class="mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>Layanan Akademik
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div id="academicServices">
                                    @foreach($config['academic_services'] ?? [] as $index => $service)
                                    <div class="service-item border-bottom p-3" data-index="{{ $index }}">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="background: {!! $service['color'] ?? '#667eea' !!}; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="{{ $service['icon'] ?? 'fas fa-cog' }} text-white small"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $service['title'] ?? '' }}</h6>
                                                <small class="text-muted">{{ $service['description'] ?? '' }}</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="academic_services[{{ $index }}][enabled]" 
                                                       {{ ($service['enabled'] ?? true) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <!-- Hidden inputs for service data -->
                                        <input type="hidden" name="academic_services[{{ $index }}][id]" value="{{ $service['id'] ?? '' }}">
                                        <input type="hidden" name="academic_services[{{ $index }}][title]" value="{{ $service['title'] ?? '' }}">
                                        <input type="hidden" name="academic_services[{{ $index }}][description]" value="{{ $service['description'] ?? '' }}">
                                        <input type="hidden" name="academic_services[{{ $index }}][icon]" value="{{ $service['icon'] ?? '' }}">
                                        <input type="hidden" name="academic_services[{{ $index }}][color]" value="{{ $service['color'] ?? '' }}">
                                        <input type="hidden" name="academic_services[{{ $index }}][url]" value="{{ $service['url'] ?? '' }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Services -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-users me-2"></i>Layanan Mahasiswa
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div id="studentServices">
                                    @foreach($config['student_services'] ?? [] as $index => $service)
                                    <div class="service-item border-bottom p-3" data-index="{{ $index }}">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="background: {!! $service['color'] ?? '#ffc107' !!}; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="{{ $service['icon'] ?? 'fas fa-cog' }} text-white small"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $service['title'] ?? '' }}</h6>
                                                <small class="text-muted">{{ $service['description'] ?? '' }}</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="student_services[{{ $index }}][enabled]" 
                                                       {{ ($service['enabled'] ?? true) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <!-- Hidden inputs for service data -->
                                        <input type="hidden" name="student_services[{{ $index }}][id]" value="{{ $service['id'] ?? '' }}">
                                        <input type="hidden" name="student_services[{{ $index }}][title]" value="{{ $service['title'] ?? '' }}">
                                        <input type="hidden" name="student_services[{{ $index }}][description]" value="{{ $service['description'] ?? '' }}">
                                        <input type="hidden" name="student_services[{{ $index }}][icon]" value="{{ $service['icon'] ?? '' }}">
                                        <input type="hidden" name="student_services[{{ $index }}][color]" value="{{ $service['color'] ?? '' }}">
                                        <input type="hidden" name="student_services[{{ $index }}][url]" value="{{ $service['url'] ?? '' }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Services -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Layanan Informasi
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div id="informationServices">
                                    @foreach($config['information_services'] ?? [] as $index => $service)
                                    <div class="service-item border-bottom p-3" data-index="{{ $index }}">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="background: {!! $service['color'] ?? '#28a745' !!}; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="{{ $service['icon'] ?? 'fas fa-cog' }} text-white small"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $service['title'] ?? '' }}</h6>
                                                <small class="text-muted">{{ $service['description'] ?? '' }}</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="information_services[{{ $index }}][enabled]" 
                                                       {{ ($service['enabled'] ?? true) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <!-- Hidden inputs for service data -->
                                        <input type="hidden" name="information_services[{{ $index }}][id]" value="{{ $service['id'] ?? '' }}">
                                        <input type="hidden" name="information_services[{{ $index }}][title]" value="{{ $service['title'] ?? '' }}">
                                        <input type="hidden" name="information_services[{{ $index }}][description]" value="{{ $service['description'] ?? '' }}">
                                        <input type="hidden" name="information_services[{{ $index }}][icon]" value="{{ $service['icon'] ?? '' }}">
                                        <input type="hidden" name="information_services[{{ $index }}][color]" value="{{ $service['color'] ?? '' }}">
                                        <input type="hidden" name="information_services[{{ $index }}][url]" value="{{ $service['url'] ?? '' }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Services -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-phone me-2"></i>Layanan Kontak
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div id="contactServices">
                                    @foreach($config['contact_services'] ?? [] as $index => $service)
                                    <div class="service-item border-bottom p-3" data-index="{{ $index }}">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="background: {!! $service['color'] ?? '#6c757d' !!}; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="{{ $service['icon'] ?? 'fas fa-cog' }} text-white small"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $service['title'] ?? '' }}</h6>
                                                <small class="text-muted">{{ $service['description'] ?? '' }}</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="contact_services[{{ $index }}][enabled]" 
                                                       {{ ($service['enabled'] ?? true) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <!-- Hidden inputs for service data -->
                                        <input type="hidden" name="contact_services[{{ $index }}][id]" value="{{ $service['id'] ?? '' }}">
                                        <input type="hidden" name="contact_services[{{ $index }}][title]" value="{{ $service['title'] ?? '' }}">
                                        <input type="hidden" name="contact_services[{{ $index }}][description]" value="{{ $service['description'] ?? '' }}">
                                        <input type="hidden" name="contact_services[{{ $index }}][icon]" value="{{ $service['icon'] ?? '' }}">
                                        <input type="hidden" name="contact_services[{{ $index }}][color]" value="{{ $service['color'] ?? '' }}">
                                        <input type="hidden" name="contact_services[{{ $index }}][url]" value="{{ $service['url'] ?? '' }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Test Result Modal -->
<div class="modal fade" id="testModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="testResult">
                <!-- Test result will be shown here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Update preview when inputs change
document.getElementById('button_text').addEventListener('input', function() {
    document.getElementById('previewButtonText').textContent = this.value || 'Layanan Cepat';
});

document.getElementById('position').addEventListener('change', function() {
    document.getElementById('previewPosition').textContent = this.value === 'right' ? 'Kanan' : 'Kiri';
});

// Test Quick Access functionality
function testQuickAccess() {
    // Show loading
    const modal = new bootstrap.Modal(document.getElementById('testModal'));
    document.getElementById('testResult').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Testing Quick Access...</p>
        </div>
    `;
    modal.show();

    // Simulate test
    setTimeout(() => {
        const enabled = document.getElementById('enabled').checked;
        const buttonText = document.getElementById('button_text').value || 'Layanan Cepat';
        const position = document.getElementById('position').value;
        
        let result = '';
        if (enabled) {
            result = `
                <div class="alert alert-success">
                    <h6><i class="fas fa-check-circle me-2"></i>Test Berhasil!</h6>
                    <ul class="mb-0">
                        <li>Status: Aktif</li>
                        <li>Teks Tombol: "${buttonText}"</li>
                        <li>Posisi: ${position === 'right' ? 'Kanan' : 'Kiri'}</li>
                        <li>Komponen siap digunakan</li>
                    </ul>
                </div>
            `;
        } else {
            result = `
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Komponen Nonaktif</h6>
                    <p class="mb-0">Quick Access sedang dinonaktifkan. Aktifkan untuk menampilkan di website.</p>
                </div>
            `;
        }
        
        document.getElementById('testResult').innerHTML = result;
    }, 1500);
}
</script>
@endpush
