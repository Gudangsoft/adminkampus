@extends('layouts.admin')

@section('title', 'Multi-language Management')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-language"></i> Multi-language Management
        </h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-info" onclick="scanTranslations()">
                <i class="fas fa-search"></i> Scan Missing
            </button>
            <button type="button" class="btn btn-success" onclick="createMissingTranslations()">
                <i class="fas fa-plus"></i> Create Missing
            </button>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="exportLanguage('id')">
                        🇮🇩 Export Indonesian
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportLanguage('en')">
                        🇺🇸 Export English
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Language Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Current Language Settings</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Current System Language</label>
                            <div class="d-flex align-items-center gap-3">
                                @foreach($languages as $code => $language)
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="current_language" 
                                           id="lang_{{ $code }}" 
                                           value="{{ $code }}"
                                           {{ $currentLanguage === $code ? 'checked' : '' }}
                                           onchange="switchLanguage('{{ $code }}')">
                                    <label class="form-check-label" for="lang_{{ $code }}">
                                        {{ $language['flag'] }} {{ $language['native'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Translation Statistics</label>
                            <div class="d-flex gap-3">
                                @foreach($languages as $code => $language)
                                @php
                                    $langTranslations = $code === $currentLanguage ? $translations : [];
                                    $totalKeys = count(\Illuminate\Support\Arr::dot($langTranslations));
                                @endphp
                                <div class="text-center">
                                    <div class="h4 text-primary mb-1">{{ $totalKeys }}</div>
                                    <small class="text-muted">{{ $language['flag'] }} {{ $language['name'] }}</small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Tabs -->
    <div class="card shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="languageTabs" role="tablist">
                @foreach($languages as $code => $language)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $currentLanguage === $code ? 'active' : '' }}" 
                            id="tab-{{ $code }}" 
                            data-bs-toggle="tab" 
                            data-bs-target="#pane-{{ $code }}" 
                            type="button" 
                            role="tab">
                        {{ $language['flag'] }} {{ $language['name'] }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="languageTabsContent">
                @foreach($languages as $code => $language)
                <div class="tab-pane fade {{ $currentLanguage === $code ? 'show active' : '' }}" 
                     id="pane-{{ $code }}" 
                     role="tabpanel">
                     
                    <!-- Add New Translation -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-plus"></i> Add New Translation for {{ $language['native'] }}
                                    </h6>
                                    <form class="add-translation-form" data-language="{{ $code }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="key" 
                                                       placeholder="Translation key (e.g., menu.home)" 
                                                       required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="value" 
                                                       placeholder="Translation value" 
                                                       required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-plus"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Import Translations -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-upload"></i> Import Translations for {{ $language['native'] }}
                                    </h6>
                                    <form class="import-form" data-language="{{ $code }}">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="file" 
                                                       accept=".json" 
                                                       required>
                                                <small class="form-text text-white-50">Upload JSON file with translations</small>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-light w-100">
                                                    <i class="fas fa-upload"></i> Import
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Translations Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered translations-table" id="table-{{ $code }}">
                            <thead>
                                <tr>
                                    <th width="30%">Translation Key</th>
                                    <th width="50%">Value</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($code === $currentLanguage)
                                    @foreach(\Illuminate\Support\Arr::dot($translations) as $key => $value)
                                    <tr data-key="{{ $key }}">
                                        <td>
                                            <code>{{ $key }}</code>
                                        </td>
                                        <td>
                                            <div class="translation-value" data-key="{{ $key }}" data-language="{{ $code }}">
                                                {{ $value }}
                                            </div>
                                            <div class="translation-edit" style="display: none;">
                                                <textarea class="form-control" rows="2">{{ $value }}</textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-primary edit-translation" 
                                                        data-key="{{ $key }}" 
                                                        data-language="{{ $code }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success save-translation" 
                                                        data-key="{{ $key }}" 
                                                        data-language="{{ $code }}" 
                                                        style="display: none;">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                                <button class="btn btn-sm btn-secondary cancel-edit" 
                                                        data-key="{{ $key }}" 
                                                        data-language="{{ $code }}" 
                                                        style="display: none;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-translation" 
                                                        data-key="{{ $key }}" 
                                                        data-language="{{ $code }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle"></i>
                                            Switch to this language tab to view and edit translations
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Missing Translations Modal -->
    <div class="modal fade" id="missingTranslationsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-search"></i> Missing Translations
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="missingTranslationsContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createMissingTranslations()">
                        Create All Missing
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .translations-table {
        font-size: 0.9rem;
    }
    
    .translation-value {
        cursor: pointer;
        padding: 5px;
        border-radius: 3px;
        transition: background-color 0.3s;
    }
    
    .translation-value:hover {
        background-color: #f8f9fa;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
        font-size: 0.85em;
    }
    
    .nav-tabs .nav-link {
        border-bottom: 2px solid transparent;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom-color: #0d6efd;
        background-color: transparent;
    }
    
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle adding new translations
    document.querySelectorAll('.add-translation-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const language = this.dataset.language;
            const formData = new FormData(this);
            
            fetch('/admin/languages', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: new FormData(this)
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
                Swal.fire('Error!', 'An error occurred while adding translation', 'error');
            });
        });
    });
    
    // Handle importing translations
    document.querySelectorAll('.import-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const language = this.dataset.language;
            const formData = new FormData(this);
            formData.append('language', language);
            
            fetch('/admin/languages/import', {
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
                Swal.fire('Error!', 'An error occurred while importing translations', 'error');
            });
        });
    });
    
    // Handle editing translations
    document.querySelectorAll('.edit-translation').forEach(button => {
        button.addEventListener('click', function() {
            const key = this.dataset.key;
            const language = this.dataset.language;
            const row = this.closest('tr');
            
            const valueDiv = row.querySelector('.translation-value');
            const editDiv = row.querySelector('.translation-edit');
            const editBtn = row.querySelector('.edit-translation');
            const saveBtn = row.querySelector('.save-translation');
            const cancelBtn = row.querySelector('.cancel-edit');
            
            valueDiv.style.display = 'none';
            editDiv.style.display = 'block';
            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'inline-block';
        });
    });
    
    // Handle saving translations
    document.querySelectorAll('.save-translation').forEach(button => {
        button.addEventListener('click', function() {
            const key = this.dataset.key;
            const language = this.dataset.language;
            const row = this.closest('tr');
            const textarea = row.querySelector('.translation-edit textarea');
            const newValue = textarea.value;
            
            fetch(`/admin/languages/${language}/${encodeURIComponent(key)}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ value: newValue })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const valueDiv = row.querySelector('.translation-value');
                    const editDiv = row.querySelector('.translation-edit');
                    const editBtn = row.querySelector('.edit-translation');
                    const saveBtn = row.querySelector('.save-translation');
                    const cancelBtn = row.querySelector('.cancel-edit');
                    
                    valueDiv.textContent = newValue;
                    valueDiv.style.display = 'block';
                    editDiv.style.display = 'none';
                    editBtn.style.display = 'inline-block';
                    saveBtn.style.display = 'none';
                    cancelBtn.style.display = 'none';
                    
                    Swal.fire('Success!', data.message, 'success');
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while updating translation', 'error');
            });
        });
    });
    
    // Handle canceling edits
    document.querySelectorAll('.cancel-edit').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            
            const valueDiv = row.querySelector('.translation-value');
            const editDiv = row.querySelector('.translation-edit');
            const editBtn = row.querySelector('.edit-translation');
            const saveBtn = row.querySelector('.save-translation');
            const cancelBtn = row.querySelector('.cancel-edit');
            
            valueDiv.style.display = 'block';
            editDiv.style.display = 'none';
            editBtn.style.display = 'inline-block';
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
        });
    });
    
    // Handle deleting translations
    document.querySelectorAll('.delete-translation').forEach(button => {
        button.addEventListener('click', function() {
            const key = this.dataset.key;
            const language = this.dataset.language;
            const row = this.closest('tr');
            
            Swal.fire({
                title: 'Delete Translation?',
                text: `Are you sure you want to delete the translation key "${key}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/languages/${language}/${encodeURIComponent(key)}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting translation', 'error');
                    });
                }
            });
        });
    });
});

function switchLanguage(language) {
    fetch(`/admin/languages/switch/${language}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        }
    });
}

function exportLanguage(language) {
    window.open(`/admin/languages/export/${language}`, '_blank');
}

function scanTranslations() {
    fetch('/admin/languages/scan', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const missingKeys = data.missing_keys;
            let content = '<div class="row">';
            
            for (const [language, keys] of Object.entries(missingKeys)) {
                content += `
                    <div class="col-md-6">
                        <h6>${language.toUpperCase()} (${keys.length} missing)</h6>
                        <ul class="list-group">
                `;
                
                keys.forEach(key => {
                    content += `<li class="list-group-item"><code>${key}</code></li>`;
                });
                
                content += '</ul></div>';
            }
            
            content += '</div>';
            
            document.getElementById('missingTranslationsContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('missingTranslationsModal')).show();
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while scanning translations', 'error');
    });
}

function createMissingTranslations() {
    fetch('/admin/languages/create-missing', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
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
        Swal.fire('Error!', 'An error occurred while creating missing translations', 'error');
    });
}
</script>
@endpush
