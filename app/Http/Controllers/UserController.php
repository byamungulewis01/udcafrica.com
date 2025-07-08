<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::whereNot('role', 'super_admin')->orderByDesc('id')->get()->append('role_label');

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }
    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|min:10|max:20|unique:users',
                'role' => 'required|string',
            ]);
            $request->merge([
                'password' => bcrypt('password'), // Auto-generate a password
                'status' => 'active', // Default status
            ]);


            // Create user with auto-generated password
            User::create($request->all());

            return redirect()->back()->with('success', 'User created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // This will automatically handle validation errors and return them to the form
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
                'role' => 'required|string',
                'status' => 'required|in:active,inactive',
            ]);

            $user->update($request->all());

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the user.');
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->id === Auth::user()->id) {
                return redirect()->back()->with('error', 'You cannot delete your own account.');
            }

            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with(['error' => 'Failed to delete user: User has related data.']);
            }
            return redirect()->back()->with('error', 'An error occurred while deleting the user.');
        }
    }

}
