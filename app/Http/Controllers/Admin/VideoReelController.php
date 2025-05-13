<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoReel;
use Illuminate\Support\Facades\File;

class VideoReelController extends Controller
{
    public function index()
    {
        $reels = VideoReel::orderBy('order')->get();
        return view('admin.video-reels.index', compact('reels'));
    }

    public function create()
    {
        return view('admin.video-reels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,mov,ogg,webm|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $videoFile = null;
        $thumbnail = null;

        // Create directories if they don't exist
        $videoPath = public_path('videos/reels');
        $thumbnailPath = public_path('images/reels/thumbnails');
        
        if (!File::isDirectory($videoPath)) {
            File::makeDirectory($videoPath, 0777, true);
        }
        
        if (!File::isDirectory($thumbnailPath)) {
            File::makeDirectory($thumbnailPath, 0777, true);
        }

        // Handle video file upload
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $videoFile = time() . '_' . $file->getClientOriginalName();
            $file->move($videoPath, $videoFile);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = time() . '_' . $file->getClientOriginalName();
            $file->move($thumbnailPath, $thumbnail);
        }

        VideoReel::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_file' => $videoFile,
            'thumbnail' => $thumbnail,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.video-reels.index')
            ->with('success', 'Видео рилс успешно создан');
    }

    public function edit($id)
    {
        $videoReel = VideoReel::findOrFail($id);
        return view('admin.video-reels.edit', compact('videoReel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,webm|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $videoReel = VideoReel::findOrFail($id);
        
        // Create directories if they don't exist
        $videoPath = public_path('videos/reels');
        $thumbnailPath = public_path('images/reels/thumbnails');
        
        if (!File::isDirectory($videoPath)) {
            File::makeDirectory($videoPath, 0777, true);
        }
        
        if (!File::isDirectory($thumbnailPath)) {
            File::makeDirectory($thumbnailPath, 0777, true);
        }
        
        // Handle video file upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($videoReel->video_file && File::exists($videoPath . '/' . $videoReel->video_file)) {
                File::delete($videoPath . '/' . $videoReel->video_file);
            }
            
            $file = $request->file('video');
            $videoFile = time() . '_' . $file->getClientOriginalName();
            $file->move($videoPath, $videoFile);
            $videoReel->video_file = $videoFile;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($videoReel->thumbnail && File::exists($thumbnailPath . '/' . $videoReel->thumbnail)) {
                File::delete($thumbnailPath . '/' . $videoReel->thumbnail);
            }
            
            $file = $request->file('thumbnail');
            $thumbnail = time() . '_' . $file->getClientOriginalName();
            $file->move($thumbnailPath, $thumbnail);
            $videoReel->thumbnail = $thumbnail;
        }

        $videoReel->title = $request->title;
        $videoReel->description = $request->description;
        $videoReel->is_active = $request->has('is_active') ? 1 : 0;
        $videoReel->order = $request->order ?? 0;
        $videoReel->save();

        return redirect()->route('admin.video-reels.index')
            ->with('success', 'Видео рилс успешно обновлен');
    }

    public function destroy($id)
    {
        $videoReel = VideoReel::findOrFail($id);
        
        $videoPath = public_path('videos/reels');
        $thumbnailPath = public_path('images/reels/thumbnails');
        
        // Delete video file if exists
        if ($videoReel->video_file && File::exists($videoPath . '/' . $videoReel->video_file)) {
            File::delete($videoPath . '/' . $videoReel->video_file);
        }
        
        // Delete thumbnail if exists
        if ($videoReel->thumbnail && File::exists($thumbnailPath . '/' . $videoReel->thumbnail)) {
            File::delete($thumbnailPath . '/' . $videoReel->thumbnail);
        }
        
        $videoReel->delete();
        
        return redirect()->route('admin.video-reels.index')
            ->with('success', 'Видео рилс успешно удалён');
    }
}
