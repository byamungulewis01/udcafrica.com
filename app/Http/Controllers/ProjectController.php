<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['category'])
            ->orderBy('order')
            ->latest()
            ->get();

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProjectCategory::where('is_active', true)->orderBy('order')->get();

        return Inertia::render('Admin/Projects/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:10|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:projects,slug',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
                ],
                'description' => 'required|string|min:20|max:1000',
                'content' => 'required|string',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'client' => 'required|string|max:255',
                'duration' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'contractor' => 'nullable|string|max:255',
                'gallery' => 'nullable|array',
                'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_featured' => 'boolean',
                'is_published' => 'boolean',
                'category_id' => 'required|exists:project_categories,id',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
            ]);

            $data = $request->all();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $imagePath = $request->file('featured_image')->store('projects', 'public');
                $data['featured_image'] = Storage::url($imagePath);
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery')) {
                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $imagePath = $file->store('projects/gallery', 'public');
                    $galleryPaths[] = Storage::url($imagePath);
                }
                $data['gallery'] = $galleryPaths;
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            Project::create($data);

            return redirect()->route('projects.index')
                ->with('success', 'Project created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create project: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project->load(['category']);
        $categories = ProjectCategory::where('is_active', true)->orderBy('order')->get();

        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:10|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:projects,slug,' . $project->id,
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
                ],
                'description' => 'required|string|min:20|max:1000',
                'content' => 'required|string',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'client' => 'required|string|max:255',
                'duration' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'contractor' => 'nullable|string|max:255',
                'gallery' => 'nullable|array',
                'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_featured' => 'boolean',
                'is_published' => 'boolean',
                'category_id' => 'required|exists:project_categories,id',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
            ]);

            $data = $request->all();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old featured image if exists
                if ($project->featured_image) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $project->featured_image));
                }

                $imagePath = $request->file('featured_image')->store('projects', 'public');
                $data['featured_image'] = Storage::url($imagePath);
            } else {
                // Keep existing featured image
                $data['featured_image'] = $project->featured_image;
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery')) {
                // Delete old gallery images if exist
                if ($project->gallery) {
                    foreach ($project->gallery as $image) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $image));
                    }
                }

                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $imagePath = $file->store('projects/gallery', 'public');
                    $galleryPaths[] = Storage::url($imagePath);
                }
                $data['gallery'] = $galleryPaths;
            } else {
                // Keep existing gallery images
                $data['gallery'] = $project->gallery;
            }

            $project->update($data);

            return redirect()->route('projects.index')
                ->with('success', 'Project updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update project: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            // Delete featured image if exists
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }
            // Delete gallery images if exists
            if ($project->gallery) {
                foreach ($project->gallery as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $project->delete();
            return redirect()->route('projects.index')
                ->with('success', 'Project deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:projects,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                Project::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
