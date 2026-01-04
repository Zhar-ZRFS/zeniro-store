<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    // Halaman Form Track Order
    public function index()
    {
        return view('track-order.index');
    }


    // Search Order by Order Number + Email (AJAX)
    public function search(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        // Cari order berdasarkan order_number dan email di order_address
        $order = Order::with(['items.product.categories', 'address'])
            ->where('order_number', $validated['order_number'])
            ->whereHas('address', function($query) use ($validated) {
                $query->where('email', $validated['email']);
            })
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan. Pastikan Order Number dan Email sudah benar.'
            ], 404);
        }

        // Return data order
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