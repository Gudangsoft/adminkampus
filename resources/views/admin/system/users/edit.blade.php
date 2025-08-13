@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit"></i> Edit User: {{ $user->name }}
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
                    <form action="{{ route('admin.system.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
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
                                           value="{{ old('email', $user->email) }}" 
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
                                    <label for="role" class="form-label">Role *</label>
                                    <select class="form-control @error('role') is-invalid @enderror" 
                                            id="role" 
                                            name="role" 
                                            required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Administrator
                                        </option>
                                        <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>
                                            Editor
                                        </option>
                                        <option value="viewer" {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>
                                            Viewer
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" 
                                            id="is_active" 
                                            name="is_active">
                                        <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Leave blank to keep current password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Leave blank if you don't want to change the password
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirm new password">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update User
                            </button>
                            <a href="{{ route('admin.system.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>User ID:</strong><br>
                        <span class="text-muted">#{{ $user->id }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Current Role:</strong><br>
                        <span class="badge badge-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'editor' ? 'success' : 'info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Status:</strong><br>
                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        <span class="text-muted">{{ $user->updated_at->format('M d, Y') }}</span>
                    </div>
                    
                    @if($user->email_verified_at)
                    <div class="mb-3">
                        <strong>Email Verified:</strong><br>
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i> 
                            {{ $user->email_verified_at->format('M d, Y') }}
                        </span>
                    </div>
                    @else
                    <div class="mb-3">
                        <strong>Email Status:</strong><br>
                        <span class="text-warning">
                            <i class="fas fa-exclamation-triangle"></i> Not Verified
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($user->is_active)
                            <form action="{{ route('admin.system.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm w-100" 
                                        onclick="return confirm('Are you sure you want to deactivate this user?')">
                                    <i class="fas fa-user-slash"></i> Deactivate User
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.system.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-user-check"></i> Activate User
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.system.users.show', $user) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.system.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" 
                                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                <i class="fas fa-trash"></i> Delete User
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password confirmation validation
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (password.value && passwordConfirmation.value) {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Passwords do not match');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        } else {
            passwordConfirmation.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePassword);
    passwordConfirmation.addEventListener('input', validatePassword);
});
</script>
@endpush
