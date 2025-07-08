<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();

        return Inertia::render('Admin/Services/Index', [
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'icon' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('services', 'public');
                $data['image'] = Storage::url($imagePath);
            }

            Service::create($data);

            return redirect()->back()->with('success', 'Service created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create service: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Service $service)
    {
        //  dd($request->all());
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'icon' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $imagePath = $request->file('image')->store('services', 'public');
                $data['image'] = Storage::url($imagePath);
            } else {
                $data['image'] = $service->image;
            }

            $service->update($data);

            return redirect()->back()->with('success', 'Service updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the service.');
        }
    }

    public function destroy(Service $service)
    {
        try {
            // Delete image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $service->delete();
            return redirect()->back()->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the service.');
        }
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:services,id',
                'items.*.order' => 'required|integer'
            ]);

            foreach ($request->items as $item) {
                Service::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            return response()->json(['message' => 'Order updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order'], 500);
        }
    }
}
