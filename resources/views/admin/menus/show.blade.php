@extends('layouts.admin')

@section('title', 'Detail Menu')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Menu</h1>
        <div>
            <a href="{{ route('admin.menus.edit', $menu) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.menus.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Menu Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $menu->name }}</h6>
                    <div class="dropdown no-arrow">
                        <span class="badge badge-{{ $menu->is_active ? 'success' : 'secondary' }}">
                            {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Nama Menu:</strong></div>
                        <div class="col-md-9">
                            @if($menu->icon)
                                <i class="{{ $menu->icon }} me-2"></i>
                            @endif
                            {{ $menu->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Link:</strong></div>
                        <div class="col-md-9">
                            @if($menu->page)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-2">Halaman</span>
                                    <span>{{ $menu->page->title }}</span>
                                </div>
                                <small class="text-muted">URL: 
                                    <a href="{{ route('page.show', $menu->page->slug) }}" target="_blank">
                                        {{ route('page.show', $menu->page->slug) }}
                                    </a>
                                </small>
                            @elseif($menu->url)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning me-2">URL Custom</span>
                                    <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="text-primary">
                                        {{ $menu->url }}
                                        @if($menu->target === '_blank')
                                            <i class="fas fa-external-link-alt fa-xs"></i>
                                        @endif
                                    </a>
                                </div>
                            @else
                                <span class="text-muted">Tidak ada link</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Lokasi:</strong></div>
                        <div class="col-md-9">
                            <span class="badge bg-secondary">{{ ucfirst($menu->location) }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Target:</strong></div>
                        <div class="col-md-9">
                            <span class="badge bg-light text-dark">
                                {{ $menu->target === '_blank' ? 'New Window' : 'Same Window' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Urutan:</strong></div>
                        <div class="col-md-9">
                            <span class="badge bg-info">{{ $menu->sort_order }}</span>
                        </div>
                    </div>

                    @if($menu->parent)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Parent Menu:</strong></div>
                        <div class="col-md-9">
                            <a href="{{ route('admin.menus.show', $menu->parent) }}" class="text-primary">
                                {{ $menu->parent->name }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($menu->icon)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Icon:</strong></div>
                        <div class="col-md-9">
                            <i class="{{ $menu->icon }} me-2"></i>
                            <code>{{ $menu->icon }}</code>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Status:</strong></div>
                        <div class="col-md-9">
                            <span class="badge badge-{{ $menu->is_active ? 'success' : 'secondary' }}">
                                {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($menu->children->count() > 0)
            <!-- Submenu Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Submenu ({{ $menu->children->count() }})</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($menu->children()->ordered()->get() as $child)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                @if($child->icon)
                                    <i class="{{ $child->icon }} me-2"></i>
                                @endif
                                <strong>{{ $child->name }}</strong>
                                <br>
                                <small class="text-muted">
                                    @if($child->page)
                                        Halaman: {{ $child->page->title }}
                                    @elseif($child->url)
                                        URL: {{ $child->url }}
                                    @endif
                                    | Urutan: {{ $child->sort_order }}
                                </small>
                            </div>
                            <div>
                                <span class="badge badge-{{ $child->is_active ? 'success' : 'secondary' }} me-2">
                                    {{ $child->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.menus.show', $child) }}" 
                                       class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.menus.edit', $child) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Menu
                        </a>
                        
                        @if($menu->url || $menu->page)
                        <a href="{{ $menu->url ?: route('page.show', $menu->page->slug) }}" 
                           target="{{ $menu->target }}" class="btn btn-success btn-sm">
                            <i class="fas fa-external-link-alt"></i> Lihat Link
                        </a>
                        @endif
                        
                        <button type="button" class="btn btn-info btn-sm" onclick="copyMenuInfo()">
                            <i class="fas fa-copy"></i> Salin Info
                        </button>
                        
                        <hr>
                        
                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?{{ $menu->children->count() > 0 ? ' Menu ini memiliki submenu yang juga akan terhapus.' : '' }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" 
                                    {{ $menu->children->count() > 0 ? 'disabled title="Menu memiliki submenu"' : '' }}>
                                <i class="fas fa-trash"></i> Hapus Menu
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Menu Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Menu</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>ID:</strong></div>
                        <div class="col-sm-7">{{ $menu->id }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>Dibuat:</strong></div>
                        <div class="col-sm-7">{{ $menu->created_at->format('d M Y H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>Update:</strong></div>
                        <div class="col-sm-7">{{ $menu->updated_at->format('d M Y H:i') }}</div>
                    </div>

                    @if($menu->children->count() > 0)
                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>Submenu:</strong></div>
                        <div class="col-sm-7">{{ $menu->children->count() }} item</div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-5"><strong>Tipe:</strong></div>
                        <div class="col-sm-7">
                            @if($menu->parent_id)
                                <span class="badge bg-info">Submenu</span>
                            @else
                                <span class="badge bg-primary">Parent Menu</span>
                            @endif
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
function copyMenuInfo() {
    const menuInfo = `
Menu: {{ $menu->name }}
Lokasi: {{ ucfirst($menu->location) }}
@if($menu->page)Link: {{ route('page.show', $menu->page->slug) }}@elseif($menu->url)Link: {{ $menu->url }}@endif
Status: {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
Urutan: {{ $menu->sort_order }}
@if($menu->parent)Parent: {{ $menu->parent->name }}@endif
`.trim();

    navigator.clipboard.writeText(menuInfo).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        button.classList.remove('btn-info');
        button.classList.add('btn-success');
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-info');
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin informasi menu');
    });
}
</script>
@endpush
