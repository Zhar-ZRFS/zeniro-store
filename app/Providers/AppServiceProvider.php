<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $count = Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                $guestCart = Session::get('guest_cart', []);
                $count = array_sum($guestCart);
            }
            $view->with('cartCount', $count); // Sekarang variabel $cartCount bisa dipake di mana aja!
        });
    }
}
