<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = User::withCount('orders');

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Apply filter
        if ($filter === 'admin') {
            $query->where('role', User::ROLE_ADMIN);
        } elseif ($filter === 'user') {
            $query->where('role', User::ROLE_MEMBER);
        } elseif ($filter === 'with_orders') {
            $query->has('orders');
        } elseif ($filter === 'without_orders') {
            $query->doesntHave('orders');
        }

        $users = $query->latest()->paginate(20);

        $counts = [
            'all' => User::count(),
            'admin' => User::where('role', User::ROLE_ADMIN)->count(),
            'user' => User::where('role', User::ROLE_MEMBER)->count(),
            'with_orders' => User::has('orders')->count(),
            'without_orders' => User::doesntHave('orders')->count()
        ];

        return view('admin.users.index', compact('users', 'filter', 'counts'));
    }

    public function show(User $user)
    {
        $user->load(['orders.items', 'contacts']);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'role_label' => $user->role_label,
                'initials' => strtoupper(substr($user->name, 0, 2)),
                'joined_date' => $user->created_at->format('M d, Y'),
                'orders_count' => $user->orders->count(),
                'contacts_count' => $user->contacts->count(),
                'total_spent' => $user->orders->sum('total_price'),
                'total_spent_formatted' => 'Rp ' . number_format($user->orders->sum('total_price'), 0, ',', '.'),
                'orders' => $user->orders->map(function($order) {
                    return [
                        'order_number' => $order->order_number,
                        'date' => $order->created_at->format('M d, Y'),
                        'status' => $order->status,
                        'status_label' => $order->status_label,
                        'status_color' => $order->status_color,
                        'items_count' => $order->items->count(),
                        'total' => $order->total_price,
                        'total_formatted' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                    ];
                })->toArray(),
                'contacts' => $user->contacts->map(function($contact) {
                    return [
                        'date' => $contact->created_at->format('M d, Y'),
                        'message' => \Str::limit($contact->message, 100)
                    ];
                })->toArray()
            ]
        ]);
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:admin,member',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}