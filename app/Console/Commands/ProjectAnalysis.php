<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Announcement;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProjectAnalysis extends Command
{
    protected $signature = 'project:analyze';
    protected $description = 'Analyze current project status and suggest next steps';

    public function handle()
    {
        $this->info('🔍 Analyzing Campus Management System...');
        $this->newLine();

        // Content Analysis
        $this->analyzeContent();
        
        // Technical Analysis
        $this->analyzeTechnical();
        
        // SEO Analysis
        $this->analyzeSEO();
        
        // Recommendations
        $this->showRecommendations();
        
        $this->newLine();
        $this->info('✅ Analysis completed!');
    }

    private function analyzeContent()
    {
        $this->line('📊 <fg=yellow>CONTENT ANALYSIS</fg=yellow>');
        $this->line('================');
        
        $stats = [
            'News' => News::count(),
            'Gallery' => Gallery::count(),
            'Pages' => Page::count(),
            'Announcements' => Announcement::count(),
            'Faculties' => Faculty::count(),
            'Users' => User::count()
        ];
        
        foreach ($stats as $type => $count) {
            $status = $count > 0 ? '✅' : '❌';
            $this->line("{$status} {$type}: {$count} items");
        }
        
        $this->newLine();
    }

    private function analyzeTechnical()
    {
        $this->line('⚙️  <fg=yellow>TECHNICAL ANALYSIS</fg=yellow>');
        $this->line('==================');
        
        // Check key files
        $files = [
            'SEO Service' => 'app/Services/SEOService.php',
            'SEO Controller' => 'app/Http/Controllers/Admin/SEOController.php',
            'Sitemap Controller' => 'app/Http/Controllers/SitemapController.php',
            'Search Controller' => 'app/Http/Controllers/SearchController.php',
            'Home Controller' => 'app/Http/Controllers/HomeController.php'
        ];
        
        foreach ($files as $name => $path) {
            $exists = File::exists(base_path($path));
            $status = $exists ? '✅' : '❌';
            $this->line("{$status} {$name}");
        }
        
        // Check views
        $views = [
            'SEO Dashboard' => 'resources/views/admin/seo/dashboard.blade.php',
            'SEO Audit' => 'resources/views/admin/seo/audit.blade.php',
            'SEO Component' => 'resources/views/components/seo.blade.php',
            'Admin Layout' => 'resources/views/layouts/admin.blade.php'
        ];
        
        $this->newLine();
        $this->line('Views Status:');
        foreach ($views as $name => $path) {
            $exists = File::exists(base_path($path));
            $status = $exists ? '✅' : '❌';
            $this->line("  {$status} {$name}");
        }
        
        $this->newLine();
    }

    private function analyzeSEO()
    {
        $this->line('🔍 <fg=yellow>SEO ANALYSIS</fg=yellow>');
        $this->line('=============');
        
        // SEO Issues
        $titleIssues = News::whereRaw('CHAR_LENGTH(title) < 30 OR CHAR_LENGTH(title) > 60')->count();
        $missingImages = News::whereNull('featured_image')->count();
        $missingMeta = News::whereNull('excerpt')->orWhere('excerpt', '')->count();
        
        $this->line("📝 Title Issues: {$titleIssues}");
        $this->line("🖼️ Missing Images: {$missingImages}");
        $this->line("📋 Missing Meta: {$missingMeta}");
        
        $totalIssues = $titleIssues + $missingImages + $missingMeta;
        $status = $totalIssues == 0 ? '🎉 Excellent!' : ($totalIssues < 10 ? '👍 Good' : '⚠️ Needs Attention');
        $this->line("Overall SEO Health: {$status} ({$totalIssues} issues)");
        
        $this->newLine();
    }

    private function showRecommendations()
    {
        $this->line('🚀 <fg=green>NEXT STEPS RECOMMENDATIONS</fg=green>');
        $this->line('============================');
        
        $recommendations = [
            'Priority 1 - Essential Features',
            '📧 Email System & Notifications',
            '👤 User Profile Management', 
            '🔐 Role & Permission System',
            '📱 Mobile App API',
            '',
            'Priority 2 - Advanced Features',
            '📊 Analytics Dashboard',
            '💬 Comment System',
            '📋 Event Management',
            '📚 Document Management',
            '',
            'Priority 3 - Optimization',
            '⚡ Performance Optimization',
            '🔒 Security Hardening',
            '🌐 Multi-language Support',
            '📱 PWA Implementation',
            '',
            'Priority 4 - Integration',
            '📱 Social Media Integration',
            '💳 Payment Gateway',
            '📧 Newsletter System',
            '🔔 Push Notifications'
        ];
        
        foreach ($recommendations as $rec) {
            if (empty($rec)) {
                $this->newLine();
            } elseif (strpos($rec, 'Priority') === 0) {
                $this->line("<fg=cyan>{$rec}</fg=cyan>");
                $this->line(str_repeat('-', strlen($rec)));
            } else {
                $this->line("  {$rec}");
            }
        }
        
        $this->newLine();
        
        // Quick wins
        $this->line('<fg=yellow>🎯 QUICK WINS (Can implement today):</fg=yellow>');
        $this->line('1. 📧 Basic email notifications');
        $this->line('2. 👤 Enhanced user profiles');  
        $this->line('3. 📊 Simple analytics dashboard');
        $this->line('4. 🔐 Basic role management');
        $this->line('5. 📱 API endpoints for mobile');
    }
}
