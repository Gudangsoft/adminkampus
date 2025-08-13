@extends('layouts.admin')

@section('title', 'Push Notifications Management')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-bell"></i> Push Notifications Management
        </h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendNotificationModal">
            <i class="fas fa-paper-plane"></i> Send Notification
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Subscribers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSubscribers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sent Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sentToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                This Week
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sentThisWeek }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                This Month
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sentThisMonth }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification History Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Notification History</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Actions:</div>
                    <a class="dropdown-item" href="#" onclick="refreshTable()">
                        <i class="fas fa-sync fa-sm fa-fw mr-2 text-gray-400"></i>
                        Refresh
                    </a>
                    <a class="dropdown-item" href="#" onclick="exportHistory()">
                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                        Export History
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="notificationsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Type</th>
                            <th>Recipients</th>
                            <th>Sent At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                        <tr>
                            <td>{{ $notification->id }}</td>
                            <td>{{ $notification->title }}</td>
                            <td>{{ Str::limit($notification->message, 50) }}</td>
                            <td>
                                <span class="badge badge-{{ $notification->type === 'urgent' ? 'danger' : ($notification->type === 'info' ? 'info' : 'success') }}">
                                    {{ ucfirst($notification->type) }}
                                </span>
                            </td>
                            <td>{{ $notification->recipients_count ?? 'All' }}</td>
                            <td>{{ $notification->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="badge badge-{{ $notification->status === 'sent' ? 'success' : ($notification->status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($notification->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewNotification({{ $notification->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($notification->status === 'failed')
                                <button class="btn btn-sm btn-warning" onclick="resendNotification({{ $notification->id }})">
                                    <i class="fas fa-redo"></i>
                                </button>
                                @endif
                                <button class="btn btn-sm btn-danger" onclick="deleteNotification({{ $notification->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No notifications found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($notifications->hasPages())
            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Push Subscription Settings -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Push Notification Settings</h6>
        </div>
        <div class="card-body">
            <form id="settingsForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vapid_public_key">VAPID Public Key</label>
                            <input type="text" class="form-control" id="vapid_public_key" 
                                   value="{{ config('webpush.vapid.public_key', '') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vapid_private_key">VAPID Private Key</label>
                            <input type="password" class="form-control" id="vapid_private_key" 
                                   value="{{ config('webpush.vapid.private_key', '') }}" readonly>
                            <small class="form-text text-muted">Keys are configured in .env file</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="notification_enabled">Enable Push Notifications</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notification_enabled" checked>
                                <label class="form-check-label" for="notification_enabled">
                                    Allow sending push notifications
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="auto_subscribe">Auto Subscribe New Users</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="auto_subscribe">
                                <label class="form-check-label" for="auto_subscribe">
                                    Automatically subscribe new users
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Notification Modal -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1" aria-labelledby="sendNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendNotificationModalLabel">
                    <i class="fas fa-paper-plane"></i> Send Push Notification
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sendNotificationForm" action="{{ route('admin.notifications.send') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notification_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="notification_title" name="title" required maxlength="100">
                            <div class="form-text">Maximum 100 characters</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notification_message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="notification_message" name="message" rows="4" required maxlength="500"></textarea>
                            <div class="form-text">Maximum 500 characters</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="notification_type" class="form-label">Type</label>
                            <select class="form-select" id="notification_type" name="type">
                                <option value="info">Info</option>
                                <option value="success">Success</option>
                                <option value="warning">Warning</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="notification_icon" class="form-label">Icon URL (optional)</label>
                            <input type="url" class="form-control" id="notification_icon" name="icon" placeholder="https://example.com/icon.png">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="notification_url" class="form-label">Click URL (optional)</label>
                            <input type="url" class="form-control" id="notification_url" name="url" placeholder="https://example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="notification_badge" class="form-label">Badge URL (optional)</label>
                            <input type="url" class="form-control" id="notification_badge" name="badge" placeholder="https://example.com/badge.png">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Send To</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="send_to" id="send_to_all" value="all" checked>
                                <label class="form-check-label" for="send_to_all">
                                    All Subscribers ({{ $totalSubscribers }} users)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="send_to" id="send_to_test" value="test">
                                <label class="form-check-label" for="send_to_test">
                                    Test Mode (Admin only)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> Notifications will be sent immediately. Make sure to review your message before sending.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Notification Modal -->
<div class="modal fade" id="viewNotificationModal" tabindex="-1" aria-labelledby="viewNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNotificationModalLabel">
                    <i class="fas fa-eye"></i> Notification Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificationDetails">
                <!-- Notification details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .badge-info {
        background-color: #36b9cc;
    }
    .badge-success {
        background-color: #1cc88a;
    }
    .badge-warning {
        background-color: #f6c23e;
    }
    .badge-danger {
        background-color: #e74a3b;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle send notification form
    const sendForm = document.getElementById('sendNotificationForm');
    if (sendForm) {
        sendForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Send Notification?',
                text: 'Are you sure you want to send this notification?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(sendForm);
                    
                    fetch(sendForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Sent!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to send notification', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while sending the notification', 'error');
                    });
                }
            });
        });
    }
});

function viewNotification(id) {
    fetch(`/admin/notifications/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notification = data.notification;
                const detailsHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Title:</strong> ${notification.title}</p>
                            <p><strong>Type:</strong> 
                                <span class="badge badge-${notification.type === 'urgent' ? 'danger' : (notification.type === 'info' ? 'info' : 'success')}">
                                    ${notification.type.charAt(0).toUpperCase() + notification.type.slice(1)}
                                </span>
                            </p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-${notification.status === 'sent' ? 'success' : 'warning'}">
                                    ${notification.status.charAt(0).toUpperCase() + notification.status.slice(1)}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Recipients:</strong> ${notification.recipients_count || 'All'}</p>
                            <p><strong>Sent At:</strong> ${new Date(notification.created_at).toLocaleString()}</p>
                            ${notification.url ? `<p><strong>Click URL:</strong> <a href="${notification.url}" target="_blank">${notification.url}</a></p>` : ''}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Message:</strong></p>
                            <p class="bg-light p-3 rounded">${notification.message}</p>
                        </div>
                    </div>
                `;
                
                document.getElementById('notificationDetails').innerHTML = detailsHTML;
                new bootstrap.Modal(document.getElementById('viewNotificationModal')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Failed to load notification details', 'error');
        });
}

function resendNotification(id) {
    Swal.fire({
        title: 'Resend Notification?',
        text: 'This will attempt to resend the failed notification.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, resend it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/notifications/${id}/resend`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Resent!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Failed to resend notification', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while resending the notification', 'error');
            });
        }
    });
}

function deleteNotification(id) {
    Swal.fire({
        title: 'Delete Notification?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Failed to delete notification', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while deleting the notification', 'error');
            });
        }
    });
}

function refreshTable() {
    location.reload();
}

function exportHistory() {
    window.open('/admin/notifications/export', '_blank');
}
</script>
@endpush
