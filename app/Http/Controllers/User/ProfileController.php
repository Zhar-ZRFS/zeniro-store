<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Profile Dashboard
    public function index()
    {
        $user = Auth::user()->load(['orders.items', 'contacts']);
        
        // Stats
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('total_price'),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'total_messages' => $user->contacts()->count(),
        ];

        // Recent Orders (Latest 5)
        $recentOrders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Messages (Latest 3)
        $recentMessages = $user->contacts()
            ->latest()
            ->take(3)
            ->get();

        return view('user.profile.index', compact('user', 'stats', 'recentOrders', 'recentMessages'));
    }

    // Edit Profile Form
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // Update Profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        // Update password if provided
        if (!empty($validated['new_password'])) {
            // Verify current password
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully!');
    }
}