@extends('layouts.admin')

@section('title', 'Detail Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Slider</h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Slider Image -->
                            <div class="mb-4">
                                @if($slider->image)
                                    <img src="{{ $slider->image_url }}" 
                                         alt="{{ $slider->title }}" 
                                         class="img-fluid rounded shadow">
                                @else
                                    <div class="bg-light p-5 text-center rounded">
                                        <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2">Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Slider Content -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{ $slider->title }}</h4>
                                    @if($slider->description)
                                        <p class="text-muted">{{ $slider->description }}</p>
                                    @endif
                                    
                                    @if($slider->link)
                                        <div class="mt-3">
                                            <a href="{{ $slider->link }}" 
                                               target="{{ $slider->link_target }}" 
                                               class="btn btn-primary">
                                                {{ $slider->button_text ?: 'Selengkapnya' }}
                                                @if($slider->link_target == '_blank')
                                                    <i class="fas fa-external-link-alt ms-1"></i>
                                                @endif
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Slider Information -->
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Informasi Slider</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Status:</strong></div>
                                        <div class="col-7">
                                            <span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Urutan:</strong></div>
                                        <div class="col-7">{{ $slider->sort_order }}</div>
                                    </div>
                                    
                                    @if($slider->link)
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Link:</strong></div>
                                        <div class="col-7">
                                            <a href="{{ $slider->link }}" 
                                               target="{{ $slider->link_target }}" 
                                               class="text-break">
                                                {{ Str::limit($slider->link, 30) }}
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Target:</strong></div>
                                        <div class="col-7">
                                            {{ $slider->link_target == '_blank' ? 'Tab baru' : 'Tab sama' }}
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($slider->button_text)
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Teks Tombol:</strong></div>
                                        <div class="col-7">{{ $slider->button_text }}</div>
                                    </div>
                                    @endif
                                    
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Dibuat:</strong></div>
                                        <div class="col-7">{{ $slider->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    
                                    @if($slider->updated_at != $slider->created_at)
                                    <div class="row mb-3">
                                        <div class="col-5"><strong>Diperbarui:</strong></div>
                                        <div class="col-7">{{ $slider->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Aksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('admin.sliders.toggle-active', $slider) }}" 
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn {{ $slider->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                                @if($slider->is_active)
                                                    <i class="fas fa-eye-slash me-1"></i>Nonaktifkan
                                                @else
                                                    <i class="fas fa-eye me-1"></i>Aktifkan
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('admin.sliders.edit', $slider) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i>Edit Slider
                                        </a>
                                        
                                        <form action="{{ route('admin.sliders.destroy', $slider) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash me-1"></i>Hapus Slider
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview as Homepage Slider -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Preview Homepage</h6>
                                </div>
                                <div class="card-body p-2">
                                    <div class="position-relative bg-dark rounded overflow-hidden">
                                        @if($slider->image)
                                            <img src="{{ $slider->image_url }}" 
                                                 alt="{{ $slider->title }}" 
                                                 class="w-100" 
                                                 style="height: 120px; object-fit: cover; opacity: 0.8;">
                                        @endif
                                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100">
                                            <h6 class="fw-bold mb-1">{{ $slider->title }}</h6>
                                            @if($slider->description)
                                                <p class="small mb-2 opacity-75">{{ Str::limit($slider->description, 60) }}</p>
                                            @endif
                                            @if($slider->link && $slider->button_text)
                                                <button class="btn btn-primary btn-sm">
                                                    {{ $slider->button_text }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
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
