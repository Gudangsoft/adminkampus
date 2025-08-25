<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url'   => 'nullable|url',
            'link'        => 'nullable|url',
            'link_target' => 'in:_self,_blank',
            'button_text' => 'nullable|string|max:50',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'boolean'
        ]);

        $data = $request->only([
            'title', 'description', 'link', 'link_target',
            'button_text', 'sort_order'
        ]);

        // Handle image upload or URL
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        } else {
            return back()->withErrors([
                'image' => 'Gambar slider diperlukan. Upload file atau masukkan URL gambar.'
            ])->withInput();
        }

        // Set default values
        $data['is_active']   = $request->boolean('is_active');
        $data['link_target'] = $request->link_target ?? '_self';

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url'   => 'nullable|url',
            'link'        => 'nullable|url',
            'link_target' => 'in:_self,_blank',
            'button_text' => 'nullable|string|max:50',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'boolean'
        ]);

        $data = $request->only([
            'title', 'description', 'link', 'link_target',
            'button_text', 'sort_order'
        ]);

        // Handle image upload or URL
        if ($request->hasFile('image')) {
            if ($slider->image && !filter_var($slider->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        // Set default values
        $data['is_active']   = $request->boolean('is_active');
        $data['link_target'] = $request->link_target ?? '_self';

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        // Hapus hanya jika file lokal
        if ($slider->image && !filter_var($slider->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus!');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);

        $status = $slider->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Slider berhasil {$status}!");
    }

    /**
     * Update sort order.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items'            => 'required|array',
            'items.*.id'       => 'required|exists:sliders,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            Slider::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan slider berhasil diperbarui!'
        ]);
    }
}
