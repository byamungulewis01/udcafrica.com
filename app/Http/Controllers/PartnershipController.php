<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class PartnershipController extends Controller
{

    public function index()
    {
        $partnerships = Partnership::orderBy('order')->get();

        return Inertia::render('Admin/Partnerships/Index', [
            'partnerships' => $partnerships,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('partnerships', 'public');
                $data['image'] = Storage::url($imagePath);
            }

            Partnership::create($data);

            return redirect()->back()->with('success', 'Partnership created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create partnership: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Partnership $partnership)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($partnership->image) {
                    Storage::disk('public')->delete($partnership->image);
                }
                $imagePath = $request->file('image')->store('partnerships', 'public');
                $data['image'] = Storage::url($imagePath);
            } else {
                $data['image'] = $partnership->image;
            }

            $partnership->update($data);

            return redirect()->back()->with('success', 'Partnership updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the partnership.');
        }
    }

    public function destroy(Partnership $partnership)
    {
        try {
            // Delete image if exists
                if ($partnership->image) {
                Storage::disk('public')->delete($partnership->image);
            }

            $partnership->delete();
            return redirect()->back()->with('success', 'Partnership deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the partnership.');
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:partnerships,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                Partnership::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
