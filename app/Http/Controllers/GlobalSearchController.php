<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Page;
use App\Models\Gallery;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Support\Facades\DB;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'all');
        $limit = $request->get('limit', 20);

        if (empty($query)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Query tidak boleh kosong'
            ]);
        }

        $results = [];

        switch ($type) {
            case 'news':
                $results['news'] = $this->searchNews($query, $limit);
                break;
            case 'announcements':
                $results['announcements'] = $this->searchAnnouncements($query, $limit);
                break;
            case 'pages':
                $results['pages'] = $this->searchPages($query, $limit);
                break;
            case 'academic':
                $results['faculties'] = $this->searchFaculties($query, $limit);
                $results['study_programs'] = $this->searchStudyPrograms($query, $limit);
                break;
            case 'all':
            default:
                $results = [
                    'news' => $this->searchNews($query, 5),
                    'announcements' => $this->searchAnnouncements($query, 5),
                    'pages' => $this->searchPages($query, 5),
                    'galleries' => $this->searchGalleries($query, 5),
                    'faculties' => $this->searchFaculties($query, 3),
                    'study_programs' => $this->searchStudyPrograms($query, 3)
                ];
                break;
        }

        // Log search query for analytics
        $this->logSearch($query, $type, $request->ip());

        return response()->json([
            'status' => 'success',
            'query' => $query,
            'type' => $type,
            'results' => $results,
            'total_results' => $this->countTotalResults($results)
        ]);
    }

    private function searchNews($query, $limit)
    {
        return News::where('status', 'published')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%");
            })
            ->with('category:id,name')
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => route('news.show', $item->slug),
                    'excerpt' => $item->excerpt,
                    'image' => $item->featured_image ? asset('storage/' . $item->featured_image) : null,
                    'date' => $item->published_at->format('d M Y'),
                    'category' => $item->category->name ?? null,
                    'type' => 'news'
                ];
            });
    }

    private function searchAnnouncements($query, $limit)
    {
        return Announcement::where('status', 'published')
            ->where('start_date', '<=', now())
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->select('id', 'title', 'slug', 'content', 'start_date', 'is_featured')
            ->orderBy('is_featured', 'desc')
            ->orderBy('start_date', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => route('announcements.show', $item->slug),
                    'excerpt' => substr(strip_tags($item->content), 0, 150) . '...',
                    'date' => $item->start_date->format('d M Y'),
                    'featured' => $item->is_featured,
                    'type' => 'announcement'
                ];
            });
    }

    private function searchPages($query, $limit)
    {
        return Page::where('status', 'published')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->select('id', 'title', 'slug', 'content', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => route('pages.show', $item->slug),
                    'excerpt' => substr(strip_tags($item->content), 0, 150) . '...',
                    'updated' => $item->updated_at->format('d M Y'),
                    'type' => 'page'
                ];
            });
    }

    private function searchGalleries($query, $limit)
    {
        return Gallery::where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->select('id', 'title', 'slug', 'description', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => route('galleries.show', $item->slug),
                    'description' => $item->description,
                    'date' => $item->created_at->format('d M Y'),
                    'type' => 'gallery'
                ];
            });
    }

    private function searchFaculties($query, $limit)
    {
        return Faculty::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'slug', 'description')
            ->orderBy('name')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'url' => route('faculties.show', $item->slug),
                    'description' => $item->description,
                    'type' => 'faculty'
                ];
            });
    }

    private function searchStudyPrograms($query, $limit)
    {
        return StudyProgram::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with('faculty:id,name')
            ->select('id', 'name', 'slug', 'description', 'faculty_id', 'degree')
            ->orderBy('name')
            ->limit($limit)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'url' => route('study-programs.show', $item->slug),
                    'description' => $item->description,
                    'faculty' => $item->faculty->name ?? null,
                    'degree' => $item->degree,
                    'type' => 'study_program'
                ];
            });
    }

    private function logSearch($query, $type, $ip)
    {
        try {
            DB::table('search_logs')->insert([
                'query' => $query,
                'type' => $type,
                'ip_address' => $ip,
                'user_agent' => request()->userAgent(),
                'results_count' => 0, // Will be updated after counting
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            // Log error but don't break search functionality
            \Log::error('Failed to log search: ' . $e->getMessage());
        }
    }

    private function countTotalResults($results)
    {
        $total = 0;
        foreach ($results as $category) {
            if (is_array($category) || is_object($category)) {
                $total += count($category);
            }
        }
        return $total;
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = collect();

        // Get suggestions from different content types
        $newsTitles = News::where('status', 'published')
            ->where('title', 'LIKE', "%{$query}%")
            ->pluck('title')
            ->take(3);

        $announcementTitles = Announcement::where('is_active', true)
            ->where('title', 'LIKE', "%{$query}%")
            ->pluck('title')
            ->take(3);

        $pagesTitles = Page::where('is_active', true)
            ->where('title', 'LIKE', "%{$query}%")
            ->pluck('title')
            ->take(2);

        $suggestions = $suggestions
            ->concat($newsTitles)
            ->concat($announcementTitles)
            ->concat($pagesTitles)
            ->unique()
            ->take(8)
            ->values();

        return response()->json($suggestions);
    }
}
