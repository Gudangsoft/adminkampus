<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = NewsCategory::withCount('news')->latest()->paginate(15);
        return view('admin.news-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.news-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:news_categories,name',
            'description' => 'nullable',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        NewsCategory::create($data);

        return redirect()->route('admin.news-categories.index')->with('success', 'Category created successfully.');
    }

    public function show(NewsCategory $newsCategory)
    {
        $newsCategory->load(['news' => function($query) {
            $query->latest()->take(10);
        }]);
        
        return view('admin.news-categories.show', compact('newsCategory'));
    }

    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news-categories.edit', compact('newsCategory'));
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $request->validate([
            'name' => 'required|max:255|unique:news_categories,name,' . $newsCategory->id,
            'description' => 'nullable',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $newsCategory->update($data);

        return redirect()->route('admin.news-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        if ($newsCategory->news()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with existing news.');
        }
        
        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')->with('success', 'Category deleted successfully.');
    }
}
