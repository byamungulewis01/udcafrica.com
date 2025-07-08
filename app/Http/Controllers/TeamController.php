<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('order')->get();

        return Inertia::render('Admin/Teams/Index', [
            'teams' => $teams,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'order' => 'nullable|integer',
                'is_active' => 'boolean'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('teams', 'public');
                $data['image'] = Storage::url($imagePath);
            }

            Team::create($data);

            return redirect()->back()->with('success', 'Team member created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create team member: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Team $team)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'order' => 'nullable|integer',
                'is_active' => 'boolean'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($team->image) {
                    Storage::disk('public')->delete($team->image);
                }
                $imagePath = $request->file('image')->store('teams', 'public');
                $data['image'] = Storage::url($imagePath);
            } else {
                $data['image'] = $team->image;
            }

            $team->update($data);

            return redirect()->back()->with('success', 'Team member updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the team member.');
        }
    }

    public function destroy(Team $team)
    {
        try {
            // Delete image if exists
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }

            $team->delete();
            return redirect()->back()->with('success', 'Team member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the team member.');
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:teams,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                Team::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
