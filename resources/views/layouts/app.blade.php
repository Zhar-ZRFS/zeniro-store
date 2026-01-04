<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zeniro Website')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Montserrat:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white font-sans text-primary-primaryBlue flex flex-col min-h-screen">

    <nav x-data="{
        visible: true,
        mobileMenuOpen: false, // <-- WAJIB ADA DI SINI
        searchOpen: false,
        serviceDropdownOpen: false,
        mobileServiceDropdownOpen: false,
        timer: null,
        handleScroll() {
            this.visible = true;
            clearTimeout(this.timer);
            if (window.scrollY > 50) {
                this.timer = setTimeout(() => {
                    this.visible = false;
                }, 5000); 
            }
        }
    }" @scroll.window="handleScroll()" :class="visible ? 'translate-y-0' : '-translate-y-full'"
        class="fixed top-0 left-0 w-full z-50 transition-transform duration-500 ease-in-out bg-secondary shadow-md">

        <div class="container mx-auto px-12 h-20 flex justify-between items-center">

            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-30 h-10 flex items-center">
                    <img src="{{ asset('img/logo/ZeniroBlueBlack.png') }}" alt="ZENIRO" class="h-full object-contain">
                </div>
            </a>

            <div class="hidden md:flex space-x-10">
                <a href="{{ route('home') }}"
                    class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition">Home</a>
                <a href="{{ route('home') }}#layanan"
                    class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition">Layanan</a>
                <a href="{{ route('home') }}#katalog"
                    class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition">Furniture</a>
                
                <!-- Service Dropdown -->
                @auth
                <div class="relative group">
                    <button @click="serviceDropdownOpen = !serviceDropdownOpen"
                        class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition flex items-center gap-1">
                        Store
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                        class="w-4 h-4 transition-transform"
                        :class="serviceDropdownOpen ? '' : 'rotate-180'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="serviceDropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        @click.away="serviceDropdownOpen = false"
                        class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-2">
                        <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm font-semibold text-primary-primaryBlue hover:bg-gray-50 font-heading  hover:text-accent-blue">My Cart</a>
                        <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm font-semibold text-primary-primaryBlue hover:bg-gray-50 font-heading  hover:text-accent-blue">E Commerce</a>
                        <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-sm font-semibold text-primary-primaryBlue hover:bg-gray-50 font-heading  hover:text-accent-blue">History</a>
                    </div>
                </div>
                @else
                <div class="relative group">
                    <button @click="serviceDropdownOpen = !serviceDropdownOpen"
                        class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition flex items-center gap-1">
                        Store
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                        class="w-4 h-4 transition-transform"
                        :class="serviceDropdownOpen ? '' : 'rotate-180'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="serviceDropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        @click.away="serviceDropdownOpen = false"
                        class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 py-2">
                        <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm font-semibold text-primary-primaryBlue hover:bg-gray-50 font-heading  hover:text-accent-blue">E Commerce</a>
                        <a href="{{ route('track.order') }}" class="block px-4 py-2 text-sm font-semibold text-primary-primaryBlue hover:bg-gray-50 font-heading  hover:text-accent-blue">Track Order</a>
                    </div>
                </div>
                @endauth
                
                <a href="{{ route('home') }}#kontak"
                    class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition">Contact
                    Us</a>
            </div>

            <div class="flex items-center gap-4" x-data="{ searchOpen: false }">

                @if(request()->routeIs('products.index'))
                    <form action="{{ route('products.index') }}" method="GET" 
                        class="flex items-center rounded-full transition-all duration-300 ease-in-out overflow-hidden bg-transparent"
                        :class="searchOpen ? 'w-40 px-2 border border-primary-primaryBlue' : 'w-10.5 justify-center px-0 border-transparent'"
                        @click.away="searchOpen = false">

                        <button type="button" @click="searchOpen = !searchOpen"
                            class="w-8 h-8 flex items-center justify-center text-primary-primaryBlue focus:outline-none shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search..."
                            class="w-full border-none outline-none bg-transparent text-sm text-primary-primaryBlue ml-2 font-heading font-medium placeholder-primary-primaryBlue/50 h-9"
                            x-show="searchOpen" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" 
                            x-transition:enter-end="opacity-100 scale-100"
                        >
                    </form>
                @endif


                @auth
                    <div class="flex items-center gap-4">
                        <div class="relative"> <x-profile-dropdown :user="auth()->user()" />
                        
                        @if(isset($cartCount) && $cartCount > 0)
                        <span
                        class="absolute -top-2 -right-1 bg-red-400 text-white text-[8px] font-bold rounded-full w-3 h-3 flex items-center justify-center border-1 border-white pointer-events-none">
                        </span>
                        @endif
                    </div>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-6 py-2 bg-accent-blue text-white rounded-lg font-bold hover:bg-accent-blue/90 transition text-sm">
                                Go to Dashboard
                            </a>
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="w-20 h-10 flex items-center justify-center rounded-lg font-bold transition-all duration-300 border-2 border-primary-primaryBlue bg-primary-primaryBlue text-white hover:bg-transparent hover:text-primary-primaryBlue text-sm">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="w-20 h-10 flex items-center justify-center rounded-lg font-bold transition-all duration-300 border-2 border-primary-primaryBlue bg-transparent text-primary-primaryBlue hover:bg-primary-primaryBlue hover:text-white text-sm">
                            Sign Up
                        </a>
                    </div>
                @endauth

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-primary-primaryBlue focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div x-show="mobileMenuOpen" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="lg:hidden absolute top-full left-0 w-full bg-secondary shadow-inner border-t border-gray-100 px-6 py-4 space-y-4"
                    x-cloak>
                    
                    <a href="{{ route('home') }}" class="block font-heading font-bold text-primary-primaryBlue py-2">Home</a>
                    <a href="{{ route('home') }}#layanan" class="block font-heading font-bold text-primary-primaryBlue py-2">Layanan</a>
                    <a href="{{ route('home') }}#katalog" class="block font-heading font-bold text-primary-primaryBlue py-2">Furniture</a>
                    
                    <!-- Mobile Service Dropdown -->
                    @auth
                <div class="relative group">
                    <button @click="serviceDropdownOpen = !serviceDropdownOpen"
                        class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition flex items-center gap-1">
                        Store
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                        class="w-4 h-4 transition-transform"
                        :class="serviceDropdownOpen ? '' : 'rotate-180'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="serviceDropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="w-full bg-secondary rounded-lg mt-1 py-1"> 
                        <a href="{{ route('cart.index') }}" 
                        class="block px-4 pl-8 py-2 text-sm font-semibold text-primary-primaryBlue hover:text-primary-primaryBlue/70 font-heading transition">
                        My Cart
                        </a>

                        <a href="{{ route('products.index') }}" 
                        class="block px-4 pl-8 py-2 text-sm font-semibold text-primary-primaryBlue hover:text-primary-primaryBlue/70 font-heading transition">
                        E Commerce
                        </a>

                        <a href="{{ route('orders.history') }}" 
                        class="block px-4 pl-8 py-2 text-sm font-semibold text-primary-primaryBlue hover:text-primary-primaryBlue/70 font-heading transition">
                        History
                        </a>
                    </div>
                </div>
                @else
                   
                     <div class="relative group">
                    <button @click="serviceDropdownOpen = !serviceDropdownOpen"
                        class="font-heading font-bold text-primary-primaryBlue hover:text-accent-blue transition flex items-center gap-1">
                        Store
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                        class="w-4 h-4 transition-transform"
                        :class="serviceDropdownOpen ? '' : 'rotate-180'">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="serviceDropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="w-full text-secondary rounded-lg mt-1 py-1"> 
                        <a href="{{ route('products.index') }}" 
                        class="block px-4 pl-8 py-2 text-sm font-semibold text-primary-primaryBlue hover:text-primary-primaryBlue/70 font-heading transition">
                        E Commerce
                        </a>

                        <a href="{{ route('track.order') }}" 
                        class="block px-4 pl-8 py-2 text-sm font-semibold text-primary-primaryBlue hover:text-primary-primaryBlue/70  font-heading transition">
                        Track Order
                        </a>
                    </div>
                </div>
                @endauth
                    
                    <a href="{{ route('home') }}#kontak" class="block font-heading font-bold text-primary-primaryBlue py-2">Contact Us</a>

                </div>

            </div>
        </div>
    </nav>

    <main class="grow pt-20">
        @yield('content')
    </main>

    <footer class="bg-accent-bluesoft text-white pt-16 pb-8">
        <div class="container mx-auto px-12">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-y-8 md:gap-x-4 mb-16">

                <div class="md:col-span-4 flex flex-col justify-start">
                    <div class="mb-4 w-62.5 h-12.5">
                        <img src="{{ asset('img/logo/zeniroBlueBlack.png') }}" alt="ZENIRO"
                            class="w-full object-contain">
                    </div>
                    <p class="font-bold text-lg mb-2">Where Simplicity Meets Warmth</p>
                    <p class="text-sm leading-relaxed opacity-90 max-w-xs">
                        Jl. Bahagia Selamanya Blok. G Kec. Cicilan Bandung Utara, Jawa Barat, Indonesia. Kode Pos 9475
                    </p>
                </div>

                <div class="md:col-span-3 md:col-start-7">
                    <p class="text-base leading-relaxed font-medium opacity-90 text-justify w-60">
                        <span class="font-bold">ZENIRO</span> mempersembahkan keindahan minimalisme personal, menyelaraskan desain fungsional dan ketenangan yang nyaman bagi ruang hunian Anda.
                    </p>
                </div>

                <div class="md:col-span-3 md:col-start-10 flex gap-12">

                    <div>
                        <h3 class="font-heading font-bold text-lg mb-4 w-25">About Us</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('home') }}" class="hover:underline opacity-90">Home</a></li>
                            <li><a href="{{ route('home') }}#layanan" class="hover:underline opacity-90">Layanan</a></li>
                            <li><a href="{{ route('home') }}#katalog" class="hover:underline opacity-90">Furniture</a></li>
                            <li><a href="{{ route('home') }}#kontak" class="hover:underline opacity-90">Contact Us</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-heading font-bold text-lg mb-4 w-20">Store</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('cart.index') }}" class="hover:underline opacity-90">My Cart</a></li>
                            <li><a href="{{route('products.index')}}" class="hover:underline opacity-90">E Commerce</a></li>
                            <li><a href="{{ route('orders.history') }}" class="hover:underline opacity-90">History</a></li>
                            <li><a href="{{ route('track.order') }}" class="hover:underline opacity-90">Track Order</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="border-t border-white/30 pt-8 flex flex-col md:flex-row justify-between items-center">

                <div class="text-sm opacity-80 mb-4 md:mb-0">
                    Copyright @ZRFS 2025
                </div>

                <div class="flex space-x-5 items-center">
                    <a href="#" class="hover:opacity-75 transition transform hover:scale-110">
                        <img src="{{ asset('img/icons/instagram.png') }}" alt="IG" class="w-5 h-5 object-contain">
                    </a>
                    <a href="#" class="hover:opacity-75 transition transform hover:scale-110">
                        <img src="{{ asset('img/icons/x.png') }}" alt="X" class="w-5 h-5 object-contain">
                    </a>
                    <a href="#" class="hover:opacity-75 transition transform hover:scale-110">
                        <img src="{{ asset('img/icons/youtube.png') }}" alt="YT" class="w-5 h-5 object-contain">
                    </a>
                    <a href="#" class="hover:opacity-75 transition transform hover:scale-110">
                        <img src="{{ asset('img/icons/mail.png') }}" alt="Mail" class="w-5 h-5 object-contain">
                    </a>
                </div>

            </div>
        </div>
    </footer>

</body>

</html>