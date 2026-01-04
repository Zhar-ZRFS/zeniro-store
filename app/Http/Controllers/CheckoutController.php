<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // 1. Ambil data keranjang (Asumsi keranjang lo di Session)
        $cart = session()->get('cart', []);

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong! Silahkan pilih barang yang ingin dipesan');
        }

        DB::beginTransaction();
        try {

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 3. Simpan ke tabel Orders
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
            ]);

            // 4. Looping Keranjang buat Simpan Item & Potong Stok
            foreach ($cart as $id => $details) {
                $product = Product::findOrFail($id);

                // Validasi Stok (Brutal Check)
                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Stok {$product->name} nggak cukup!");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                // POTONG STOK OTOMATIS
                $product->decrement('stock', $details['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.success', $order->id);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success($id)
    {
        // Cari order milik user yang lagi login
        $order = Order::with('items.product')->where('user_id', auth()->id())->findOrFail($id);

        return view('checkout.success', compact('order'));
    }
}