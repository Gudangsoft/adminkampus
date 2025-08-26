<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - {{ \App\Models\Setting::get('site_name', 'KESOSI') }}</title>
    
    <!-- Favicon -->
    @if(isset($globalSettings['site_favicon']) && $globalSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . $globalSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    @endif
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#667eea">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">{{ \App\Models\Setting::get('site_name', 'KESOSI') }} - Admin Panel</a>
            </div>
        </nav>
        
        <main>
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
