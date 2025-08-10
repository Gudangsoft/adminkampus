@extends('layouts.admin')

@section('title', 'Detail Galeri')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Galeri</h1>
        <div>
            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $gallery->title }}</h6>
                </div>
                <div class="card-body">
                    <!-- Media Display -->
                    <div class="text-center mb-4">
                        @if($gallery->type === 'image' && $gallery->file_path)
                            <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                                 alt="{{ $gallery->alt_text ?: $gallery->title }}" 
                                 class="img-fluid rounded shadow"
                                 style="max-height: 500px; cursor: pointer;"
                                 onclick="openImageModal(this.src)">
                        @elseif($gallery->type === 'video')
                            @if($gallery->file_path)
                                @if(Str::contains($gallery->file_path, ['youtube.com', 'youtu.be']))
                                    @php
                                        $videoId = '';
                                        if (Str::contains($gallery->file_path, 'youtube.com/watch?v=')) {
                                            $videoId = Str::after($gallery->file_path, 'v=');
                                        } elseif (Str::contains($gallery->file_path, 'youtu.be/')) {
                                            $videoId = Str::after($gallery->file_path, 'youtu.be/');
                                        }
                                        $videoId = Str::before($videoId, '&');
                                    @endphp
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" 
                                                src="https://www.youtube.com/embed/{{ $videoId }}" 
                                                allowfullscreen></iframe>
                                    </div>
                                @elseif(Str::contains($gallery->file_path, 'vimeo.com'))
                                    @php
                                        $videoId = Str::afterLast($gallery->file_path, '/');
                                    @endphp
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" 
                                                src="https://player.vimeo.com/video/{{ $videoId }}" 
                                                allowfullscreen></iframe>
                                    </div>
                                @else
                                    <video controls class="w-100 rounded shadow" style="max-height: 500px;">
                                        <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/mp4">
                                        Browser Anda tidak mendukung video.
                                    </video>
                                @endif
                            @endif
                        @endif
                    </div>

                    <!-- Description -->
                    @if($gallery->description)
                        <div class="mb-4">
                            <h5>Deskripsi</h5>
                            <p class="text-muted">{{ $gallery->description }}</p>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Media</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Tipe:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $gallery->type === 'image' ? 'info' : 'success' }}">
                                            {{ ucfirst($gallery->type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td>{{ $gallery->category->name ?? 'Tidak ada' }}</td>
                                </tr>
                                @if($gallery->photographer)
                                <tr>
                                    <td><strong>Fotografer:</strong></td>
                                    <td>{{ $gallery->photographer }}</td>
                                </tr>
                                @endif
                                @if($gallery->taken_at)
                                <tr>
                                    <td><strong>Tanggal Diambil:</strong></td>
                                    <td>{{ $gallery->taken_at->format('d M Y') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Status & Statistik</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Status Unggulan:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $gallery->is_featured ? 'success' : 'secondary' }}">
                                            {{ $gallery->is_featured ? 'Ya' : 'Tidak' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Views:</strong></td>
                                    <td>{{ number_format($gallery->views) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat:</strong></td>
                                    <td>{{ $gallery->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Terakhir Update:</strong></td>
                                    <td>{{ $gallery->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Action Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Galeri
                        </a>
                        
                        @if($gallery->type === 'image' && $gallery->file_path)
                            <a href="{{ asset('storage/' . $gallery->file_path) }}" 
                               class="btn btn-info" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Lihat Full Size
                            </a>
                        @endif
                        
                        <button type="button" class="btn btn-{{ $gallery->is_featured ? 'secondary' : 'success' }}" 
                                onclick="toggleFeatured({{ $gallery->id }})">
                            <i class="fas fa-star"></i> 
                            {{ $gallery->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                        </button>
                        
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Hapus Galeri
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Thumbnail Card -->
            @if($gallery->thumbnail)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thumbnail</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $gallery->thumbnail) }}" 
                         alt="Thumbnail" class="img-fluid rounded" style="max-height: 200px;">
                </div>
            </div>
            @endif

            <!-- Technical Info -->
            @if($gallery->file_path)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Teknis</h6>
                </div>
                <div class="card-body">
                    <p><strong>File Path:</strong><br>
                        <small class="text-muted">{{ $gallery->file_path }}</small>
                    </p>
                    @if($gallery->alt_text)
                        <p><strong>Alt Text:</strong><br>
                            <small class="text-muted">{{ $gallery->alt_text }}</small>
                        </p>
                    @endif
                    @if($gallery->user)
                        <p><strong>Dibuat oleh:</strong><br>{{ $gallery->user->name }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $gallery->title }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    $('#imageModal').modal('show');
}

function toggleFeatured(galleryId) {
    fetch(`/admin/galleries/${galleryId}/toggle-featured`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}
</script>
@endpush
