@php
    $bgColor = $section->background_color !== '#ffffff' ? $section->background_color : '';
    $textColor = $section->text_color !== '#000000' ? $section->text_color : '';
    $style = '';
    if ($bgColor) $style .= 'background-color: ' . $bgColor . ';';
    if ($textColor) $style .= 'color: ' . $textColor . ';';
    
    // Determine button classes based on background
    $isDark = in_array($bgColor, ['#000000', '#212529', '#343a40', '#495057']) || 
              (strpos($bgColor, '#') === 0 && strlen($bgColor) === 7 && 
               hexdec(substr($bgColor, 1, 2)) + hexdec(substr($bgColor, 3, 2)) + hexdec(substr($bgColor, 5, 2)) < 400);
    $btnClass = $isDark ? 'btn-light' : 'btn-primary';
    $btnOutlineClass = $isDark ? 'btn-outline-light' : 'btn-outline-primary';
@endphp

<div class="section-{{ $section->type }} mb-5" @if($style) style="{{ $style }}" @endif>
    @if($section->type === 'hero')
        <!-- Hero Section -->
        <div class="container-fluid p-0">
            <div class="@if(!$bgColor) bg-primary text-white @endif py-5" @if($style) style="{{ $style }}" @endif>
                <div class="container">
                    <div class="row align-items-center min-vh-75">
                        <div class="col-lg-7">
                            <h1 class="display-4 fw-bold mb-4">{{ $section->title }}</h1>
                            @if($section->subtitle)
                                <p class="lead mb-4">{{ $section->subtitle }}</p>
                            @endif
                            @if($section->content)
                                <div class="mb-4 fs-5">{!! nl2br(e($section->content)) !!}</div>
                            @endif
                            @if($section->link && $section->link_text)
                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="{{ $section->link }}" class="btn {{ $isDark ? 'btn-light' : 'btn-light' }} btn-lg px-4 py-3 shadow">
                                        @if($section->icon)
                                            <i class="{{ $section->icon }} me-2"></i>
                                        @endif
                                        {{ $section->link_text }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-5 text-center">
                            @if($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}" 
                                     alt="{{ $section->title }}" 
                                     class="img-fluid rounded shadow-lg">
                            @elseif($section->icon)
                                <i class="{{ $section->icon }} fa-5x @if(!$bgColor) opacity-75 @endif"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($section->type === 'content')
        <!-- Content Section -->
        <div class="container @if($bgColor) p-5 rounded @endif">
            <div class="row">
                <div class="col-12">
                    @if($section->subtitle || $section->title)
                        <div class="text-center mb-5">
                            @if($section->title)
                                <h2 class="h2 mb-3">{{ $section->title }}</h2>
                            @endif
                            @if($section->subtitle)
                                <p class="lead @if(!$textColor) text-muted @endif">{{ $section->subtitle }}</p>
                            @endif
                        </div>
                    @endif
                    
                    @if($section->content)
                        <div class="row align-items-center">
                            @if($section->image)
                                <div class="col-lg-6 mb-4">
                                    <img src="{{ asset('storage/' . $section->image) }}" 
                                         alt="{{ $section->title }}" 
                                         class="img-fluid rounded shadow">
                                </div>
                                <div class="col-lg-6">
                                    <div class="content">
                                        {!! nl2br(e($section->content)) !!}
                                    </div>
                                    @if($section->link && $section->link_text)
                                        <div class="mt-3">
                                            <a href="{{ $section->link }}" class="btn btn-primary">
                                                @if($section->icon)
                                                    <i class="{{ $section->icon }} me-2"></i>
                                                @endif
                                                {{ $section->link_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="col-12 text-center">
                                    @if($section->icon)
                                        <div class="mb-3">
                                            <i class="{{ $section->icon }} fa-3x text-primary"></i>
                                        </div>
                                    @endif
                                    <div class="content">
                                        {!! nl2br(e($section->content)) !!}
                                    </div>
                                    @if($section->link && $section->link_text)
                                        <div class="mt-3">
                                            <a href="{{ $section->link }}" class="btn btn-primary">
                                                @if($section->icon)
                                                    <i class="{{ $section->icon }} me-2"></i>
                                                @endif
                                                {{ $section->link_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

    @elseif($section->type === 'feature')
        <!-- Feature Section -->
        <div class="container @if($bgColor) p-5 rounded @endif">
            <div class="row">
                <div class="col-12">
                    @if($section->title || $section->subtitle)
                        <div class="text-center mb-5">
                            @if($section->title)
                                <h2 class="h2 mb-3">{{ $section->title }}</h2>
                            @endif
                            @if($section->subtitle)
                                <p class="lead @if(!$textColor) text-muted @endif">{{ $section->subtitle }}</p>
                            @endif
                        </div>
                    @endif
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($section->image)
                                    <img src="{{ asset('storage/' . $section->image) }}" 
                                         alt="{{ $section->title }}" 
                                         class="card-img-top"
                                         style="height: 250px; object-fit: cover;">
                                @endif
                                <div class="card-body text-center p-4">
                                    @if($section->icon && !$section->image)
                                        <div class="text-primary mb-3">
                                            <i class="{{ $section->icon }} fa-3x"></i>
                                        </div>
                                    @endif
                                    @if($section->content)
                                        <div class="card-text">
                                            {!! nl2br(e($section->content)) !!}
                                        </div>
                                    @endif
                                    @if($section->link && $section->link_text)
                                        <div class="mt-3">
                                            <a href="{{ $section->link }}" class="btn btn-primary">
                                                @if($section->icon)
                                                    <i class="{{ $section->icon }} me-2"></i>
                                                @endif
                                                {{ $section->link_text }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($section->type === 'cta')
        <!-- Call to Action Section -->
        <div class="container-fluid p-0">
            <div class="@if(!$bgColor) bg-primary text-white @endif py-5" @if($style) style="{{ $style }}" @endif>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            @if($section->title)
                                <h2 class="display-5 fw-bold mb-4">{{ $section->title }}</h2>
                            @endif
                            @if($section->subtitle)
                                <p class="lead mb-4">{{ $section->subtitle }}</p>
                            @endif
                            @if($section->content)
                                <div class="mb-5 fs-5">
                                    {!! nl2br(e($section->content)) !!}
                                </div>
                            @endif
                            @if($section->link && $section->link_text)
                                <div class="d-flex gap-3 justify-content-center flex-wrap">
                                    <a href="{{ $section->link }}" class="btn {{ $isDark ? 'btn-light' : 'btn-light' }} btn-lg px-4 py-3 shadow">
                                        @if($section->icon)
                                            <i class="{{ $section->icon }} me-2"></i>
                                        @endif
                                        {{ $section->link_text }}
                                    </a>
                                    @if(!$section->link || $section->link === '#')
                                    <a href="/admin/sections" class="btn {{ $isDark ? 'btn-outline-light' : 'btn-outline-light' }} btn-lg px-4 py-3">
                                        <i class="fas fa-cog me-2"></i>Kelola Sections
                                    </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($section->type === 'gallery')
        <!-- Gallery Section -->
        <div class="container @if($bgColor) p-5 rounded @endif">
            <div class="row">
                <div class="col-12">
                    @if($section->title || $section->subtitle)
                        <div class="text-center mb-5">
                            @if($section->title)
                                <h2 class="h2 mb-3">{{ $section->title }}</h2>
                            @endif
                            @if($section->subtitle)
                                <p class="lead @if(!$textColor) text-muted @endif">{{ $section->subtitle }}</p>
                            @endif
                        </div>
                    @endif
                    
                    @if($section->image)
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <img src="{{ asset('storage/' . $section->image) }}" 
                                     alt="{{ $section->title }}" 
                                     class="img-fluid rounded shadow">
                                @if($section->content)
                                    <div class="mt-3 text-center">
                                        {!! nl2br(e($section->content)) !!}
                                    </div>
                                @endif
                                @if($section->link && $section->link_text)
                                    <div class="text-center mt-3">
                                        <a href="{{ $section->link }}" class="btn btn-primary">
                                            @if($section->icon)
                                                <i class="{{ $section->icon }} me-2"></i>
                                            @endif
                                            {{ $section->link_text }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.min-vh-75 {
    min-height: 75vh;
}

.section-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.section-cta {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.btn-lg {
    font-weight: 600;
    letter-spacing: 0.5px;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
</style>
@endpush
