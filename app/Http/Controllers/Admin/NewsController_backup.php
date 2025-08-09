<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create thumbnail using PHP GD extension
     */
    private function createThumbnail($source, $destination, $width, $height)
    {
        // Get image info
        $imageInfo = getimagesize($source);
        if (!$imageInfo) {
            return false;
        }

        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];

        // Create source image resource
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($source);
                break;
            default:
                return false;
        }

        if (!$sourceImage) {
            return false;
        }

        // Calculate dimensions
        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = $width / $height;

        if ($sourceRatio > $targetRatio) {
            // Source is wider
            $newHeight = $height;
            $newWidth = $height * $sourceRatio;
        } else {
            // Source is taller
            $newWidth = $width;
            $newHeight = $width / $sourceRatio;
        }

        // Create thumbnail image
        $thumbnail = imagecreatetruecolor($width, $height);
        
        // Handle transparency for PNG and GIF
        if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
            imagecolortransparent($thumbnail, imagecolorallocatealpha($thumbnail, 0, 0, 0, 127));
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
        }

        // Calculate crop position
        $cropX = ($newWidth - $width) / 2;
        $cropY = ($newHeight - $height) / 2;

        // Resize and crop
        imagecopyresampled($thumbnail, $sourceImage, -$cropX, -$cropY, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

        // Create directory if it doesn't exist
        $directory = dirname($destination);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save thumbnail
        $result = false;
        switch ($mimeType) {
            case 'image/jpeg':
                $result = imagejpeg($thumbnail, $destination, 85);
                break;
            case 'image/png':
                $result = imagepng($thumbnail, $destination, 8);
                break;
            case 'image/gif':
                $result = imagegif($thumbnail, $destination);
                break;
        }

        // Clean up memory
        imagedestroy($sourceImage);
        imagedestroy($thumbnail);

        return $result;
    }

    public function index(Request $request)
    {
        $query = News::with(['category', 'user']);
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $news = $query->latest()->paginate(15);
        $categories = NewsCategory::all();
        
        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        $categories = NewsCategory::where('is_active', true)->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:news_categories,id',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cropped_image' => 'nullable|string',
            'thumbnail_data' => 'nullable|string',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('featured_image') || $request->filled('cropped_image')) {
            
            // Use cropped image if available, otherwise use uploaded file
            if ($request->filled('cropped_image')) {
                // Handle base64 cropped image
                $imageData = $request->cropped_image;
                $image = str_replace('data:image/jpeg;base64,', '', $imageData);
                $image = str_replace(' ', '+', $image);
                $imageDecoded = base64_decode($image);
                
                $filename = time() . '_' . Str::slug($request->title) . '.jpg';
                $path = 'news/' . $filename;
                
                // Save main image
                Storage::disk('public')->put($path, $imageDecoded);
                $data['featured_image'] = $path;
                
                // Handle thumbnail
                if ($request->filled('thumbnail_data')) {
                    $thumbnailData = $request->thumbnail_data;
                    $thumbnail = str_replace('data:image/jpeg;base64,', '', $thumbnailData);
                    $thumbnail = str_replace(' ', '+', $thumbnail);
                    $thumbnailDecoded = base64_decode($thumbnail);
                    
                    $thumbnailPath = 'news/thumbnails/' . $filename;
                    
                    // Create thumbnails directory if it doesn't exist
                    if (!Storage::disk('public')->exists('news/thumbnails')) {
                        Storage::disk('public')->makeDirectory('news/thumbnails');
                    }
                    
                    Storage::disk('public')->put($thumbnailPath, $thumbnailDecoded);
                }
                
            } else {
                // Handle regular file upload
                $image = $request->file('featured_image');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $path = 'news/' . $filename;
                
                // Resize and save main image
                $img = Image::make($image)->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($path, $img->encode());
                $data['featured_image'] = $path;
                
                // Generate thumbnail automatically
                $thumbnailPath = 'news/thumbnails/' . $filename;
                
                // Create thumbnails directory if it doesn't exist
                if (!Storage::disk('public')->exists('news/thumbnails')) {
                    Storage::disk('public')->makeDirectory('news/thumbnails');
                }
                
                $thumbnail = Image::make($image)->fit(200, 150, function ($constraint) {
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($thumbnailPath, $thumbnail->encode());
            }
        }

        // Handle published_at
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('is_active', true)->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:news_categories,id',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cropped_image' => 'nullable|string',
            'thumbnail_data' => 'nullable|string',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('featured_image') || $request->filled('cropped_image')) {
            
            // Delete old images
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
                // Delete old thumbnail
                $oldThumbnailPath = 'news/thumbnails/' . basename($news->featured_image);
                if (Storage::disk('public')->exists($oldThumbnailPath)) {
                    Storage::disk('public')->delete($oldThumbnailPath);
                }
            }
            
            // Use cropped image if available, otherwise use uploaded file
            if ($request->filled('cropped_image')) {
                // Handle base64 cropped image
                $imageData = $request->cropped_image;
                $image = str_replace('data:image/jpeg;base64,', '', $imageData);
                $image = str_replace(' ', '+', $image);
                $imageDecoded = base64_decode($image);
                
                $filename = time() . '_' . Str::slug($request->title) . '.jpg';
                $path = 'news/' . $filename;
                
                // Save main image
                Storage::disk('public')->put($path, $imageDecoded);
                $data['featured_image'] = $path;
                
                // Handle thumbnail
                if ($request->filled('thumbnail_data')) {
                    $thumbnailData = $request->thumbnail_data;
                    $thumbnail = str_replace('data:image/jpeg;base64,', '', $thumbnailData);
                    $thumbnail = str_replace(' ', '+', $thumbnail);
                    $thumbnailDecoded = base64_decode($thumbnail);
                    
                    $thumbnailPath = 'news/thumbnails/' . $filename;
                    
                    // Create thumbnails directory if it doesn't exist
                    if (!Storage::disk('public')->exists('news/thumbnails')) {
                        Storage::disk('public')->makeDirectory('news/thumbnails');
                    }
                    
                    Storage::disk('public')->put($thumbnailPath, $thumbnailDecoded);
                }
                
            } else {
                // Handle regular file upload
                $image = $request->file('featured_image');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $path = 'news/' . $filename;
                
                // Resize and save main image
                $img = Image::make($image)->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($path, $img->encode());
                $data['featured_image'] = $path;
                
                // Generate thumbnail automatically
                $thumbnailPath = 'news/thumbnails/' . $filename;
                
                // Create thumbnails directory if it doesn't exist
                if (!Storage::disk('public')->exists('news/thumbnails')) {
                    Storage::disk('public')->makeDirectory('news/thumbnails');
                }
                
                $thumbnail = Image::make($image)->fit(200, 150, function ($constraint) {
                    $constraint->upsize();
                });
                
                Storage::disk('public')->put($thumbnailPath, $thumbnail->encode());
            }
        }

        // Handle published_at
        if ($request->status === 'published' && !$news->published_at && !$request->published_at) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        // Delete featured image
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }
}
