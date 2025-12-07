<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::latest()
            ->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        
        return view('admin.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'email_verified_at' => 'nullable|date',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Create the user
        $user = User::create($validated);

        // Assign roles
        $user->roles()->sync($validated['roles']);

        // Send email verification if email_verified_at is not set
        if (empty($validated['email_verified_at'])) {
            $user->sendEmailVerificationNotification();
        } else {
            $user->email_verified_at = $validated['email_verified_at'];
            $user->save();
        }

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::with(['roles', 'events', 'blogPosts', 'comments'])
            ->findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'email_verified_at' => 'nullable|date',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']);
        }

        // Update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update the user
        $user->update($validated);

        // Sync roles
        $user->roles()->sync($validated['roles']);

        // Handle email verification status
        if (!empty($validated['email_verified_at']) && !$user->hasVerifiedEmail()) {
            $user->email_verified_at = $validated['email_verified_at'];
            $user->save();
        } elseif (empty($validated['email_verified_at']) && $user->hasVerifiedEmail()) {
            $user->email_verified_at = null;
            $user->save();
        }

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Prevent deleting the currently authenticated user
        if ($id == auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        $user = User::findOrFail($id);

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete user
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user status (active/inactive).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id)
    {
        // Prevent deactivating the currently authenticated user
        if ($id == auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account.'
            ], 403);
        }

        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'User status updated successfully!'
        ]);
    }

    /**
     * Show user's activity log.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function activity($id)
    {
        $user = User::findOrFail($id);
        $activities = $user->activities()
            ->with('subject')
            ->latest()
            ->paginate(20);

        return view('admin.users.activity', [
            'user' => $user,
            'activities' => $activities,
        ]);
    }
}
