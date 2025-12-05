<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategoryId = $request->get('category');
        
        // Get active categories with their active videos
        $categories = VideoCategory::where('is_active', true)
            ->with(['activeVideos' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
            ->orderBy('name', 'asc')
            ->get();

        // Get selected category if specified
        $selectedCategory = null;
        if ($selectedCategoryId) {
            $selectedCategory = VideoCategory::where('id', $selectedCategoryId)
                ->where('is_active', true)
                ->with(['activeVideos' => function ($query) {
                    $query->orderBy('order', 'asc');
                }])
                ->first();
        }

        return view('customer.videos.index', compact('categories', 'selectedCategory'));
    }

    public function show(Video $video)
    {
        // Ensure video is active
        if (!$video->is_active) {
            abort(404);
        }

        // Load related videos from same category
        $relatedVideos = Video::where('video_category_id', $video->video_category_id)
            ->where('id', '!=', $video->id)
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->limit(6)
            ->get();

        $video->load('category');

        return view('customer.videos.show', compact('video', 'relatedVideos'));
    }
}
