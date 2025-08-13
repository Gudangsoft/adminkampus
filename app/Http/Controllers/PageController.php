<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\SEOService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();
        
        // SEO for page
        $this->seoService->forPage($page);
        
        // Use custom template if specified
        $template = $page->template ? "frontend.pages.{$page->template}" : 'frontend.pages.show';
        
        return view($template, compact('page'));
    }
}
