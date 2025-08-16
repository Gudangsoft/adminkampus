<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['parent', 'children'])
                    ->parent()
                    ->ordered()
                    ->get();
        
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        
        return view('admin.menus.create', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();
        $data['order'] = $data['order'] ?? 0;
        $data['is_active'] = $request->has('is_active');
        $data['target'] = $data['target'] ?? '_self';

        Menu::create($data);

        return redirect()->route('admin.menus.index')
                        ->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu)
    {
        $menu->load(['parent', 'children']);
        
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
                          ->where('id', '!=', $menu->id)
                          ->orderBy('order')
                          ->get();
        
        return view('admin.menus.edit', compact('menu', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();
        $data['order'] = $data['order'] ?? 0;
        $data['is_active'] = $request->has('is_active');
        $data['target'] = $data['target'] ?? '_self';

        $menu->update($data);

        return redirect()->route('admin.menus.index')
                        ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        // Delete children first
        $menu->children()->delete();
        
        // Delete the menu
        $menu->delete();

        return redirect()->route('admin.menus.index')
                        ->with('success', 'Menu deleted successfully.');
    }

    public function toggleStatus(Menu $menu)
    {
        $menu->update([
            'is_active' => !$menu->is_active
        ]);

        return response()->json([
            'success' => true,
            'status' => $menu->is_active,
            'message' => 'Menu status updated successfully.'
        ]);
    }

    public function updateOrder(Request $request)
    {
        $menuOrder = $request->input('menu_order', []);

        foreach ($menuOrder as $index => $menuId) {
            Menu::where('id', $menuId)->update(['order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu order updated successfully.'
        ]);
    }
}
