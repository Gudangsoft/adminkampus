@extends('layouts.admin')

@section('title', 'View User')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user"></i> User Details: {{ $user->name }}
        </h1>
        <div>
            <a href="{{ route('admin.system.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit User
            </a>
            <a href="{{ route('admin.system.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Full Name:</strong><br>
                                <span class="text-muted">{{ $user->name }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Email Address:</strong><br>
                                <span class="text-muted">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Role:</strong><br>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'editor' ? 'success' : 'info') }} badge-lg">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Status:</strong><br>
                                <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }} badge-lg">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Account Created:</strong><br>
                                <span class="text-muted">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Last Updated:</strong><br>
                                <span class="text-muted">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($user->email_verified_at)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Email Verified:</strong><br>
                                <span class="text-success">
                                    <i class="fas fa-check-circle"></i> 
                                    {{ $user->email_verified_at->format('F d, Y \a\t g:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Email Status:</strong><br>
                                <span class="text-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Email Not Verified
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Role Permissions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role Permissions</h6>
                </div>
                <div class="card-body">
                    @if($user->role == 'admin')
                        <div class="alert alert-primary">
                            <h6><i class="fas fa-crown"></i> Administrator</h6>
                            <p class="mb-0">Full access to all areas of the admin panel including:</p>
                            <ul class="mb-0 mt-2">
                                <li>User Management</li>
                                <li>System Settings</li>
                                <li>Database Backups</li>
                                <li>PDF Reports</li>
                                <li>Content Management</li>
                                <li>Academic Management</li>
                            </ul>
                        </div>
                    @elseif($user->role == 'editor')
                        <div class="alert alert-success">
                            <h6><i class="fas fa-edit"></i> Editor</h6>
                            <p class="mb-0">Content management access including:</p>
                            <ul class="mb-0 mt-2">
                                <li>News Management</li>
                                <li>Announcements</li>
                                <li>Galleries</li>
                                <li>Pages Management</li>
                                <li>Academic Data (view/edit)</li>
                                <li>Languages & Themes</li>
                            </ul>
                        </div>
                    @elseif($user->role == 'viewer')
                        <div class="alert alert-info">
                            <h6><i class="fas fa-eye"></i> Viewer</h6>
                            <p class="mb-0">Read-only access to:</p>
                            <ul class="mb-0 mt-2">
                                <li>Academic Data (view only)</li>
                                <li>Analytics Dashboard</li>
                                <li>SEO Tools</li>
                                <li>Profile Management</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.system.users.edit', $user) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        
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

            <!-- User Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>User ID:</strong><br>
                        <span class="text-muted">#{{ $user->id }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Account Age:</strong><br>
                        <span class="text-muted">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Last Profile Update:</strong><br>
                        <span class="text-muted">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    
                    @if($user->role == 'admin')
                    <div class="mb-3">
                        <strong>Access Level:</strong><br>
                        <span class="badge badge-primary">Full Access</span>
                    </div>
                    @elseif($user->role == 'editor')
                    <div class="mb-3">
                        <strong>Access Level:</strong><br>
                        <span class="badge badge-success">Content Management</span>
                    </div>
                    @else
                    <div class="mb-3">
                        <strong>Access Level:</strong><br>
                        <span class="badge badge-info">Read Only</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
