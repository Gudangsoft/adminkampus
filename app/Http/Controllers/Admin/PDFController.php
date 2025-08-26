<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\News;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Gallery;

class PDFController extends Controller
{
    public function index()
    {
        return view('admin.pdf.index');
    }

    public function generateNews()
    {
        $news = News::with('category')->latest()->get();
        
        $pdf = Pdf::loadView('admin.pdf.news', compact('news'));
        return $pdf->download('news-report-' . date('Y-m-d') . '.pdf');
    }

    public function generateNewsReport()
    {
        return $this->generateNews();
    }

    public function generateLecturers()
    {
        $lecturers = Lecturer::latest()->get();
        
        $pdf = Pdf::loadView('admin.pdf.lecturers', compact('lecturers'));
        return $pdf->download('lecturers-report-' . date('Y-m-d') . '.pdf');
    }

    public function generateLecturersReport()
    {
        return $this->generateLecturers();
    }

    public function generateGallery()
    {
        $galleries = Gallery::latest()->get();
        
        $pdf = Pdf::loadView('admin.pdf.gallery', compact('galleries'));
        return $pdf->download('gallery-report-' . date('Y-m-d') . '.pdf');
    }

    public function generateGalleryReport()
    {
        return $this->generateGallery();
    }

    public function generateUsers()
    {
        $users = User::latest()->get();
        
        $pdf = Pdf::loadView('admin.pdf.users', compact('users'));
        return $pdf->download('users-report-' . date('Y-m-d') . '.pdf');
    }

    public function generateUsersReport()
    {
        return $this->generateUsers();
    }

    public function generateCustomReport(Request $request)
    {
        $type = $request->get('type', 'general');
        
        switch ($type) {
            case 'news':
                return $this->generateNews();
            case 'lecturers':
                return $this->generateLecturers();
            case 'gallery':
                return $this->generateGallery();
            case 'users':
                return $this->generateUsers();
            default:
                $data = [
                    'title' => 'General Report',
                    'generated_at' => now(),
                ];
                
                $pdf = Pdf::loadView('admin.pdf.general', $data);
                return $pdf->download('general-report-' . date('Y-m-d') . '.pdf');
        }
    }
}
