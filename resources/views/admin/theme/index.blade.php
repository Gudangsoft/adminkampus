@extends('layouts.admin')

@section('title', 'Theme Customizer')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-palette"></i> Theme Customizer
        </h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-info" onclick="previewChanges()">
                <i class="fas fa-eye"></i> Preview
            </button>
            <button type="button" class="btn btn-warning" onclick="resetTheme()">
                <i class="fas fa-undo"></i> Reset
            </button>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i> Export/Import
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="exportTheme()">
                        <i class="fas fa-download"></i> Export Theme
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="document.getElementById('importFile').click()">
                        <i class="fas fa-upload"></i> Import Theme
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Hidden import file input -->
    <input type="file" id="importFile" accept=".json" style="display: none;" onchange="importTheme(this)">

    <div class="row">
        <!-- Theme Settings Panel -->
        <div class="col-lg-4">
            <div class="card shadow sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Theme Settings</h6>
                </div>
                <div class="card-body" style="max-height: 70vh; overflow-y: auto;">
                    <form id="themeForm">
                        @csrf
                        
                        <!-- Predefined Themes -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Quick Themes</h6>
                            <div class="row g-2">
                                @foreach($availableThemes as $themeKey => $theme)
                                <div class="col-6">
                                    <div class="theme-card {{ $currentTheme === $themeKey ? 'active' : '' }}" 
                                         data-theme="{{ $themeKey }}"
                                         onclick="applyTheme('{{ $themeKey }}')">
                                        <div class="theme-preview" 
                                             style="background: linear-gradient(135deg, {{ $theme['colors']['primary'] }} 0%, {{ $theme['colors']['secondary'] }} 100%);">
                                        </div>
                                        <small class="theme-name">{{ $theme['name'] }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        <!-- Color Settings -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Colors</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Primary Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           name="primary_color" value="{{ $themeSettings['colors']['primary_color']['value'] ?? '#667eea' }}">
                                    <input type="text" class="form-control" 
                                           value="{{ $themeSettings['colors']['primary_color']['value'] ?? '#667eea' }}" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Secondary Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           name="secondary_color" value="{{ $themeSettings['colors']['secondary_color']['value'] ?? '#764ba2' }}">
                                    <input type="text" class="form-control" 
                                           value="{{ $themeSettings['colors']['secondary_color']['value'] ?? '#764ba2' }}" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Success</label>
                                        <input type="color" class="form-control form-control-color" 
                                               name="success_color" value="{{ $themeSettings['colors']['success_color']['value'] ?? '#1cc88a' }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Info</label>
                                        <input type="color" class="form-control form-control-color" 
                                               name="info_color" value="{{ $themeSettings['colors']['info_color']['value'] ?? '#36b9cc' }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Warning</label>
                                        <input type="color" class="form-control form-control-color" 
                                               name="warning_color" value="{{ $themeSettings['colors']['warning_color']['value'] ?? '#f6c23e' }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Danger</label>
                                        <input type="color" class="form-control form-control-color" 
                                               name="danger_color" value="{{ $themeSettings['colors']['danger_color']['value'] ?? '#e74a3b' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Layout Settings -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Layout</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Sidebar Background</label>
                                <select class="form-select" name="sidebar_bg">
                                    <option value="gradient" {{ ($themeSettings['layout']['sidebar_bg']['value'] ?? 'gradient') === 'gradient' ? 'selected' : '' }}>Gradient</option>
                                    <option value="solid" {{ ($themeSettings['layout']['sidebar_bg']['value'] ?? 'gradient') === 'solid' ? 'selected' : '' }}>Solid Color</option>
                                    <option value="image" {{ ($themeSettings['layout']['sidebar_bg']['value'] ?? 'gradient') === 'image' ? 'selected' : '' }}>Background Image</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sidebar Theme</label>
                                        <select class="form-select" name="sidebar_variant">
                                            <option value="dark" {{ ($themeSettings['layout']['sidebar_variant']['value'] ?? 'dark') === 'dark' ? 'selected' : '' }}>Dark</option>
                                            <option value="light" {{ ($themeSettings['layout']['sidebar_variant']['value'] ?? 'dark') === 'light' ? 'selected' : '' }}>Light</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Topbar Theme</label>
                                        <select class="form-select" name="topbar_variant">
                                            <option value="light" {{ ($themeSettings['layout']['topbar_variant']['value'] ?? 'light') === 'light' ? 'selected' : '' }}>Light</option>
                                            <option value="dark" {{ ($themeSettings['layout']['topbar_variant']['value'] ?? 'light') === 'dark' ? 'selected' : '' }}>Dark</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Typography -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Typography</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Font Family</label>
                                <select class="form-select" name="font_family">
                                    <option value="Segoe UI" {{ ($themeSettings['typography']['font_family']['value'] ?? 'Segoe UI') === 'Segoe UI' ? 'selected' : '' }}>Segoe UI</option>
                                    <option value="Inter" {{ ($themeSettings['typography']['font_family']['value'] ?? 'Segoe UI') === 'Inter' ? 'selected' : '' }}>Inter</option>
                                    <option value="Roboto" {{ ($themeSettings['typography']['font_family']['value'] ?? 'Segoe UI') === 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                    <option value="Open Sans" {{ ($themeSettings['typography']['font_family']['value'] ?? 'Segoe UI') === 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                                    <option value="Lato" {{ ($themeSettings['typography']['font_family']['value'] ?? 'Segoe UI') === 'Lato' ? 'selected' : '' }}>Lato</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Font Size</label>
                                <select class="form-select" name="font_size">
                                    <option value="12px" {{ ($themeSettings['typography']['font_size']['value'] ?? '14px') === '12px' ? 'selected' : '' }}>Small (12px)</option>
                                    <option value="14px" {{ ($themeSettings['typography']['font_size']['value'] ?? '14px') === '14px' ? 'selected' : '' }}>Medium (14px)</option>
                                    <option value="16px" {{ ($themeSettings['typography']['font_size']['value'] ?? '14px') === '16px' ? 'selected' : '' }}>Large (16px)</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <!-- Visual Effects -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Visual Effects</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Border Radius</label>
                                <select class="form-select" name="border_radius">
                                    <option value="0px" {{ ($themeSettings['layout']['border_radius']['value'] ?? '10px') === '0px' ? 'selected' : '' }}>Square (0px)</option>
                                    <option value="5px" {{ ($themeSettings['layout']['border_radius']['value'] ?? '10px') === '5px' ? 'selected' : '' }}>Small (5px)</option>
                                    <option value="10px" {{ ($themeSettings['layout']['border_radius']['value'] ?? '10px') === '10px' ? 'selected' : '' }}>Medium (10px)</option>
                                    <option value="15px" {{ ($themeSettings['layout']['border_radius']['value'] ?? '10px') === '15px' ? 'selected' : '' }}>Large (15px)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Box Shadow</label>
                                <select class="form-select" name="box_shadow">
                                    <option value="none" {{ ($themeSettings['layout']['box_shadow']['value'] ?? 'default') === 'none' ? 'selected' : '' }}>None</option>
                                    <option value="small" {{ ($themeSettings['layout']['box_shadow']['value'] ?? 'default') === 'small' ? 'selected' : '' }}>Small</option>
                                    <option value="default" {{ ($themeSettings['layout']['box_shadow']['value'] ?? 'default') === 'default' ? 'selected' : '' }}>Default</option>
                                    <option value="large" {{ ($themeSettings['layout']['box_shadow']['value'] ?? 'default') === 'large' ? 'selected' : '' }}>Large</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Animation Speed</label>
                                <select class="form-select" name="animation_speed">
                                    <option value="0.1s" {{ ($themeSettings['general']['animation_speed']['value'] ?? '0.3s') === '0.1s' ? 'selected' : '' }}>Fast (0.1s)</option>
                                    <option value="0.3s" {{ ($themeSettings['general']['animation_speed']['value'] ?? '0.3s') === '0.3s' ? 'selected' : '' }}>Normal (0.3s)</option>
                                    <option value="0.5s" {{ ($themeSettings['general']['animation_speed']['value'] ?? '0.3s') === '0.5s' ? 'selected' : '' }}>Slow (0.5s)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Save Theme Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Live Preview Panel -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Live Preview</h6>
                    <div class="preview-controls">
                        <button class="btn btn-sm btn-outline-primary" onclick="togglePreviewMode('desktop')">
                            <i class="fas fa-desktop"></i> Desktop
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="togglePreviewMode('tablet')">
                            <i class="fas fa-tablet-alt"></i> Tablet
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="togglePreviewMode('mobile')">
                            <i class="fas fa-mobile-alt"></i> Mobile
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="themePreview" class="theme-preview-container" data-mode="desktop">
                        <iframe id="previewFrame" 
                                src="{{ route('admin.dashboard') }}" 
                                width="100%" 
                                height="600px" 
                                frameborder="0"
                                class="rounded-bottom">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Theme Components Preview -->
            <div class="card shadow mt-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Components Preview</h6>
                </div>
                <div class="card-body" id="componentPreview">
                    <div class="row">
                        <!-- Buttons -->
                        <div class="col-md-6 mb-4">
                            <h6>Buttons</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-primary">Primary</button>
                                <button class="btn btn-secondary">Secondary</button>
                                <button class="btn btn-success">Success</button>
                                <button class="btn btn-info">Info</button>
                                <button class="btn btn-warning">Warning</button>
                                <button class="btn btn-danger">Danger</button>
                            </div>
                        </div>

                        <!-- Cards -->
                        <div class="col-md-6 mb-4">
                            <h6>Cards</h6>
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie"></i> Sample Card
                                </div>
                                <div class="card-body">
                                    <p class="card-text">This is a sample card to preview the theme styling.</p>
                                    <a href="#" class="btn btn-primary btn-sm">Action</a>
                                </div>
                            </div>
                        </div>

                        <!-- Alerts -->
                        <div class="col-md-6 mb-4">
                            <h6>Alerts</h6>
                            <div class="alert alert-primary" role="alert">
                                <i class="fas fa-info-circle"></i> Primary alert message
                            </div>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle"></i> Success alert message
                            </div>
                        </div>

                        <!-- Form Elements -->
                        <div class="col-md-6 mb-4">
                            <h6>Form Elements</h6>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Text input">
                            </div>
                            <div class="mb-3">
                                <select class="form-select">
                                    <option>Select option</option>
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .theme-card {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 10px;
        padding: 8px;
        transition: all 0.3s ease;
        background: white;
    }
    
    .theme-card:hover {
        border-color: #0d6efd;
        transform: translateY(-2px);
    }
    
    .theme-card.active {
        border-color: #0d6efd;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    
    .theme-preview {
        height: 40px;
        border-radius: 6px;
        margin-bottom: 8px;
        position: relative;
        overflow: hidden;
    }
    
    .theme-preview::after {
        content: '';
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        height: 15px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }
    
    .theme-name {
        display: block;
        text-align: center;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.75rem;
    }
    
    .form-control-color {
        width: 50px;
        height: 38px;
        border: 1px solid #ced4da;
    }
    
    .theme-preview-container[data-mode="tablet"] #previewFrame {
        width: 768px;
        max-width: 100%;
        margin: 0 auto;
        display: block;
    }
    
    .theme-preview-container[data-mode="mobile"] #previewFrame {
        width: 375px;
        max-width: 100%;
        margin: 0 auto;
        display: block;
    }
    
    .preview-controls .btn.active {
        background-color: #0d6efd;
        color: white;
    }
    
    #componentPreview {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    const themeForm = document.getElementById('themeForm');
    if (themeForm) {
        themeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/admin/theme/settings', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        // Refresh preview
                        document.getElementById('previewFrame').src = document.getElementById('previewFrame').src;
                        updateComponentPreview();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while saving theme settings', 'error');
            });
        });
    }
    
    // Handle color input changes
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', function() {
            const textInput = this.parentElement.querySelector('input[type="text"]');
            if (textInput) {
                textInput.value = this.value;
            }
            updateComponentPreview();
        });
    });
    
    // Handle other input changes
    document.querySelectorAll('select, input').forEach(input => {
        input.addEventListener('change', function() {
            updateComponentPreview();
        });
    });
});

function applyTheme(themeName) {
    fetch('/admin/theme/apply', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ theme: themeName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success!', data.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while applying theme', 'error');
    });
}

function resetTheme() {
    Swal.fire({
        title: 'Reset Theme?',
        text: 'This will reset all theme settings to default values.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/admin/theme/reset', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Reset!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while resetting theme', 'error');
            });
        }
    });
}

function exportTheme() {
    window.open('/admin/theme/export', '_blank');
}

function importTheme(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('theme_file', input.files[0]);
        
        fetch('/admin/theme/import', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Success!', data.message, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error!', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'An error occurred while importing theme', 'error');
        });
    }
}

function previewChanges() {
    const formData = new FormData(document.getElementById('themeForm'));
    
    fetch('/admin/theme/preview', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Apply preview CSS
            let styleEl = document.getElementById('previewStyles');
            if (!styleEl) {
                styleEl = document.createElement('style');
                styleEl.id = 'previewStyles';
                document.head.appendChild(styleEl);
            }
            styleEl.textContent = data.css;
            
            Swal.fire('Preview Updated!', 'You can see the changes in the preview panel.', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while generating preview', 'error');
    });
}

function togglePreviewMode(mode) {
    const container = document.getElementById('themePreview');
    const buttons = document.querySelectorAll('.preview-controls .btn');
    
    container.setAttribute('data-mode', mode);
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('.btn').classList.add('active');
}

function updateComponentPreview() {
    const formData = new FormData(document.getElementById('themeForm'));
    const settings = {};
    
    for (let [key, value] of formData.entries()) {
        settings[key] = value;
    }
    
    // Apply changes to component preview
    const componentPreview = document.getElementById('componentPreview');
    const root = document.documentElement;
    
    if (settings.primary_color) {
        root.style.setProperty('--bs-primary', settings.primary_color);
    }
    if (settings.secondary_color) {
        root.style.setProperty('--bs-secondary', settings.secondary_color);
    }
    if (settings.success_color) {
        root.style.setProperty('--bs-success', settings.success_color);
    }
    if (settings.info_color) {
        root.style.setProperty('--bs-info', settings.info_color);
    }
    if (settings.warning_color) {
        root.style.setProperty('--bs-warning', settings.warning_color);
    }
    if (settings.danger_color) {
        root.style.setProperty('--bs-danger', settings.danger_color);
    }
}
</script>
@endpush
