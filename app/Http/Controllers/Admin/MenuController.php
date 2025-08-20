<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['page', 'parent', 'children'])
                    ->parent()
                    ->ordered()
                    ->get();
        
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $pages = Page::published()->orderBy('title')->get();
        $parentMenus = Menu::whereNull('parent_id')->orderBy('sort_order')->get();
        
        return view('admin.menus.create', compact('pages', 'parentMenus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|string|max:255',
            'location' => 'required|in:header,footer,sidebar',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();
        
        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['target'] = $data['target'] ?? '_self';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Validate URL or Page
        if (!$data['url'] && !$data['page_id']) {
            return redirect()->back()
                           ->withErrors(['url' => 'URL atau Halaman harus diisi salah satu'])
                           ->withInput();
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')
                        ->with('success', 'Menu berhasil ditambahkan');
    }

    public function show(Menu $menu)
    {
        $menu->load(['page', 'parent', 'children']);
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $pages = Page::published()->orderBy('title')->get();
        $parentMenus = Menu::where('id', '!=', $menu->id)
                          ->whereNull('parent_id')
                          ->orderBy('sort_order')
                          ->get();
        
        return view('admin.menus.edit', compact('menu', 'pages', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|string|max:255',
            'location' => 'required|in:header,footer,sidebar',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();
        
        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['target'] = $data['target'] ?? '_self';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Validate URL or Page
        if (!$data['url'] && !$data['page_id']) {
            return redirect()->back()
                           ->withErrors(['url' => 'URL atau Halaman harus diisi salah satu'])
                           ->withInput();
        }

        // Prevent setting parent as itself or its child
        if ($data['parent_id'] == $menu->id) {
            return redirect()->back()
                           ->withErrors(['parent_id' => 'Menu tidak boleh menjadi parent dari dirinya sendiri'])
                           ->withInput();
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')
                        ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Menu tidak dapat dihapus karena memiliki submenu');
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
                        ->with('success', 'Menu berhasil dihapus');
    }

    public function toggleStatus(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $menu->is_active,
            'message' => 'Status menu berhasil diubah'
        ]);
    }

    public function updateOrder(Request $request)
    {
        $menus = $request->input('menus');
        
        foreach ($menus as $index => $menuId) {
            Menu::where('id', $menuId)->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan menu berhasil diperbarui'
        ]);
    }
}
