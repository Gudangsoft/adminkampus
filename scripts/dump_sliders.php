<?php
// Database connection
$host = 'localhost';
$dbname = 'adminkampus';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch sliders data
$stmt = $pdo->query("SELECT * FROM sliders ORDER BY id DESC");
$sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Terkini - Admin Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 50%, #9b59b6 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.15) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3);
            object-fit: cover;
            margin-bottom: 20px;
        }
        
        .info-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .content-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        
        .slider-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .slider-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .slider-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        
        .slider-content {
            padding: 25px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            background: linear-gradient(45deg, #5a67d8, #667eea);
        }
        
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255,255,255,0.8);
            color: white;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background: rgba(255,255,255,0.2);
            border-color: white;
            color: white;
        }
        
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #2c3e50 !important;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: #2c3e50 !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: #3498db !important;
        }
        
        .hero-content {
            z-index: 2;
            position: relative;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-graduation-cap me-2"></i>Admin Kampus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#info">Info Terkini</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center">
                    <img src="https://via.placeholder.com/120x120/667eea/ffffff?text=Avatar" 
                         alt="Profile" class="profile-image">
                </div>
                <div class="col-lg-8">
                    <div class="info-card">
                        <h1 class="display-4 fw-bold mb-3">Info Terkini</h1>
                        <p class="lead mb-4">Pengumuman & Informasi Terbaru dari Admin Kampus</p>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-3 fs-4"></i>
                                    <div>
                                        <small class="d-block text-light opacity-75">Tanggal Update</small>
                                        <span class="fw-semibold"><?= date('d F Y') ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bell me-3 fs-4"></i>
                                    <div>
                                        <small class="d-block text-light opacity-75">Status</small>
                                        <span class="fw-semibold">Pengumuman Terbaru</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="#info" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-arrow-down me-2"></i>Lihat Informasi
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section" id="info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h2 class="section-title display-5">Informasi & Pengumuman Terkini</h2>
                        <p class="section-subtitle">Dapatkan update terbaru mengenai kegiatan kampus dan pengumuman penting</p>
                        <div class="mt-4">
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                <i class="fas fa-clock me-2"></i>
                                Diperbarui <?= date('d M Y, H:i') ?> WIB
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php if (empty($sliders)): ?>
                    <div class="col-12">
                        <div class="slider-card text-center py-5">
                            <div class="slider-content">
                                <div class="mb-4">
                                    <i class="fas fa-info-circle display-1 text-primary opacity-50"></i>
                                </div>
                                <h4 class="fw-bold mb-3">Belum Ada Informasi Terbaru</h4>
                                <p class="text-muted mb-4">Saat ini belum ada pengumuman atau informasi terbaru yang dapat ditampilkan.</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <button class="btn btn-outline-primary">
                                        <i class="fas fa-refresh me-2"></i>Refresh Halaman
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Informasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($sliders as $slider): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="slider-card h-100">
                                <?php if (!empty($slider['image'])): ?>
                                    <div class="position-relative">
                                        <img src="<?= htmlspecialchars($slider['image']) ?>" 
                                             alt="<?= htmlspecialchars($slider['title']) ?>" 
                                             class="slider-image">
                                        <div class="position-absolute top-0 end-0 p-3">
                                            <span class="badge bg-primary">
                                                <i class="fas fa-star me-1"></i>Baru
                                            </span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="slider-image bg-gradient d-flex align-items-center justify-content-center"
                                         style="background: linear-gradient(45deg, #667eea, #764ba2);">
                                        <i class="fas fa-image fs-1 text-white opacity-75"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="slider-content">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="fw-bold mb-0 flex-grow-1"><?= htmlspecialchars($slider['title']) ?></h5>
                                        <small class="text-muted ms-2">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?= date('d/m', strtotime($slider['created_at'])) ?>
                                        </small>
                                    </div>
                                    
                                    <p class="text-muted mb-4" style="font-size: 0.9rem; line-height: 1.5;">
                                        <?= htmlspecialchars(substr($slider['description'], 0, 120)) ?><?= strlen($slider['description']) > 120 ? '...' : '' ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('d M Y', strtotime($slider['created_at'])) ?>
                                            </small>
                                        </div>
                                        <div>
                                            <a href="#" class="btn btn-outline-primary btn-sm me-1" title="Preview">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-primary btn-sm" title="Baca Selengkapnya">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?= date('Y') ?> Admin Kampus. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar transparency on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255,255,255,0.98)';
            } else {
                navbar.style.background = 'rgba(255,255,255,0.95)';
            }
        });
    </script>
</body>
</html>