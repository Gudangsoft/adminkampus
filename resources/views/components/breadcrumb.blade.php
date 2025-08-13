@props(['items' => []])

@if(count($items) > 0)
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <i class="fas fa-home me-1"></i>Beranda
                </a>
            </li>
            
            @foreach($items as $index => $item)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $item['title'] }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}" class="text-decoration-none">
                                {{ $item['title'] }}
                            </a>
                        @else
                            {{ $item['title'] }}
                        @endif
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>

<style>
.breadcrumb-nav {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 0;
    margin-bottom: 2rem;
}

.breadcrumb {
    margin: 0;
    font-size: 0.9rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
    font-weight: bold;
}

.breadcrumb-item a {
    color: #495057;
    transition: color 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #007bff;
}

.breadcrumb-item.active {
    color: #6c757d;
    font-weight: 500;
}

@media (max-width: 768px) {
    .breadcrumb {
        font-size: 0.8rem;
    }
    
    .breadcrumb-nav {
        padding: 0.75rem 0;
        margin-bottom: 1rem;
    }
}
</style>
@endif
