<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product; // Pastikan ini di-import!
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            $this->migrateGuestCart();

            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Kombinasi email & password salah.']);
    }

    private function migrateGuestCart()
    {
        // 1. Cek apakah session guest_cart ada isinya
        if (Session::has('guest_cart')) {
            $guestCart = Session::get('guest_cart', []);

            foreach ($guestCart as $productId => $quantity) {
                // 2. Cari produk pake ELOQUENT (Bukan DB::table biar gak muncul stdClass)
                $product = Product::find($productId);

                // 3. Lewati kalau produk gak ketemu di DB
                if (!$product)
                    continue;

                // 4. Cek apakah di cart user udah ada produk ini
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    // Kalau ada, update jumlahnya
                    $cartItem->increment('quantity', $quantity);
                } else {
                    // 5. Kalau belum ada, buat baru. 
                    // PASTIIN 'price' di bawah ini nilainya ADA.
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }
            }

            // 6. Bersihin session biar gak ke-merge dua kali
            Session::forget('guest_cart');
            Session::forget('cart_session_id');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Logic Redirect sesuai Role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // User biasa ke home
        return redirect()->intended('/home');
    }
}