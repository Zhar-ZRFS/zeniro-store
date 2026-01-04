<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    // Halaman History Orders
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        // Get orders untuk user yang sedang login
        // Jika tidak login, return empty atau redirect
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login untuk melihat history order');
        }

        $orders = Order::with(['items.product', 'address'])
            ->forUser(Auth::id())
            ->byStatus($status)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statuses = Order::getStatuses();

        return view('orders.history', compact('orders', 'statuses', 'status'));
    }

    // Get Order Detail (AJAX)
    public function getDetail($id)
    {
        $order = Order::with(['items.product.categories', 'address', 'user'])
            ->findOrFail($id);

        // Cek authorization
        if (Auth::check() && $order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'created_at' => $order->created_at->format('F d, Y'),
                'status' => $order->status,
                'status_label' => $order->status_label,
                'status_color' => $order->status_color,
                'total_price' => $order->total_price,
                'total_price_formatted' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                'total_discount_formatted' => 'Rp ' . number_format($order->discount, 0, ',', '.'),
                'total_subtotal_formatted' => 'Rp ' . number_format($order->subtotal, 0, ',', '.'),
                'address' => [
                    'full_name' => $order->address->full_name,
                    'email' => $order->address->email,
                    'phone' => $order->address->phone,
                    'address' => $order->address->address,
                ],
                'items' => $order->items->map(function ($item) {
                    $categoryName = $item->product && $item->product->categories->isNotEmpty()
                        ? $item->product->categories->first()->name
                        : 'Uncategorized';

                    return [
                        'product_name' => $item->product ? $item->product->name : 'Product Deleted',
                        'category_name' => $categoryName,
                        'product_image' => $item->product && $item->product->image
                            ? (filter_var($item->product->image, FILTER_VALIDATE_URL)
                                ? $item->product->image
                                : asset('storage/' . $item->product->image))
                            : null,
                        'price' => $item->price,
                        'price_formatted' => 'Rp ' . number_format($item->price, 0, ',', '.'),
                        'qty' => $item->quantity,
                        'subtotal' => $item->subtotal,
                        'subtotal_formatted' => 'Rp ' . number_format($item->subtotal, 0, ',', '.'),
                    ];
                })->toArray()
            ]
        ]);
    }
}