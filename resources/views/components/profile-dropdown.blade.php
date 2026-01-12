@props(['user'])

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <!-- Profile Icon Button -->
    <button @click="open = !open" class="focus:outline-none hover:opacity-80 transition">
        <img src="{{ asset('img/icons/profile-icon.png') }}" alt="Profile" class="h-6 w-6 object-cover">
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50"
        style="display: none;">

        <!-- User Info Section -->
       <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 font-heading truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 mt-1 font-sans truncate">{{ $user->email }}</p>
                </div>
                <a href="{{ route('user.profile') }}" 
                   class="flex-shrink-0 p-1.5 text-accent-blue hover:bg-accent-blue/10 rounded-lg transition" 
                   title="Edit Profile">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="border-t border-gray-200 pt-1">
            <form action="{{ route('orders.history') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm text-primary-primaryBlue hover:bg-red-50 transition">
                    <img src="{{ asset('img/icons/History-icon.png') }}" alt="Cart" class=" w-4 h-4 mr-3 object-contain">
                    History
                </button>
            </form>
            <form action="{{ route('cart.index') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm text-primary-primaryBlue hover:bg-red-50 transition">
                    <div class="relative inline-block mr-3">
                        <img src="{{ asset('img/icons/cart-icon.png') }}" alt="Cart" class="w-4 h-4 object-contain">
                        @php
                            if (Auth::check()) {
                                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                            } else {
                                $guestCart = Session::get('guest_cart', []);
                                $cartCount = array_sum($guestCart);
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-400 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">
                                {{ $cartCount > 9 ? '9+' : $cartCount }}
                            </span>
                        @endif
                    </div>
                    Cart
                </button>
            </form>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>