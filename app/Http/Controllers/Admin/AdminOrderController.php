<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Order::with(['items.product', 'address', 'user']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10);
        $statuses = Order::getStatuses();

        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'process' => Order::where('status', Order::STATUS_PROCESS)->count(),
            'completed' => Order::where('status', Order::STATUS_COMPLETED)->count(),
            'cancelled' => Order::where('status', Order::STATUS_CANCELLED)->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statuses', 'status', 'statusCounts'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,process,completed,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', 'Status order berhasil diupdate!');
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'address', 'user']);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'created_at' => $order->created_at->format('M d, Y H:i'),
                'status' => $order->status,
                'status_label' => $order->status_label,
                'status_color' => $order->status_color,
                'subtotal' => $order->subtotal,
                'subtotal_formatted' => 'Rp ' . number_format($order->subtotal, 0, ',', '.'),
                'discount' => $order->discount,
                'discount_formatted' => 'Rp ' . number_format($order->discount, 0, ',', '.'),
                'total_price' => $order->total_price,
                'total_formatted' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                'address' => [
                    'full_name' => $order->address->full_name,
                    'email' => $order->address->email,
                    'phone' => $order->address->phone,
                    'address' => $order->address->address,
                ],
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product_name,
                        'product_image' => $item->product && $item->product->image
                            ? (filter_var($item->product->image, FILTER_VALIDATE_URL)
                                ? $item->product->image
                                : asset('storage/' . $item->product->image))
                            : null,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'price_formatted' => 'Rp ' . number_format($item->price, 0, ',', '.'),
                        'subtotal' => $item->subtotal,
                        'subtotal_formatted' => 'Rp ' . number_format($item->subtotal, 0, ',', '.'),
                    ];
                })->toArray()
            ]
        ]);
    }
}