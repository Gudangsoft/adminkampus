@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'image' => null,
    'canonical' => null,
    'type' => 'website'
])

@php
    $siteName = $globalSettings['site_name'] ?? config('app.name', 'G0-CAMPUS');
    $siteDescription = $globalSettings['site_description'] ?? 'Sistem Informasi Kampus Terdepan';
    
    $metaTitle = $title ? ($title . ' - ' . $siteName) : $siteName;
    $metaDescription = $description ?? $siteDescription;
    $metaImage = $image ?? asset('images/og-image.jpg');
    $metaUrl = $canonical ?? request()->url();
    $metaKeywords = $keywords ?? ($globalSettings['site_keywords'] ?? 'kampus, universitas, pendidikan, berita kampus');
@endphp

<!-- SEO Meta Tags -->
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">
<meta name="author" content="{{ $siteName }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $metaUrl }}">

<!-- Open Graph Meta Tags -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $metaUrl }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:image:alt" content="{{ $metaTitle }}">
<meta property="og:locale" content="id_ID">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $metaImage }}">

<!-- Additional SEO Meta Tags -->
<meta name="theme-color" content="#667eea">
<meta name="msapplication-TileColor" content="#667eea">
<meta name="application-name" content="{{ $siteName }}">

<!-- Preconnect for performance -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://cdnjs.cloudflare.com">

@if(app()->environment('production'))
<!-- Schema.org Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "{{ $siteName }}",
    "url": "{{ config('app.url') }}",
    "description": "{{ $siteDescription }}",
    "potentialAction": {
        "@type": "SearchAction",
        "target": {
            "@type": "EntryPoint", 
            "urlTemplate": "{{ config('app.url') }}/search?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ $siteName }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    }
}
</script>
@endif
