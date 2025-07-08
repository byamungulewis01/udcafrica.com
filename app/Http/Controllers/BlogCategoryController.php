<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::orderBy('order')->get();
        return Inertia::render('Admin/Blogs/Categories', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:blog_categories,slug',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
                ],
                'description' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $data = $request->all();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            BlogCategory::create($data);

            return redirect()->route('blog-categories.index')
                ->with('success', 'Category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create category: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, BlogCategory $blog_category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:blog_categories,slug,' . $blog_category->id,
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
                ],
                'description' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $data = $request->all();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $blog_category->update($data);

            return redirect()->back()
                ->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update category: ' . $e->getMessage()]);
        }
    }

    public function destroy(BlogCategory $blog_category)
    {
        try {
            $blog_category->delete();
            return redirect()->route('blog-categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:blog_categories,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                BlogCategory::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
