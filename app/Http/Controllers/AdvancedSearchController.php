<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvancedSearchController extends Controller
{
    /**
     * Display advanced search page
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');
        $category = $request->get('category', '');
        $date_from = $request->get('date_from', '');
        $date_to = $request->get('date_to', '');
        $sort = $request->get('sort', 'relevance');
        
        $results = collect();
        $total = 0;
        
        if ($query) {
            $results = $this->performSearch($query, $type, $category, $date_from, $date_to, $sort);
            $total = $results->count();
        }
        
        // Get filter options
        $newsCategories = NewsCategory::orderBy('name')->get();
        $galleryCategories = GalleryCategory::orderBy('name')->get();
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();
        
        return view('search.advanced', compact(
            'query', 'type', 'category', 'date_from', 'date_to', 'sort',
            'results', 'total', 'newsCategories', 'galleryCategories', 'faculties'
        ));
    }

    /**
     * Perform the actual search
     */
    private function performSearch($query, $type, $category, $dateFrom, $dateTo, $sort)
    {
        $results = collect();
        
        // Search in different content types
        if ($type === 'all' || $type === 'news') {
            $newsResults = $this->searchNews($query, $category, $dateFrom, $dateTo);
            $results = $results->concat($newsResults);
        }
        
        if ($type === 'all' || $type === 'announcements') {
            $announcementResults = $this->searchAnnouncements($query, $dateFrom, $dateTo);
            $results = $results->concat($announcementResults);
        }
        
        if ($type === 'all' || $type === 'galleries') {
            $galleryResults = $this->searchGalleries($query, $category, $dateFrom, $dateTo);
            $results = $results->concat($galleryResults);
        }
        
        if ($type === 'all' || $type === 'students') {
            $studentResults = $this->searchStudents($query, $category);
            $results = $results->concat($studentResults);
        }
        
        if ($type === 'all' || $type === 'lecturers') {
            $lecturerResults = $this->searchLecturers($query, $category);
            $results = $results->concat($lecturerResults);
        }
        
        if ($type === 'all' || $type === 'pages') {
            $pageResults = $this->searchPages($query);
            $results = $results->concat($pageResults);
        }
        
        // Sort results
        return $this->sortResults($results, $sort);
    }

    /**
     * Search in news
     */
    private function searchNews($query, $category, $dateFrom, $dateTo)
    {
        $search = News::where('status', 'published')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%");
            });
            
        if ($category) {
            $search->where('news_category_id', $category);
        }
        
        if ($dateFrom) {
            $search->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $search->whereDate('created_at', '<=', $dateTo);
        }
        
        return $search->with('newsCategory')->get()->map(function($item) use ($query) {
            return [
                'type' => 'news',
                'title' => $item->title,
                'content' => $item->excerpt ?? strip_tags($item->content),
                'url' => route('news.show', $item->slug),
                'image' => $item->featured_image ? asset('storage/' . $item->featured_image) : null,
                'date' => $item->created_at,
                'category' => $item->newsCategory->name ?? '',
                'relevance' => $this->calculateRelevance($query, $item->title . ' ' . $item->content),
                'model' => $item
            ];
        });
    }

    /**
     * Search in announcements
     */
    private function searchAnnouncements($query, $dateFrom, $dateTo)
    {
        $search = Announcement::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            });
            
        if ($dateFrom) {
            $search->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $search->whereDate('created_at', '<=', $dateTo);
        }
        
        return $search->get()->map(function($item) use ($query) {
            return [
                'type' => 'announcement',
                'title' => $item->title,
                'content' => strip_tags($item->content),
                'url' => route('announcements.show', $item->slug),
                'image' => null,
                'date' => $item->created_at,
                'category' => 'Pengumuman',
                'relevance' => $this->calculateRelevance($query, $item->title . ' ' . $item->content),
                'model' => $item
            ];
        });
    }

    /**
     * Search in galleries
     */
    private function searchGalleries($query, $category, $dateFrom, $dateTo)
    {
        $search = Gallery::where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
            
        if ($category) {
            $search->where('gallery_category_id', $category);
        }
        
        if ($dateFrom) {
            $search->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $search->whereDate('created_at', '<=', $dateTo);
        }
        
        return $search->with('galleryCategory')->get()->map(function($item) use ($query) {
            return [
                'type' => 'gallery',
                'title' => $item->title,
                'content' => $item->description ?? '',
                'url' => route('gallery.show', $item->slug),
                'image' => $item->image_path ? asset('storage/' . $item->image_path) : null,
                'date' => $item->created_at,
                'category' => $item->galleryCategory->name ?? 'Galeri',
                'relevance' => $this->calculateRelevance($query, $item->title . ' ' . $item->description),
                'model' => $item
            ];
        });
    }

    /**
     * Search in students
     */
    private function searchStudents($query, $faculty)
    {
        $search = Student::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('nim', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            });
            
        if ($faculty) {
            $search->where('faculty_id', $faculty);
        }
        
        return $search->with('faculty', 'studyProgram')->get()->map(function($item) use ($query) {
            return [
                'type' => 'student',
                'title' => $item->name . ' (' . $item->nim . ')',
                'content' => $item->email . ' - ' . $item->studyProgram->name ?? '',
                'url' => route('mahasiswa.show', $item->nim),
                'image' => $item->photo ? asset('storage/' . $item->photo) : null,
                'date' => $item->created_at,
                'category' => $item->faculty->name ?? 'Mahasiswa',
                'relevance' => $this->calculateRelevance($query, $item->name . ' ' . $item->nim),
                'model' => $item
            ];
        });
    }

    /**
     * Search in lecturers
     */
    private function searchLecturers($query, $faculty)
    {
        $search = Lecturer::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('nip', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('specialization', 'LIKE', "%{$query}%");
            });
            
        if ($faculty) {
            $search->where('faculty_id', $faculty);
        }
        
        return $search->with('faculty')->get()->map(function($item) use ($query) {
            return [
                'type' => 'lecturer',
                'title' => $item->name . ' (' . $item->nip . ')',
                'content' => $item->specialization . ' - ' . $item->email,
                'url' => '#', // Add lecturer detail route if exists
                'image' => $item->photo ? asset('storage/' . $item->photo) : null,
                'date' => $item->created_at,
                'category' => $item->faculty->name ?? 'Dosen',
                'relevance' => $this->calculateRelevance($query, $item->name . ' ' . $item->specialization),
                'model' => $item
            ];
        });
    }

    /**
     * Search in pages
     */
    private function searchPages($query)
    {
        return Page::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->get()->map(function($item) use ($query) {
                return [
                    'type' => 'page',
                    'title' => $item->title,
                    'content' => strip_tags($item->content),
                    'url' => route('page.show', $item->slug),
                    'image' => null,
                    'date' => $item->created_at,
                    'category' => 'Halaman',
                    'relevance' => $this->calculateRelevance($query, $item->title . ' ' . $item->content),
                    'model' => $item
                ];
            });
    }

    /**
     * Calculate search relevance score
     */
    private function calculateRelevance($query, $content)
    {
        $score = 0;
        $query = strtolower($query);
        $content = strtolower($content);
        
        // Exact match in title gets highest score
        if (strpos($content, $query) !== false) {
            $score += 10;
        }
        
        // Word matches
        $queryWords = explode(' ', $query);
        foreach ($queryWords as $word) {
            if (strlen($word) > 2 && strpos($content, $word) !== false) {
                $score += 3;
            }
        }
        
        return $score;
    }

    /**
     * Sort search results
     */
    private function sortResults($results, $sort)
    {
        switch ($sort) {
            case 'date_desc':
                return $results->sortByDesc('date');
            case 'date_asc':
                return $results->sortBy('date');
            case 'title':
                return $results->sortBy('title');
            case 'relevance':
            default:
                return $results->sortByDesc('relevance');
        }
    }

    /**
     * AJAX search for autocomplete
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $suggestions = [];
        
        // News suggestions
        $news = News::where('status', 'published')
            ->where('title', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['title', 'slug']);
            
        foreach ($news as $item) {
            $suggestions[] = [
                'title' => $item->title,
                'type' => 'Berita',
                'url' => route('news.show', $item->slug)
            ];
        }
        
        // Announcement suggestions
        $announcements = Announcement::where('status', 'active')
            ->where('title', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get(['title', 'slug']);
            
        foreach ($announcements as $item) {
            $suggestions[] = [
                'title' => $item->title,
                'type' => 'Pengumuman',
                'url' => route('announcements.show', $item->slug)
            ];
        }
        
        return response()->json($suggestions);
    }
}
