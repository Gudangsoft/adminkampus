<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Email dari ' . $siteName }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .site-name {
            color: #667eea;
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }
        .content {
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .btn:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .footer {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        .news-meta {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            @if(isset($logoUrl))
                <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="logo">
            @endif
            <div class="site-name">{{ $siteName }}</div>
        </div>
        
        <div class="content">
            @yield('content')
        </div>
        
        <div class="footer">
            <p>
                Email ini dikirim otomatis dari <strong>{{ $siteName }}</strong><br>
                <a href="{{ $homeUrl ?? url('/') }}" style="color: #667eea;">{{ $homeUrl ?? url('/') }}</a>
            </p>
            <p style="font-size: 12px; color: #999;">
                Jika Anda tidak ingin menerima email ini lagi, 
                <a href="#" style="color: #999;">klik di sini untuk berhenti berlangganan</a>
            </p>
        </div>
    </div>
</body>
</html>
