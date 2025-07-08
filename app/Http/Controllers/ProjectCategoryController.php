<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProjectCategory::orderBy('order')->get();

        return Inertia::render('Admin/Projects/Categories', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:project_categories,slug',
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

            ProjectCategory::create($data);

            return redirect()->route('project-categories.index')
                ->with('success', 'Project category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create project category: ' . $e->getMessage()]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectCategory $projectCategory)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'unique:project_categories,slug,' . $projectCategory->id,
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

            $projectCategory->update($data);

            return redirect()->route('project-categories.index')
                ->with('success', 'Project category updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update project category: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        try {
            $projectCategory->delete();
            return redirect()->route('project-categories.index')
                ->with('success', 'Project category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete project category: ' . $e->getMessage());
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:project_categories,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                ProjectCategory::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
