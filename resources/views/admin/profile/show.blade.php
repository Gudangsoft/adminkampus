@extends('layouts.admin')

@section('title', 'Profil Administrator')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Profil Administrator
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Information Card -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Profil</h5>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}" 
                                                   required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon</label>
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $user->phone) }}" 
                                                   placeholder="08xxxxxxxxxx">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" 
                                                      name="address" 
                                                      rows="3" 
                                                      placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="avatar">Foto Profil</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" 
                                                           class="custom-file-input @error('avatar') is-invalid @enderror" 
                                                           id="avatar" 
                                                           name="avatar" 
                                                           accept="image/*">
                                                    <label class="custom-file-label" for="avatar">Choose file</label>
                                                </div>
                                                @error('avatar')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                Format: JPG, PNG, GIF. Maksimal 2MB.
                                            </small>
                                        </div>

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Avatar Display Card -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Foto Profil</h5>
                                </div>
                                <div class="card-body text-center" style="padding: 2rem 1rem;">
                                    <div class="profile-avatar-container mb-3" style="display: flex; justify-content: center; align-items: center; padding: 10px;">
                                        <div class="profile-avatar-wrapper" style="position: relative;">
                                            <img src="{{ $user->avatar_url }}" 
                                                 alt="Avatar" 
                                                 class="avatar-circle" 
                                                 style="width: 120px !important; height: 120px !important; min-width: 120px !important; min-height: 120px !important; max-width: 120px !important; max-height: 120px !important; object-fit: cover !important; object-position: center center !important; aspect-ratio: 1/1 !important; border-radius: 50% !important; border: 3px solid #fff; box-shadow: 0 3px 12px rgba(0,0,0,0.12); display: block; margin: 0 auto;"
                                                 id="avatarPreview"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="d-none align-items-center justify-content-center" 
                                                 style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; color: white; font-size: 48px; border: 3px solid #fff; box-shadow: 0 3px 12px rgba(0,0,0,0.12); margin: 0 auto;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    @if($user->phone)
                                        <p class="text-muted">
                                            <i class="fas fa-phone"></i> {{ $user->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Password Change Card -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title">Ubah Password</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.profile.password.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="form-group">
                                            <label for="current_password">Password Saat Ini <span class="text-danger">*</span></label>
                                            <input type="password" 
                                                   class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="current_password" 
                                                   name="current_password" 
                                                   required>
                                            @error('current_password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password Baru <span class="text-danger">*</span></label>
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password" 
                                                   required>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning btn-block">
                                                <i class="fas fa-key"></i> Ubah Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
    
    // Avatar preview
    $('#avatar').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Form submission with loading state
    $('form').on('submit', function() {
        const submitButton = $(this).find('button[type="submit"]');
        const originalText = submitButton.html();
        submitButton.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
        
        // Re-enable button after 5 seconds as fallback
        setTimeout(function() {
            submitButton.html(originalText).prop('disabled', false);
        }, 5000);
    });
});
</script>
@endpush
