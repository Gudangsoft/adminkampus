@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus"></i> Add New User
        </h1>
        <a href="{{ route('admin.system.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
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
                                    <label for="email" class="form-label">Email Address *</label>
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
                                    <label for="password" class="form-label">Password *</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Password must be at least 8 characters long.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">User Role *</label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    Administrator - Full access to all features
                                </option>
                                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>
                                    Editor - Can manage content
                                </option>
                                <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>
                                    Viewer - Read-only access
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create User
                                </button>
                                <a href="{{ route('admin.system.users.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role Permissions</h6>
                </div>
                <div class="card-body">
                    <div class="role-info" id="adminRole" style="display: none;">
                        <h6 class="text-danger">Administrator</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Full system access</li>
                            <li><i class="fas fa-check text-success"></i> User management</li>
                            <li><i class="fas fa-check text-success"></i> System settings</li>
                            <li><i class="fas fa-check text-success"></i> Content management</li>
                            <li><i class="fas fa-check text-success"></i> Analytics & reports</li>
                        </ul>
                    </div>
                    
                    <div class="role-info" id="editorRole" style="display: none;">
                        <h6 class="text-warning">Editor</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Content management</li>
                            <li><i class="fas fa-check text-success"></i> Gallery management</li>
                            <li><i class="fas fa-check text-success"></i> News management</li>
                            <li><i class="fas fa-times text-danger"></i> User management</li>
                            <li><i class="fas fa-times text-danger"></i> System settings</li>
                        </ul>
                    </div>
                    
                    <div class="role-info" id="viewerRole" style="display: none;">
                        <h6 class="text-secondary">Viewer</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-eye text-info"></i> View content</li>
                            <li><i class="fas fa-eye text-info"></i> View analytics</li>
                            <li><i class="fas fa-times text-danger"></i> Edit content</li>
                            <li><i class="fas fa-times text-danger"></i> User management</li>
                            <li><i class="fas fa-times text-danger"></i> System settings</li>
                        </ul>
                    </div>
                    
                    <div id="noRoleSelected">
                        <p class="text-muted">Select a role to see permissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('role').addEventListener('change', function() {
    const role = this.value;
    const roleInfos = document.querySelectorAll('.role-info');
    const noRoleSelected = document.getElementById('noRoleSelected');
    
    // Hide all role info
    roleInfos.forEach(info => info.style.display = 'none');
    
    if (role) {
        noRoleSelected.style.display = 'none';
        const targetRole = document.getElementById(role + 'Role');
        if (targetRole) {
            targetRole.style.display = 'block';
        }
    } else {
        noRoleSelected.style.display = 'block';
    }
});
</script>
@endpush
