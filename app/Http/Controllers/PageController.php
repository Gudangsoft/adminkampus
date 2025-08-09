<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();
        
        // Use custom template if specified
        $template = $page->template ? "frontend.pages.{$page->template}" : 'frontend.pages.show';
        
        return view($template, compact('page'));
    }
}
