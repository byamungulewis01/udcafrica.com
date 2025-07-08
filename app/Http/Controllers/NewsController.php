<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::with('createdBy')->orderBy('created_at', 'desc')->get();
        return Inertia::render('Admin/News/Index', [
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Admin/News/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'source_url' => 'required|url|string|max:255',
                'source_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'source_name' => 'nullable|string|max:255',
                'is_featured' => 'required|boolean',
                'is_published' => 'required|boolean',
            ]);

            $data = $request->all();

            if ($request->hasFile('featured_image')) {
                $imagePath = $request->file('featured_image')->store('news', 'public');
                $data['featured_image'] = Storage::url($imagePath);
            }

            if ($request->hasFile('source_logo')) {
                $imagePath = $request->file('source_logo')->store('news', 'public');
                $data['source_logo'] = Storage::url($imagePath);
            }

            News::create($data);
            return redirect()->route('news.index')->with('success', 'News created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create news: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
        return Inertia::render('Admin/News/Edit', [
            'news' => $news
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'source_url' => 'required|url|string|max:255',
                'source_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'source_name' => 'nullable|string|max:255',
                'is_featured' => 'required|boolean',
                'is_published' => 'required|boolean',
            ]);

            $data = $request->all();
            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old image
                if ($news->featured_image) {
                    Storage::disk('public')->delete($news->featured_image);
                }
                $imagePath = $request->file('featured_image')->store('news', 'public');
                $data['featured_image'] = Storage::url($imagePath);
            } else {
                $data['featured_image'] = $news->featured_image;
            }

            if ($request->hasFile('source_logo')) {
                // Delete old image
                if ($news->source_logo) {
                    Storage::disk('public')->delete($news->source_logo);
                }
                $imagePath = $request->file('source_logo')->store('news', 'public');
                $data['source_logo'] = Storage::url($imagePath);
            } else {
                $data['source_logo'] = $news->source_logo;
            }


            $news->update($data);
            return redirect()->route('news.index')->with('success', 'News updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update news: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
        try {
            // Delete featured image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            // Delete source logo
            if ($news->source_logo) {
                Storage::disk('public')->delete($news->source_logo);
            }
            $news->delete();
            return redirect()->route('news.index')->with('success', 'News deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete news: ' . $e->getMessage());
        }
    }
}
