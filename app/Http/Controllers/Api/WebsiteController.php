<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Blog;

class WebsiteController extends Controller
{
    //
    public function getProjects()
    {
        $collection = Project::with(['category'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('order')
            ->latest()
            ->get();
        $projects = ProjectResource::collection($collection);
        return response()->json($projects);
    }
    // featured projects
    public function getFeaturedProjects()
    {
        $collection = Project::with(['category'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('order')
            ->latest()
            ->limit(3)
            ->get();
        $projects = ProjectResource::collection($collection);
        return response()->json($projects);
    }
    // featured blogs
    public function getFeaturedBlogs()
    {
        $projects = Blog::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('order')
            ->latest()
            ->limit(3)
            ->select('id', 'slug', 'title', 'excerpt', 'featured_image', 'published_at')
            ->get();
        return response()->json($projects);
    }
    // get all blogs
    public function getAllBlogs()
    {
        $blogs = Blog::where('is_published', true)
            ->orderBy('order')
            ->latest()
            ->select('id', 'slug', 'title', 'excerpt', 'featured_image', 'published_at')
            ->get();
        return response()->json($blogs);
    }
}
