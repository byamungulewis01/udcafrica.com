<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category'])
            ->orderBy('order')
            ->latest()
            ->get();

        return Inertia::render('Admin/Blogs/Index', [
            'blogs' => $blogs
        ]);
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('order')->get();

        return Inertia::render('Admin/Blogs/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:10|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:blogs,slug',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
                ],
                'excerpt' => 'nullable|string',
                'content' => 'required|string',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'author' => 'nullable|string|max:255',
                'published_at' => 'nullable|date',
                'is_featured' => 'boolean',
                'is_published' => 'boolean',
                'category_id' => 'required|exists:blog_categories,id',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
            ]);

            $data = $request->all();

            // Handle featured image upload (move to public/uploads/blogs)
            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/blogs'), $imageName);
                $data['featured_image'] = '/uploads/blogs/' . $imageName;
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            $data['created_by'] = Auth::id();

            Blog::create($data);

            return redirect()->route('blogs.index')
                ->with('success', 'Blog post created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create blog post: ' . $e->getMessage()]);
        }
    }

    public function edit(Blog $blog)
    {
        $blog->load(['category']);
        $categories = BlogCategory::where('is_active', true)->orderBy('order')->get();

        return Inertia::render('Admin/Blogs/Edit', [
            'blog' => $blog,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:10|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:blogs,slug,' . $blog->id,
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
                ],
                'excerpt' => 'nullable|string',
                'content' => 'required|string',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'published_at' => 'nullable|date',
                'is_featured' => 'boolean',
                'is_published' => 'boolean',
                'category_id' => 'required|exists:blog_categories,id',
            ]);

            $data = $request->all();

            // Handle featured image upload (move to public/uploads/blogs)
            if ($request->hasFile('featured_image')) {
                // Delete old image if exists and is a local file
                if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
                    @unlink(public_path($blog->featured_image));
                }
                $image = $request->file('featured_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/blogs'), $imageName);
                $data['featured_image'] = '/uploads/blogs/' . $imageName;
            } else {
                $data['featured_image'] = $blog->featured_image;
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            $blog->update($data);

            return redirect()->route('blogs.index')
                ->with('success', 'Blog post updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update blog post: ' . $e->getMessage()]);
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            // Delete featured image if exists and is a local file
            if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
                @unlink(public_path($blog->featured_image));
            }

            $blog->delete();
            return redirect()->route('blogs.index')
                ->with('success', 'Blog post deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete blog post: ' . $e->getMessage());
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:blogs,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                Blog::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
