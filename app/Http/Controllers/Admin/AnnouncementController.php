<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Announcement::with('user');
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }
        
        $announcements = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:draft,published,archived',
            'is_pinned' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        $data['is_pinned'] = $request->has('is_pinned');

        // Handle published_at
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:draft,published,archived',
            'is_pinned' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_pinned'] = $request->has('is_pinned');

        // Handle published_at
        if ($request->status === 'published' && !$announcement->published_at && !$request->published_at) {
            $data['published_at'] = now();
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
