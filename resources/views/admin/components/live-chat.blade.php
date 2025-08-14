@extends('admin.layouts.app')

@section('title', 'Live Chat Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Live Chat Management</h1>
            <p class="text-muted">Kelola widget live chat dan auto responses</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.components.index') }}">Components</a></li>
                <li class="breadcrumb-item active">Live Chat</li>
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

    <form action="{{ route('admin.components.live-chat.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- General Settings -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
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
                                    Aktifkan Live Chat
                                </label>
                            </div>
                        </div>

                        <!-- Button Text -->
                        <div class="mb-3">
                            <label for="button_text" class="form-label fw-bold">Teks Tombol</label>
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                   id="button_text" name="button_text" 
                                   value="{{ old('button_text', $config['button_text'] ?? 'Butuh Bantuan?') }}"
                                   placeholder="Butuh Bantuan?">
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

                        <!-- Welcome Message -->
                        <div class="mb-3">
                            <label for="welcome_message" class="form-label fw-bold">Welcome Message</label>
                            <textarea class="form-control @error('welcome_message') is-invalid @enderror" 
                                      id="welcome_message" name="welcome_message" rows="3"
                                      placeholder="Halo! Ada yang bisa saya bantu?">{{ old('welcome_message', $config['welcome_message'] ?? 'Halo! Ada yang bisa saya bantu?') }}</textarea>
                            @error('welcome_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Test Chat -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Test Chat</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="testMessage" placeholder="Ketik pesan test...">
                                <button type="button" class="btn btn-outline-info" onclick="testLiveChat()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button type="submit" class="btn btn-success w-100">
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
                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-comments"></i>
                            </div>
                            <p class="mb-1 small" id="previewButtonText">{{ $config['button_text'] ?? 'Butuh Bantuan?' }}</p>
                            <small class="text-muted d-block">Posisi: <span id="previewPosition">{{ ($config['position'] ?? 'right') === 'right' ? 'Kanan' : 'Kiri' }}</span></small>
                            <div class="bg-light p-2 rounded mt-2">
                                <small class="text-muted d-block">Welcome:</small>
                                <small id="previewWelcome">{{ Str::limit($config['welcome_message'] ?? 'Halo! Ada yang bisa saya bantu?', 50) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auto Responses -->
            <div class="col-lg-8 col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-robot me-2"></i>Auto Responses
                        </h5>
                        <button type="button" class="btn btn-sm btn-dark" onclick="addAutoResponse()">
                            <i class="fas fa-plus me-1"></i>Tambah Response
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="autoResponses">
                            @foreach($config['auto_responses'] ?? [] as $index => $response)
                            <div class="response-item border rounded p-3 mb-3" data-index="{{ $index }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 text-primary">Response #{{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeResponse(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Keyword</label>
                                        <input type="text" class="form-control form-control-sm" 
                                               name="auto_responses[{{ $index }}][keyword]" 
                                               value="{{ $response['keyword'] ?? '' }}"
                                               placeholder="contoh: pendaftaran">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold">Response</label>
                                        <textarea class="form-control form-control-sm" rows="2"
                                                  name="auto_responses[{{ $index }}][response]" 
                                                  placeholder="Response yang akan dikirim...">{{ $response['response'] ?? '' }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                            onclick="testResponse('{{ $response['keyword'] ?? '' }}', '{{ addslashes($response['response'] ?? '') }}')">
                                        <i class="fas fa-vial me-1"></i>Test
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if(empty($config['auto_responses']))
                        <div class="text-center py-4" id="emptyState">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada auto response</h6>
                            <p class="text-muted small">Tambahkan keyword dan response untuk membantu pengunjung secara otomatis</p>
                            <button type="button" class="btn btn-warning" onclick="addAutoResponse()">
                                <i class="fas fa-plus me-1"></i>Tambah Response Pertama
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Chat Simulator -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-comments me-2"></i>Chat Simulator
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chat-simulator" style="height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: #f8f9fa;">
                            <div class="bot-message mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; flex-shrink: 0;">
                                        <i class="fas fa-robot small"></i>
                                    </div>
                                    <div class="bg-white p-2 rounded shadow-sm">
                                        <p class="mb-0 small" id="simulatorWelcome">{{ $config['welcome_message'] ?? 'Halo! Ada yang bisa saya bantu?' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div id="chatMessages"></div>
                        </div>
                        <div class="mt-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="chatInput" placeholder="Ketik pesan..." onkeypress="if(event.key==='Enter') sendMessage()">
                                <button type="button" class="btn btn-primary" onclick="sendMessage()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
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
let responseIndex = {{ count($config['auto_responses'] ?? []) }};

// Update preview when inputs change
document.getElementById('button_text').addEventListener('input', function() {
    document.getElementById('previewButtonText').textContent = this.value || 'Butuh Bantuan?';
});

document.getElementById('position').addEventListener('change', function() {
    document.getElementById('previewPosition').textContent = this.value === 'right' ? 'Kanan' : 'Kiri';
});

document.getElementById('welcome_message').addEventListener('input', function() {
    const text = this.value || 'Halo! Ada yang bisa saya bantu?';
    document.getElementById('previewWelcome').textContent = text.substring(0, 50) + (text.length > 50 ? '...' : '');
    document.getElementById('simulatorWelcome').textContent = text;
});

// Add new auto response
function addAutoResponse() {
    const container = document.getElementById('autoResponses');
    const emptyState = document.getElementById('emptyState');
    
    if (emptyState) {
        emptyState.style.display = 'none';
    }
    
    const responseHtml = `
        <div class="response-item border rounded p-3 mb-3" data-index="${responseIndex}">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="mb-0 text-primary">Response #${responseIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeResponse(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Keyword</label>
                    <input type="text" class="form-control form-control-sm" 
                           name="auto_responses[${responseIndex}][keyword]" 
                           placeholder="contoh: pendaftaran">
                </div>
                <div class="col-md-8">
                    <label class="form-label small fw-bold">Response</label>
                    <textarea class="form-control form-control-sm" rows="2"
                              name="auto_responses[${responseIndex}][response]" 
                              placeholder="Response yang akan dikirim..."></textarea>
                </div>
            </div>
            
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-info" 
                        onclick="testCurrentResponse(this)">
                    <i class="fas fa-vial me-1"></i>Test
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', responseHtml);
    responseIndex++;
}

// Remove auto response
function removeResponse(button) {
    const responseItem = button.closest('.response-item');
    responseItem.remove();
    
    // Show empty state if no responses left
    const container = document.getElementById('autoResponses');
    const emptyState = document.getElementById('emptyState');
    
    if (container.children.length === 0 && emptyState) {
        emptyState.style.display = 'block';
    }
}

// Test specific response
function testResponse(keyword, response) {
    const modal = new bootstrap.Modal(document.getElementById('testModal'));
    document.getElementById('testResult').innerHTML = `
        <div class="alert alert-info">
            <h6><i class="fas fa-vial me-2"></i>Test Response</h6>
            <p><strong>Keyword:</strong> "${keyword}"</p>
            <p><strong>Response:</strong> "${response}"</p>
        </div>
    `;
    modal.show();
}

// Test current response being edited
function testCurrentResponse(button) {
    const responseItem = button.closest('.response-item');
    const keyword = responseItem.querySelector('input[name*="[keyword]"]').value;
    const response = responseItem.querySelector('textarea[name*="[response]"]').value;
    
    if (!keyword || !response) {
        alert('Mohon isi keyword dan response terlebih dahulu');
        return;
    }
    
    testResponse(keyword, response);
}

// Test live chat functionality
function testLiveChat() {
    const message = document.getElementById('testMessage').value;
    if (!message) {
        alert('Mohon masukkan pesan test');
        return;
    }
    
    // Simulate finding response
    const responses = Array.from(document.querySelectorAll('.response-item')).map(item => ({
        keyword: item.querySelector('input[name*="[keyword]"]').value,
        response: item.querySelector('textarea[name*="[response]"]').value
    }));
    
    let foundResponse = null;
    for (const resp of responses) {
        if (resp.keyword && message.toLowerCase().includes(resp.keyword.toLowerCase())) {
            foundResponse = resp.response;
            break;
        }
    }
    
    const modal = new bootstrap.Modal(document.getElementById('testModal'));
    let result = '';
    
    if (foundResponse) {
        result = `
            <div class="alert alert-success">
                <h6><i class="fas fa-check-circle me-2"></i>Response Ditemukan!</h6>
                <p><strong>Pesan:</strong> "${message}"</p>
                <p><strong>Response:</strong> "${foundResponse}"</p>
            </div>
        `;
    } else {
        result = `
            <div class="alert alert-warning">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Tidak Ada Response</h6>
                <p><strong>Pesan:</strong> "${message}"</p>
                <p>Tidak ditemukan keyword yang cocok. Bot akan mengirim response default.</p>
            </div>
        `;
    }
    
    document.getElementById('testResult').innerHTML = result;
    modal.show();
}

// Chat simulator
function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    const chatMessages = document.getElementById('chatMessages');
    
    // Add user message
    const userMessage = `
        <div class="user-message mb-3">
            <div class="d-flex align-items-start justify-content-end">
                <div class="bg-primary text-white p-2 rounded shadow-sm me-2">
                    <p class="mb-0 small">${message}</p>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; flex-shrink: 0;">
                    <i class="fas fa-user small"></i>
                </div>
            </div>
        </div>
    `;
    
    chatMessages.insertAdjacentHTML('beforeend', userMessage);
    
    // Find response
    const responses = Array.from(document.querySelectorAll('.response-item')).map(item => ({
        keyword: item.querySelector('input[name*="[keyword]"]').value,
        response: item.querySelector('textarea[name*="[response]"]').value
    }));
    
    let foundResponse = 'Maaf, saya belum bisa memahami pertanyaan Anda. Silakan hubungi admin untuk bantuan lebih lanjut.';
    
    for (const resp of responses) {
        if (resp.keyword && message.toLowerCase().includes(resp.keyword.toLowerCase())) {
            foundResponse = resp.response;
            break;
        }
    }
    
    // Add bot response with delay
    setTimeout(() => {
        const botMessage = `
            <div class="bot-message mb-3">
                <div class="d-flex align-items-start">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; flex-shrink: 0;">
                        <i class="fas fa-robot small"></i>
                    </div>
                    <div class="bg-white p-2 rounded shadow-sm">
                        <p class="mb-0 small">${foundResponse}</p>
                    </div>
                </div>
            </div>
        `;
        
        chatMessages.insertAdjacentHTML('beforeend', botMessage);
        
        // Scroll to bottom
        const chatContainer = chatMessages.parentElement;
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }, 500);
    
    input.value = '';
    
    // Scroll to bottom
    const chatContainer = chatMessages.parentElement;
    chatContainer.scrollTop = chatContainer.scrollHeight;
}
</script>
@endpush
