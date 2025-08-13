<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Lecturer;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function index()
    {
        return view('admin.system.pdf.index');
    }
    
    public function generateNews(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'category_id' => 'nullable|exists:news_categories,id',
            'status' => 'nullable|in:published,draft'
        ]);

        $query = News::with(['category', 'user']);

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $news = $query->latest()->get();

        $pdf = Pdf::loadView('admin.system.pdf.news', compact('news', 'request'));
        
        return $pdf->download('news-report-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function generateLecturers(Request $request)
    {
        $request->validate([
            'faculty_id' => 'nullable|exists:faculties,id',
            'status' => 'nullable|in:active,inactive'
        ]);

        $query = Lecturer::with('faculty');

        if ($request->faculty_id) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->status) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        $lecturers = $query->orderBy('name')->get();

        $pdf = Pdf::loadView('admin.system.pdf.lecturers', compact('lecturers', 'request'));
        
        return $pdf->download('lecturers-report-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function generateGallery(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:gallery_categories,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from'
        ]);

        $query = Gallery::with('category');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $galleries = $query->latest()->get();

        $pdf = Pdf::loadView('admin.system.pdf.gallery', compact('galleries', 'request'));
        
        return $pdf->download('gallery-report-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function generateUsers(Request $request)
    {
        $request->validate([
            'role' => 'nullable|in:admin,editor,viewer',
            'status' => 'nullable|in:active,inactive'
        ]);

        $query = User::query();

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->status) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        $users = $query->latest()->get();

        $pdf = Pdf::loadView('admin.system.pdf.users', compact('users', 'request'));
        
        return $pdf->download('users-report-' . now()->format('Y-m-d') . '.pdf');
    }
    
    public function generateCustom(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'orientation' => 'nullable|in:portrait,landscape',
            'paper_size' => 'nullable|in:a4,a3,letter'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'generated_at' => now(),
            'generated_by' => auth()->user()->name
        ];

        $pdf = Pdf::loadView('admin.system.pdf.custom', $data);
        
        if ($request->orientation) {
            $pdf->setPaper($request->paper_size ?? 'a4', $request->orientation);
        }
        
        return $pdf->download(str_slug($request->title) . '-' . now()->format('Y-m-d') . '.pdf');
    }
}
