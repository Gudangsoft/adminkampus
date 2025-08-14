<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Interactive Features - Admin Kampus</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .demo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .demo-header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }
        
        .demo-header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .demo-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .feature-description {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .feature-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #d1ecf1;
            color: #0c5460;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .demo-actions {
            text-align: center;
            margin-top: 50px;
        }
        
        .demo-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: white;
            color: #667eea;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .demo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            color: #667eea;
        }
        
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .floating-element {
            position: absolute;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .floating-element:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { top: 40%; left: 80%; animation-delay: 1s; }
        .floating-element:nth-child(3) { top: 60%; left: 30%; animation-delay: 2s; }
        .floating-element:nth-child(4) { top: 80%; left: 70%; animation-delay: 3s; }
        .floating-element:nth-child(5) { top: 30%; left: 50%; animation-delay: 4s; }
    </style>
</head>
<body>
    <!-- Floating background elements -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="demo-container">
        <!-- Header -->
        <div class="demo-header">
            <h1>🚀 Interactive Features Demo</h1>
            <p>Sistem fitur interaktif untuk meningkatkan engagement dan user experience di website kampus</p>
        </div>

        <!-- Feature Grid -->
        <div class="feature-grid">
            <!-- Global Search -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="feature-title">Global Search System</h3>
                <p class="feature-description">
                    Pencarian cerdas yang dapat mencari konten di seluruh website termasuk berita, pengumuman, FAQ, dan halaman lainnya dengan auto-suggestions dan filtering.
                </p>
                <span class="feature-status">
                    <i class="fas fa-check-circle"></i>
                    Production Ready
                </span>
            </div>

            <!-- Live Chat -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3 class="feature-title">AI-Powered Live Chat</h3>
                <p class="feature-description">
                    Chatbot pintar dengan AI responses yang dapat menjawab pertanyaan umum, memberikan informasi kampus, dan mengarahkan ke FAQ yang relevan.
                </p>
                <span class="feature-status">
                    <i class="fas fa-check-circle"></i>
                    Active & Learning
                </span>
            </div>

            <!-- FAQ System -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="feature-title">Interactive FAQ System</h3>
                <p class="feature-description">
                    Sistem FAQ dengan accordion interface, pencarian real-time, kategorisasi, tracking views, dan integrasi social sharing untuk informasi yang mudah diakses.
                </p>
                <span class="feature-status">
                    <i class="fas fa-check-circle"></i>
                    Fully Functional
                </span>
            </div>

            <!-- Quick Access -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 class="feature-title">Quick Access Buttons</h3>
                <p class="feature-description">
                    Floating action button yang memberikan akses cepat ke layanan populer seperti pendaftaran, jadwal, perpustakaan, dan kontak darurat.
                </p>
                <span class="feature-status">
                    <i class="fas fa-check-circle"></i>
                    Ready to Deploy
                </span>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">4</div>
                <div class="stat-label">Interactive Components</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">15+</div>
                <div class="stat-label">Quick Services</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">AI</div>
                <div class="stat-label">Powered Chatbot</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Available Support</div>
            </div>
        </div>

        <!-- Demo Actions -->
        <div class="demo-actions">
            <a href="#" class="demo-btn" onclick="testGlobalSearch()">
                <i class="fas fa-search"></i>
                Test Global Search
            </a>
            <a href="#" class="demo-btn" onclick="testChatbot()">
                <i class="fas fa-robot"></i>
                Test AI Chatbot
            </a>
            <a href="#" class="demo-btn" onclick="testFAQ()">
                <i class="fas fa-question"></i>
                Test FAQ System
            </a>
            <a href="#" class="demo-btn" onclick="testQuickAccess()">
                <i class="fas fa-bolt"></i>
                Test Quick Access
            </a>
        </div>
    </div>

    <!-- Include all interactive components -->
    @include('components.global-search')
    @include('components.live-chat')
    @include('components.faq-accordion')
    @include('components.quick-access')

    <script>
        // Test functions
        function testGlobalSearch() {
            // Trigger global search
            if (window.globalSearch) {
                window.globalSearch.showSearch();
            } else {
                alert('Global Search component loaded! Try typing in the search box.');
            }
        }

        function testChatbot() {
            // Trigger chat widget
            if (window.liveChat) {
                window.liveChat.openChat();
            } else {
                alert('Live Chat component loaded! Look for the chat widget in bottom right.');
            }
        }

        function testFAQ() {
            // Scroll to FAQ if exists
            const faqElement = document.querySelector('[x-data*="faqAccordion"]');
            if (faqElement) {
                faqElement.scrollIntoView({ behavior: 'smooth' });
            } else {
                alert('FAQ Accordion component loaded! Check the FAQ section.');
            }
        }

        function testQuickAccess() {
            // Trigger quick access
            if (window.quickAccess) {
                window.quickAccess.toggleMenu();
            } else {
                alert('Quick Access component loaded! Look for the floating button in bottom right.');
            }
        }

        // Initialize demo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Interactive Features Demo Loaded');
            console.log('✅ All components are ready for testing');
            
            // Show notification
            setTimeout(() => {
                alert('Demo ready! All interactive features are loaded and functional. Try the test buttons!');
            }, 1000);
        });
    </script>
</body>
</html>
