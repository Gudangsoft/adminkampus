<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('maintenance_title', 'Sedang Maintenance') }} - {{ setting('site_name', 'G0-CAMPUS') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .maintenance-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .maintenance-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
            position: relative;
            z-index: 2;
        }
        
        .maintenance-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .maintenance-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .maintenance-message {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .admin-access-note {
            max-width: 500px;
            margin: 0 auto;
        }

        .admin-access-note .alert {
            background: rgba(13, 110, 253, 0.1);
            border: 1px solid rgba(13, 110, 253, 0.3);
            border-radius: 8px;
            padding: 1rem;
            font-size: 0.9rem;
        }

        .admin-access-note a {
            color: #0d6efd;
        }

        .admin-access-note a:hover {
            color: #0a58ca;
            text-decoration: underline !important;
        }
        
        .countdown-container {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            color: white;
        }
        
        .countdown-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .countdown-item {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 1rem 0.5rem;
            min-width: 80px;
            backdrop-filter: blur(5px);
        }
        
        .countdown-number {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }
        
        .countdown-label {
            display: block;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            opacity: 0.9;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .contact-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .contact-item {
            color: #666;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape2 {
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape3 {
            bottom: 10%;
            left: 20%;
            animation-delay: 4s;
        }
        
        .shape4 {
            bottom: 20%;
            right: 20%;
            animation-delay: 1s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .logo-container {
            margin-bottom: 2rem;
        }
        
        .logo-img {
            max-height: 80px;
            width: auto;
        }
        
        @media (max-width: 768px) {
            .maintenance-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .maintenance-title {
                font-size: 2rem;
            }
            
            .countdown-timer {
                gap: 0.5rem;
            }
            
            .countdown-item {
                min-width: 60px;
                padding: 0.8rem 0.3rem;
            }
            
            .countdown-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape shape1">
                <i class="fas fa-cog" style="font-size: 60px; color: white;"></i>
            </div>
            <div class="shape shape2">
                <i class="fas fa-tools" style="font-size: 40px; color: white;"></i>
            </div>
            <div class="shape shape3">
                <i class="fas fa-wrench" style="font-size: 50px; color: white;"></i>
            </div>
            <div class="shape shape4">
                <i class="fas fa-hammer" style="font-size: 45px; color: white;"></i>
            </div>
        </div>
        
        <div class="maintenance-card">
            <!-- Logo -->
            @if(setting('site_logo'))
            <div class="logo-container">
                <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'G0-CAMPUS') }}" class="logo-img">
            </div>
            @endif
            
            <!-- Maintenance Icon -->
            <div class="maintenance-icon">
                <i class="fas fa-tools"></i>
            </div>
            
            <!-- Title -->
            <h1 class="maintenance-title">
                {{ setting('maintenance_title', 'Sedang Maintenance') }}
            </h1>
            
            <!-- Message -->
            <p class="maintenance-message">
                {!! setting('maintenance_message', 'Website sedang dalam tahap perbaikan dan peningkatan sistem. Mohon maaf atas ketidaknyamanan ini. Terima kasih atas kesabaran Anda.') !!}
            </p>
            
            <!-- Admin Access Note -->
            <div class="admin-access-note mt-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Administrator:</strong> 
                    <a href="{{ url('/admin') }}" class="text-decoration-none fw-bold">Akses Panel Admin</a> 
                    tetap tersedia selama maintenance.
                </div>
            </div>
            
            <!-- Countdown Timer -->
            @if(setting('maintenance_estimated_time'))
            <div class="countdown-container">
                <div class="countdown-title">
                    <i class="fas fa-clock me-2"></i>Estimasi Selesai
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="countdown-item">
                        <span class="countdown-number" id="days">00</span>
                        <span class="countdown-label">Hari</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="hours">00</span>
                        <span class="countdown-label">Jam</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="minutes">00</span>
                        <span class="countdown-label">Menit</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="seconds">00</span>
                        <span class="countdown-label">Detik</span>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="contact-title">
                    <i class="fas fa-headset me-2"></i>Butuh Bantuan?
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ setting('contact_email', 'admin@g0-campus.com') }}</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>{{ setting('contact_phone', '+62 xxx-xxxx-xxxx') }}</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                    <span>{{ setting('site_name', 'G0-CAMPUS') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Countdown Timer Script -->
    @if(setting('maintenance_estimated_time'))
    <script>
        // Set the date we're counting down to
        const countDownDate = new Date("{{ setting('maintenance_estimated_time') }}").getTime();
        
        // Update the countdown every 1 second
        const countdownTimer = setInterval(function() {
            // Get current date and time
            const now = new Date().getTime();
            
            // Calculate the distance between now and the countdown date
            const distance = countDownDate - now;
            
            // Calculate days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the countdown
            document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');
            
            // If the countdown is finished, write some text
            if (distance < 0) {
                clearInterval(countdownTimer);
                document.getElementById("countdown").innerHTML = "<div class='text-center'><i class='fas fa-check-circle fa-2x mb-2'></i><br>Maintenance Selesai</div>";
            }
        }, 1000);
    </script>
    @endif
</body>
</html>
