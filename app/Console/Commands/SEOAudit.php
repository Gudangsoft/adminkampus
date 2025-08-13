<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Announcement;
use App\Services\SEOService;

class SEOAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:audit {--fix : Auto-fix SEO issues where possible}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit SEO performance and identify optimization opportunities';

    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        parent::__construct();
        $this->seoService = $seoService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Starting SEO Audit...');
        $this->newLine();

        $issues = [];
        $recommendations = [];

        // Audit News
        $this->info('📰 Auditing News articles...');
        $newsIssues = $this->auditNews();
        $issues = array_merge($issues, $newsIssues);

        // Audit Gallery
        $this->info('🖼️ Auditing Gallery items...');
        $galleryIssues = $this->auditGallery();
        $issues = array_merge($issues, $galleryIssues);

        // Audit Pages
        $this->info('📄 Auditing Pages...');
        $pageIssues = $this->auditPages();
        $issues = array_merge($issues, $pageIssues);

        // Generate report
        $this->newLine();
        $this->generateReport($issues);

        // Auto-fix if requested
        if ($this->option('fix')) {
            $this->info('🔧 Auto-fixing issues...');
            $this->autoFix($issues);
        }

        $this->newLine();
        $this->info('✅ SEO Audit completed!');
    }

    private function auditNews()
    {
        $issues = [];
        $news = News::all();

        foreach ($news as $item) {
            // Check title length
            if (strlen($item->title) < 30 || strlen($item->title) > 60) {
                $issues[] = [
                    'type' => 'title_length',
                    'model' => 'News',
                    'id' => $item->id,
                    'title' => $item->title,
                    'current_length' => strlen($item->title),
                    'issue' => 'Title should be 30-60 characters'
                ];
            }

            // Check excerpt length (meta description)
            if (strlen($item->excerpt) < 120 || strlen($item->excerpt) > 160) {
                $issues[] = [
                    'type' => 'meta_description',
                    'model' => 'News',
                    'id' => $item->id,
                    'title' => $item->title,
                    'current_length' => strlen($item->excerpt),
                    'issue' => 'Excerpt should be 120-160 characters for optimal meta description'
                ];
            }

            // Check for featured image
            if (!$item->featured_image) {
                $issues[] = [
                    'type' => 'missing_image',
                    'model' => 'News',
                    'id' => $item->id,
                    'title' => $item->title,
                    'issue' => 'Missing featured image for social sharing'
                ];
            }
        }

        return $issues;
    }

    private function auditGallery()
    {
        $issues = [];
        $galleries = Gallery::all();

        foreach ($galleries as $item) {
            // Check title length
            if (strlen($item->title) < 30 || strlen($item->title) > 60) {
                $issues[] = [
                    'type' => 'title_length',
                    'model' => 'Gallery',
                    'id' => $item->id,
                    'title' => $item->title,
                    'current_length' => strlen($item->title),
                    'issue' => 'Title should be 30-60 characters'
                ];
            }

            // Check description length
            if ($item->description && (strlen($item->description) < 120 || strlen($item->description) > 160)) {
                $issues[] = [
                    'type' => 'meta_description',
                    'model' => 'Gallery',
                    'id' => $item->id,
                    'title' => $item->title,
                    'current_length' => strlen($item->description),
                    'issue' => 'Description should be 120-160 characters'
                ];
            }
        }

        return $issues;
    }

    private function auditPages()
    {
        $issues = [];
        $pages = Page::all();

        foreach ($pages as $item) {
            // Check title length
            if (strlen($item->title) < 30 || strlen($item->title) > 60) {
                $issues[] = [
                    'type' => 'title_length',
                    'model' => 'Page',
                    'id' => $item->id,
                    'title' => $item->title,
                    'current_length' => strlen($item->title),
                    'issue' => 'Title should be 30-60 characters'
                ];
            }

            // Check excerpt length
            if ($item->excerpt && (strlen($item->excerpt) < 120 || strlen($item->excerpt) > 160)) {
                $issues[] = [
                    'type' => 'meta_description',
                    'model' => 'Page',
                    'id' => $item->id,
                    'title' => $item->title,
                    'current_length' => strlen($item->excerpt),
                    'issue' => 'Excerpt should be 120-160 characters'
                ];
            }
        }

        return $issues;
    }

    private function generateReport($issues)
    {
        $this->info('📊 SEO Audit Report');
        $this->info('==================');

        if (empty($issues)) {
            $this->info('🎉 No SEO issues found! Your content is well-optimized.');
            return;
        }

        // Group issues by type
        $groupedIssues = collect($issues)->groupBy('type');

        foreach ($groupedIssues as $type => $typeIssues) {
            $this->newLine();
            $this->warn("⚠️  {$type} issues: " . count($typeIssues));
            
            foreach ($typeIssues->take(5) as $issue) {
                $this->line("   • {$issue['model']} #{$issue['id']}: {$issue['title']} ({$issue['issue']})");
            }
            
            if (count($typeIssues) > 5) {
                $remaining = count($typeIssues) - 5;
                $this->line("   ... and {$remaining} more");
            }
        }

        $this->newLine();
        $this->info("Total issues found: " . count($issues));
        $this->info("Run with --fix flag to auto-fix where possible");
    }

    private function autoFix($issues)
    {
        $fixedCount = 0;

        foreach ($issues as $issue) {
            // Auto-fix title length issues
            if ($issue['type'] === 'title_length' && $issue['current_length'] > 60) {
                $model = app("App\\Models\\{$issue['model']}");
                $item = $model->find($issue['id']);
                
                if ($item) {
                    $newTitle = substr($item->title, 0, 57) . '...';
                    $item->title = $newTitle;
                    $item->save();
                    
                    $this->line("✅ Fixed title length for {$issue['model']} #{$issue['id']}");
                    $fixedCount++;
                }
            }
        }

        $this->info("🔧 Auto-fixed {$fixedCount} issues");
    }
}
