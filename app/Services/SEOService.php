<?php

namespace App\Services;

class SEOService
{
    private array $meta = [];
    private array $openGraph = [];
    private array $twitterCard = [];
    private array $structuredData = [];
    
    public function setTitle(string $title): self
    {
        $this->meta['title'] = $title;
        return $this;
    }
    
    public function setDescription(string $description): self
    {
        $this->meta['description'] = $description;
        return $this;
    }
    
    public function setKeywords(string $keywords): self
    {
        $this->meta['keywords'] = $keywords;
        return $this;
    }
    
    public function setCanonical(string $url): self
    {
        $this->meta['canonical'] = $url;
        return $this;
    }
    
    public function setImage(string $image, string $alt = ''): self
    {
        $this->meta['image'] = $image;
        $this->meta['image_alt'] = $alt;
        return $this;
    }
    
    public function setOpenGraph(array $data): self
    {
        $this->openGraph = array_merge($this->openGraph, $data);
        return $this;
    }
    
    public function setTwitterCard(array $data): self
    {
        $this->twitterCard = array_merge($this->twitterCard, $data);
        return $this;
    }
    
    public function addStructuredData(array $data): self
    {
        $this->structuredData[] = $data;
        return $this;
    }
    
    public function generateMetaTags(): string
    {
        $tags = [];
        
        // Basic meta tags
        if (isset($this->meta['title'])) {
            $tags[] = '<title>' . e($this->meta['title']) . '</title>';
        }
        
        if (isset($this->meta['description'])) {
            $tags[] = '<meta name="description" content="' . e($this->meta['description']) . '">';
        }
        
        if (isset($this->meta['keywords'])) {
            $tags[] = '<meta name="keywords" content="' . e($this->meta['keywords']) . '">';
        }
        
        if (isset($this->meta['canonical'])) {
            $tags[] = '<link rel="canonical" href="' . e($this->meta['canonical']) . '">';
        }
        
        // Open Graph tags
        $ogData = array_merge([
            'type' => 'website',
            'site_name' => config('app.name', 'G0-CAMPUS'),
            'title' => $this->meta['title'] ?? config('app.name', 'G0-CAMPUS'),
            'description' => $this->meta['description'] ?? '',
            'url' => $this->meta['canonical'] ?? request()->url(),
        ], $this->openGraph);
        
        if (isset($this->meta['image'])) {
            $ogData['image'] = $this->meta['image'];
            $ogData['image:alt'] = $this->meta['image_alt'] ?? $ogData['title'];
        }
        
        foreach ($ogData as $property => $content) {
            if ($content) {
                $tags[] = '<meta property="og:' . $property . '" content="' . e($content) . '">';
            }
        }
        
        // Twitter Card tags
        $twitterData = array_merge([
            'card' => 'summary_large_image',
            'title' => $this->meta['title'] ?? config('app.name', 'G0-CAMPUS'),
            'description' => $this->meta['description'] ?? '',
        ], $this->twitterCard);
        
        if (isset($this->meta['image'])) {
            $twitterData['image'] = $this->meta['image'];
        }
        
        foreach ($twitterData as $name => $content) {
            if ($content) {
                $tags[] = '<meta name="twitter:' . $name . '" content="' . e($content) . '">';
            }
        }
        
        return implode("\n    ", $tags);
    }
    
    public function generateStructuredData(): string
    {
        if (empty($this->structuredData)) {
            return '';
        }
        
        $scripts = [];
        foreach ($this->structuredData as $data) {
            $scripts[] = '<script type="application/ld+json">' . 
                        json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . 
                        '</script>';
        }
        
        return implode("\n    ", $scripts);
    }
    
    public function forNews($news = null): self
    {
        if ($news) {
            // Specific news article SEO
            $this->setTitle($news->title . ' - ' . config('app.name', 'G0-CAMPUS'))
                 ->setDescription($news->excerpt ?? strip_tags(substr($news->content, 0, 160)))
                 ->setCanonical(route('news.show', $news->slug));
            
            if ($news->featured_image) {
                $this->setImage(
                    asset('storage/' . $news->featured_image),
                    $news->title
                );
            }
        
            // Add News Article structured data
            $this->addStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'NewsArticle',
                'headline' => $news->title,
                'description' => $news->excerpt ?? strip_tags(substr($news->content, 0, 160)),
                'author' => [
                    '@type' => 'Person',
                    'name' => $news->user->name ?? 'Admin'
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => config('app.name', 'G0-CAMPUS'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo.png')
                    ]
                ],
                'datePublished' => $news->published_at?->toISOString(),
                'dateModified' => $news->updated_at->toISOString(),
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => route('news.show', $news->slug)
                ]
            ]);
        } else {
            // News listing page SEO
            $this->setTitle('Berita Terkini - ' . config('app.name', 'G0-CAMPUS'))
                 ->setDescription('Ikuti berita terkini dan informasi terbaru dari ' . config('app.name', 'G0-CAMPUS'))
                 ->setCanonical(route('news.index'))
                 ->setKeywords('berita, informasi, pengumuman, kampus, ' . strtolower(config('app.name', 'G0-CAMPUS')));
        }
        
        return $this;
    }
    
    public function forGallery($gallery = null): self
    {
        if ($gallery) {
            // Specific gallery item SEO
            $this->setTitle($gallery->title . ' - Galeri - ' . config('app.name', 'G0-CAMPUS'))
                 ->setDescription($gallery->description ?? 'Galeri foto ' . $gallery->title)
                 ->setCanonical(route('gallery.show', $gallery->slug));
            
            if ($gallery->image_url) {
                $this->setImage($gallery->image_url, $gallery->title);
            }
            
            // Add ImageGallery structured data
            $this->addStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'ImageGallery',
                'name' => $gallery->title,
                'description' => $gallery->description,
                'url' => route('gallery.show', $gallery->slug),
                'dateCreated' => $gallery->created_at->toISOString()
            ]);
        } else {
            // Gallery listing page SEO
            $this->setTitle('Galeri - ' . config('app.name', 'G0-CAMPUS'))
                 ->setDescription('Kumpulan foto dan video kegiatan di ' . config('app.name', 'G0-CAMPUS'))
                 ->setCanonical(route('gallery.index'))
                 ->setKeywords('galeri, foto, video, kegiatan, ' . strtolower(config('app.name', 'G0-CAMPUS')));
        }
        
        return $this;
    }
    
    public function forPage($page = null): self
    {
        if ($page) {
            // Specific page SEO
            $this->setTitle($page->title . ' - ' . config('app.name', 'G0-CAMPUS'))
                 ->setDescription($page->meta_description ?? strip_tags(substr($page->content, 0, 160)))
                 ->setCanonical(route('page.show', $page->slug));
            
            if ($page->meta_keywords) {
                $this->setKeywords($page->meta_keywords);
            }
            
            if ($page->featured_image) {
                $this->setImage(
                    asset('storage/' . $page->featured_image),
                    $page->title
                );
            }
            
            // Add WebPage structured data
            $this->addStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $page->title,
                'description' => $page->meta_description ?? strip_tags(substr($page->content, 0, 160)),
                'url' => route('page.show', $page->slug),
                'datePublished' => $page->created_at->toISOString(),
                'dateModified' => $page->updated_at->toISOString()
            ]);
        } else {
            // Homepage SEO
            $siteName = config('app.name', 'G0-CAMPUS');
            $this->setTitle($siteName . ' - Kampus Modern untuk Masa Depan Cemerlang')
                 ->setDescription('Bergabunglah dengan ' . $siteName . ' untuk pendidikan berkualitas tinggi dengan fasilitas modern dan kurikulum terdepan')
                 ->setCanonical(url('/'))
                 ->setKeywords('kampus, universitas, pendidikan, akademik, ' . strtolower($siteName));
            
            // Add Organization structured data for homepage
            $this->addStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'EducationalOrganization',
                'name' => $siteName,
                'description' => 'Kampus Modern untuk Masa Depan Cemerlang',
                'url' => url('/'),
                'logo' => asset('favicon.png'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressCountry' => 'ID'
                ]
            ]);
        }
        
        return $this;
    }
    
    public function forSearch($query, $total): self
    {
        $title = $query ? "Pencarian '{$query}' - " . config('app.name', 'G0-CAMPUS') : 'Pencarian - ' . config('app.name', 'G0-CAMPUS');
        $description = $query ? "Hasil pencarian untuk '{$query}' di " . config('app.name', 'G0-CAMPUS') . " ({$total} hasil ditemukan)" : 'Cari berita, galeri, pengumuman, dan informasi lainnya';
        
        $this->setTitle($title)
             ->setDescription($description)
             ->setCanonical(request()->url());
        
        return $this;
    }
}
