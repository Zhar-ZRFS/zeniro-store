<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class CartController extends Controller
{
    // Get atau Create Cart Session ID untuk guest
    private function getCartSessionId()
    {
        if (!Session::has('cart_session_id')) {
            Session::put('cart_session_id', 'cart_' . uniqid() . '_' . time());
        }
        return Session::get('cart_session_id');
    }

    // Get Cart Items dari Session (Guest) atau Database (User Login)
    private function getCartItems()
    {
        if (Auth::check()) {
            // User sudah login - ambil dari database
            return Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            // Guest user - ambil dari session
            $sessionCarts = Session::get('guest_cart', []);
            $cartItems = collect();

            foreach ($sessionCarts as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems->push((object) [
                        'id' => 'guest_' . $productId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'product' => $product,
                        'price' => $product->price,
                        'subtotal' => $product->price * $quantity
                    ]);
                }
            }

            return $cartItems;
        }
    }

    // Halaman Cart & Checkout
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum('subtotal');
        $discount = $this->calculateDiscount($subtotal);
        $total = $subtotal - $discount;

        return view('cart.index', compact('cartItems', 'subtotal', 'discount', 'total'));
    }

    // Tambah ke Cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Cek stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stock tidak mencukupi!');
        }

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cart) {
                // FIX TYPO: Dari quntity ke quantity
                $newQuantity = $cart->quantity + $quantity;
                if ($product->stock < $newQuantity) {
                    return redirect()->back()->with('error', 'Stock tidak mencukupi!');
                }
                $cart->update(['quantity' => $newQuantity]);
            } else {
                // FIX: Definisikan price dan benerin nama kolom quantity
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price, // AMBIL DARI $product
                ]);
            }
        } else {
            // Logika Guest (Session) - Sudah bener tapi mastiin key-nya konsisten
            $guestCart = Session::get('guest_cart', []);

            if (isset($guestCart[$product->id])) {
                $newQuantity = $guestCart[$product->id] + $quantity;
                if ($product->stock < $newQuantity) {
                    return redirect()->back()->with('error', 'Stock tidak mencukupi!');
                }
                $guestCart[$product->id] = $newQuantity;
            } else {
                $guestCart[$product->id] = $quantity;
            }

            Session::put('guest_cart', $guestCart);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke cart!');
    }

    // Update Quantity
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            // User login - update database
            $cart = Cart::findOrFail($id);

            if ($cart->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if ($cart->product->stock < $request->quantity) {
                return response()->json(['error' => 'Stock tidak mencukupi'], 400);
            }

            $cart->update(['quantity' => $request->quantity]);
        } else {
            // Guest user - update session
            $productId = str_replace('guest_', '', $id);
            $guestCart = Session::get('guest_cart', []);

            if (!isset($guestCart[$productId])) {
                return response()->json(['error' => 'Item tidak ditemukan'], 404);
            }

            $product = Product::find($productId);
            if ($product->stock < $request->quantity) {
                return response()->json(['error' => 'Stock tidak mencukupi'], 400);
            }

            $guestCart[$productId] = $request->quantity;
            Session::put('guest_cart', $guestCart);
        }

        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum('subtotal');
        $discount = $this->calculateDiscount($subtotal);
        $total = $subtotal - $discount;

        return response()->json([
            'success' => true,
            'totalSubtotal' => number_format($subtotal, 0, ',', '.'),
            'discount' => number_format($discount, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    // Hapus dari Cart
    public function remove($id)
    {
        if (Auth::check()) {
            // User login - hapus dari database
            $cart = Cart::findOrFail($id);

            if ($cart->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized');
            }

            $cart->delete();
        } else {
            // Guest user - hapus dari session
            $productId = str_replace('guest_', '', $id);
            $guestCart = Session::get('guest_cart', []);

            if (isset($guestCart[$productId])) {
                unset($guestCart[$productId]);
                Session::put('guest_cart', $guestCart);
            }
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari cart!');
    }

    // Delete Selected Items
    public function deleteSelected(Request $request)
    {
        // $request->validate([
        //     'cart_ids' => 'required|array',
        // ]);

        if (!$request->has('cart_ids') || empty($request->cart_ids)) {
        return redirect()->back()->with('error', 'Lo mau hapus apa sebenernya? Harapan lo?');
        }

        if (Auth::check()) {
            // User login - hapus dari database
            Cart::whereIn('id', $request->cart_ids)
                ->where('user_id', Auth::id())
                ->delete();
        } else {
            // Guest user - hapus dari session
            $guestCart = Session::get('guest_cart', []);

            foreach ($request->cart_ids as $cartId) {
                $productId = str_replace('guest_', '', $cartId);
                if (isset($guestCart[$productId])) {
                    unset($guestCart[$productId]);
                }
            }

            Session::put('guest_cart', $guestCart);
        }

        return redirect()->back()->with('success', 'Item yang kamu pilih udah dihapus... jadi beli apa?');
    }

    // Checkout Process
    public function checkout(Request $request)
    {
        $rules = [
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500'
        ];

        $selectedIds = json_decode($request->selected_cart_ids, true);

        if (empty($selectedIds)) {
        return redirect()->back()->with('error', 'Hah! Kosong? Apa yang mau kamu beli?');
        }

        // Jika guest, full_name dan email wajib diisi
        if (!Auth::check()) {
            $rules['full_name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules, [
            'full_name.required' => 'Jangan sok ngartis! isi deh nama lo!',
            'email.required' => 'Email lo kosong, gimana gue konfirmasi?',
            'email.email' => 'Format email lo ngaco, pantesan gak pernah dapet promo',
            'phone.required' => "Lo takut mantanlo hubungi lo lagi?",
            'address.required' => 'Orderan Lo Fiktifkah? >:(, kirim alamat yang bener:/'
        ]);

        // Get all cart items
        $allCartItems = $this->getCartItems();

        // Filter selected items jika ada selected_cart_ids
        $cartItems = $allCartItems;
        if ($request->has('selected_cart_ids') && !empty($request->selected_cart_ids)) {
            try {
                $selectedIds = json_decode($request->selected_cart_ids, true);
                
                if (is_array($selectedIds) && !empty($selectedIds)) {
                    // Filter cart items berdasarkan selected IDs
                    $cartItems = $allCartItems->filter(function ($item) use ($selectedIds) {
                        return in_array((string)$item->id, $selectedIds);
                    });
                }
            } catch (\Exception $e) {
                // Jika parsing selected_cart_ids gagal, gunakan semua items
                $cartItems = $allCartItems;
            }
        }

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Pilih item yang ingin dibeli!');
        }

        // Calculate totals untuk selected items saja
        $subtotal = $cartItems->sum('subtotal');
        $discount = $this->calculateDiscount($subtotal);
        $total = $subtotal - $discount;

        DB::beginTransaction();

        try {
            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ZEN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
                'total_price' => $total,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'status' => Order::STATUS_PENDING,
                'full_name' => Auth::check() ? Auth::user()->name : $validated['full_name'],
                'email' => Auth::check() ? Auth::user()->email : $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address']
            ]);

            // Create Order Address
            OrderAddress::create([
                'order_id' => $order->id,
                'full_name' => Auth::check() ? Auth::user()->name : $validated['full_name'],
                'email' => Auth::check() ? Auth::user()->email : $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address']
            ]);

            // Create Order Items untuk selected items saja
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // Kurangi stock
                $product = Product::find($cartItem->product_id);
                $product->decrement('stock', $cartItem->quantity);
            }

            // Delete HANYA selected cart items, bukan semua
            if (Auth::check()) {
                // Jika ada selected items, hapus hanya yang dipilih
                if ($request->has('selected_cart_ids') && !empty($request->selected_cart_ids)) {
                    try {
                        $selectedIds = json_decode($request->selected_cart_ids, true);
                        if (is_array($selectedIds)) {
                            Cart::where('user_id', Auth::id())
                                ->whereIn('id', $selectedIds)
                                ->delete();
                        }
                    } catch (\Exception $e) {
                        // Jika gagal parsing, hapus semua
                        Cart::where('user_id', Auth::id())->delete();
                    }
                } else {
                    // Jika tidak ada selected items, hapus semua (backward compatibility)
                    Cart::where('user_id', Auth::id())->delete();
                }
            } else {
                // Guest user - hapus dari session
                if ($request->has('selected_cart_ids') && !empty($request->selected_cart_ids)) {
                    try {
                        $selectedIds = json_decode($request->selected_cart_ids, true);
                        $guestCart = Session::get('guest_cart', []);
                        
                        foreach ($selectedIds as $cartId) {
                            $productId = str_replace('guest_', '', $cartId);
                            if (isset($guestCart[$productId])) {
                                unset($guestCart[$productId]);
                            }
                        }
                        
                        Session::put('guest_cart', $guestCart);
                    } catch (\Exception $e) {
                        Session::forget('guest_cart');
                    }
                } else {
                    // Jika tidak ada selected items, hapus semua
                    Session::forget('guest_cart');
                }
                
                Session::forget('cart_session_id');
            }

            DB::commit();

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Calculate Discount
    private function calculateDiscount($subtotal)
    {
        if($subtotal > 2000000){
            return $subtotal * 0.15;
        }else if ($subtotal > 1000000) {
            return $subtotal * 0.10;
        } else if ($subtotal >100000) {
            return $subtotal * 0.01;
        }
        return 0;
    }

    // Order Success Page
    public function orderSuccess($orderId)
    {
        $order = Order::with(['items.product', 'address'])->findOrFail($orderId);

        // Cek kepemilikan order (untuk user login)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cart.success', compact('order'));
    }

    // Migrate guest cart to user cart after login
    public function migrateGuestCart()
    {
        if (Auth::check() && Session::has('guest_cart')) {
            $guestCart = Session::get('guest_cart', []);

            foreach ($guestCart as $productId => $quantity) {
                $product = Product::find($productId);
                if (!$product)
                    continue;

                $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if ($cart) {
                    $cart->increment('quantity', $quantity);
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price // WAJIB ADA BIAR GAK ERROR LAGI
                    ]);
                }
            }

            Session::forget('guest_cart');
            Session::forget('cart_session_id');
        }
    }

    public function downloadReceipt($order_number)
    {
        // Ambil data lengkap sama relasi yang udah kita rapihin tadi
        $order = Order::with(['address', 'items'])->where('order_number', $order_number)->firstOrFail();

        // Load view khusus buat struk
        $pdf = Pdf::loadView('orders.receipt_pdf', compact('order'));

        // Download filenya
        return $pdf->download('Receipt-' . $order->order_number . '.pdf');
    }
}