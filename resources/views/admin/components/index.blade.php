@extends('admin.layouts.app')

@section('title', 'Component Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Component Management</h1>
            <p class="text-muted">Kelola komponen floating buttons dan fitur interaktif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Components</li>
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

    <!-- Component Cards -->
    <div class="row">
        <!-- Quick Access Component -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-rocket me-2"></i>
                        <h5 class="mb-0">Quick Access</h5>
                        <div class="ms-auto">
                            @if($quickAccessConfig['enabled'] ?? true)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Floating button untuk akses cepat ke layanan kampus seperti pendaftaran, jadwal, dan informasi penting lainnya.
                    </p>
                    
                    <!-- Quick Stats -->
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">{{ count($quickAccessConfig['academic_services'] ?? []) + count($quickAccessConfig['student_services'] ?? []) }}</h4>
                                <small class="text-muted">Total Services</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ ($quickAccessConfig['position'] ?? 'right') === 'right' ? 'Kanan' : 'Kiri' }}</h4>
                            <small class="text-muted">Posisi</small>
                        </div>
                    </div>

                    <!-- Service Categories Preview -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Kategori Layanan:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if(!empty($quickAccessConfig['academic_services']))
                                <span class="badge bg-info">Akademik ({{ count($quickAccessConfig['academic_services']) }})</span>
                            @endif
                            @if(!empty($quickAccessConfig['student_services']))
                                <span class="badge bg-warning">Mahasiswa ({{ count($quickAccessConfig['student_services']) }})</span>
                            @endif
                            @if(!empty($quickAccessConfig['information_services']))
                                <span class="badge bg-success">Informasi ({{ count($quickAccessConfig['information_services']) }})</span>
                            @endif
                            @if(!empty($quickAccessConfig['contact_services']))
                                <span class="badge bg-secondary">Kontak ({{ count($quickAccessConfig['contact_services']) }})</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.components.quick-access') }}" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-cog me-1"></i>Kelola
                        </a>
                        <button class="btn btn-outline-info btn-sm" onclick="previewQuickAccess()">
                            <i class="fas fa-eye me-1"></i>Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Chat Component -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-comments me-2"></i>
                        <h5 class="mb-0">Live Chat</h5>
                        <div class="ms-auto">
                            @if($liveChatConfig['enabled'] ?? true)
                                <span class="badge bg-light text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Widget chat untuk memberikan bantuan dan support kepada pengunjung website secara real-time.
                    </p>
                    
                    <!-- Quick Stats -->
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-success mb-0">{{ count($liveChatConfig['auto_responses'] ?? []) }}</h4>
                                <small class="text-muted">Auto Responses</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-0">{{ ($liveChatConfig['position'] ?? 'right') === 'right' ? 'Kanan' : 'Kiri' }}</h4>
                            <small class="text-muted">Posisi</small>
                        </div>
                    </div>

                    <!-- Welcome Message Preview -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Welcome Message:</h6>
                        <div class="bg-light p-2 rounded">
                            <small class="text-muted">{{ Str::limit($liveChatConfig['welcome_message'] ?? 'Halo! Ada yang bisa saya bantu?', 80) }}</small>
                        </div>
                    </div>

                    <!-- Auto Response Keywords -->
                    @if(!empty($liveChatConfig['auto_responses']))
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Keywords:</h6>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(array_slice($liveChatConfig['auto_responses'], 0, 5) as $response)
                                <span class="badge bg-light text-dark">{{ $response['keyword'] }}</span>
                            @endforeach
                            @if(count($liveChatConfig['auto_responses']) > 5)
                                <span class="badge bg-secondary">+{{ count($liveChatConfig['auto_responses']) - 5 }} more</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.components.live-chat') }}" class="btn btn-success btn-sm flex-fill">
                            <i class="fas fa-cog me-1"></i>Kelola
                        </a>
                        <button class="btn btn-outline-info btn-sm" onclick="previewLiveChat()">
                            <i class="fas fa-eye me-1"></i>Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Component Status Overview -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Component Status Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="border-end text-center py-3">
                                <h3 class="text-primary mb-1">{{ ($quickAccessConfig['enabled'] ?? true) ? '✓' : '✗' }}</h3>
                                <p class="mb-0 text-muted">Quick Access</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="border-end text-center py-3">
                                <h3 class="text-success mb-1">{{ ($liveChatConfig['enabled'] ?? true) ? '✓' : '✗' }}</h3>
                                <p class="mb-0 text-muted">Live Chat</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="border-end text-center py-3">
                                <h3 class="text-info mb-1">{{ count($quickAccessConfig['academic_services'] ?? []) + count($quickAccessConfig['student_services'] ?? []) + count($quickAccessConfig['information_services'] ?? []) + count($quickAccessConfig['contact_services'] ?? []) }}</h3>
                                <p class="mb-0 text-muted">Total Services</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="text-center py-3">
                                <h3 class="text-warning mb-1">{{ count($liveChatConfig['auto_responses'] ?? []) }}</h3>
                                <p class="mb-0 text-muted">Auto Responses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted mb-3">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                    <ul class="text-muted mb-0 small">
                        <li><strong>Quick Access:</strong> Komponen floating button yang memungkinkan pengunjung mengakses layanan kampus dengan cepat</li>
                        <li><strong>Live Chat:</strong> Widget chat otomatis yang membantu pengunjung dengan response yang telah dikonfigurasi</li>
                        <li><strong>Posisi:</strong> Kedua komponen dapat ditempatkan di sisi kiri atau kanan halaman</li>
                        <li><strong>Status:</strong> Komponen dapat diaktifkan atau dinonaktifkan tanpa menghapus konfigurasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Component Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewQuickAccess() {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    document.querySelector('#previewModal .modal-title').textContent = 'Quick Access Preview';
    document.getElementById('previewContent').innerHTML = `
        <div class="text-center">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="fas fa-rocket fa-lg"></i>
            </div>
            <h5 class="mt-3">{{ $quickAccessConfig['button_text'] ?? 'Layanan Cepat' }}</h5>
            <p class="text-muted">Floating button akan muncul di sisi {{ ($quickAccessConfig['position'] ?? 'right') === 'right' ? 'kanan' : 'kiri' }} halaman</p>
            <div class="mt-4">
                <p class="small text-muted">Preview fitur akan tersedia di frontend website</p>
                <a href="{{ url('/') }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-external-link-alt me-1"></i>Lihat di Website
                </a>
            </div>
        </div>
    `;
    modal.show();
}

function previewLiveChat() {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    document.querySelector('#previewModal .modal-title').textContent = 'Live Chat Preview';
    document.getElementById('previewContent').innerHTML = `
        <div class="text-center">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="fas fa-comments fa-lg"></i>
            </div>
            <h5 class="mt-3">{{ $liveChatConfig['button_text'] ?? 'Butuh Bantuan?' }}</h5>
            <p class="text-muted">Chat widget akan muncul di sisi {{ ($liveChatConfig['position'] ?? 'right') === 'right' ? 'kanan' : 'kiri' }} halaman</p>
            <div class="bg-light p-3 rounded mt-3">
                <small class="text-muted d-block mb-2">Welcome Message:</small>
                <p class="mb-0">"{{ $liveChatConfig['welcome_message'] ?? 'Halo! Ada yang bisa saya bantu?' }}"</p>
            </div>
            <div class="mt-4">
                <p class="small text-muted">Preview fitur akan tersedia di frontend website</p>
                <a href="{{ url('/') }}" target="_blank" class="btn btn-success btn-sm">
                    <i class="fas fa-external-link-alt me-1"></i>Lihat di Website
                </a>
            </div>
        </div>
    `;
    modal.show();
}
</script>
@endpush
