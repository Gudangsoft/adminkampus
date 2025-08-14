<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Berhasil</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .success-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }
        
        .success-icon i {
            color: white;
            font-size: 2rem;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .countdown {
            font-size: 1.2rem;
            color: #667eea;
            font-weight: 600;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h2 class="mb-3">Login Berhasil!</h2>
        <p class="text-muted mb-4">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        
        <div class="countdown mb-4">
            Admin Panel akan terbuka dalam <span id="countdown">3</span> detik...
        </div>
        
        <div class="d-grid gap-2">
            <button onclick="openAdmin()" class="btn btn-custom">
                <i class="fas fa-tachometer-alt me-2"></i>Buka Admin Panel Sekarang
            </button>
            <a href="{{ $homeUrl }}" class="btn btn-outline-secondary">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
    <script>
        let countdown = 3;
        const countdownElement = document.getElementById('countdown');
        
        function openAdmin() {
            window.open('{{ $adminUrl }}', '_blank');
            window.location.href = '{{ $homeUrl }}';
        }
        
        // Countdown timer
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                openAdmin();
            }
        }, 1000);
        
        // Auto redirect after 3 seconds
        setTimeout(() => {
            openAdmin();
        }, 3000);
    </script>
</body>
</html>
