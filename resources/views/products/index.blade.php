@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">

        <!-- Hero Carousel Section -->
        <div class="relative overflow-hidden" style="height: 550px;">
            <!-- Carousel Container -->
            <div class="carousel-container relative h-full" x-data="{ activeSlide: 0, slides: 3 }"
                x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slides }, 5000)">

                <!-- Slide 1 -->
                <div x-show="activeSlide === 0" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                    class="absolute inset-0 flex items-center justify-center bg-cover bg-center"
                    style="background-image: url('https://picsum.photos/1920/400?random=1');">
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="relative text-center text-white px-4 max-w-4xl z-10">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 font-heading">
                            Temukan Inspirasimu Disini
                        </h1>
                        <p class="text-base md:text-l opacity-90 font-sans">
                            ZENIRO mempersembahkan Personal Minimalism, menyeratakan desain fungsional dan Zen yang hangat
                            untuk menata ketanangan di ruang pribadi Anda
                        </p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div x-show="activeSlide === 1" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                    class="absolute inset-0 flex items-center justify-center bg-cover bg-center"
                    style="background-image: url('https://picsum.photos/1920/400?random=2');">
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="relative text-center text-white px-4 max-w-4xl z-10">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 font-heading">
                            Koleksi Terbaru 2026
                        </h1>
                        <p class="text-base md:text-l opacity-90 font-sans">
                            Desain minimalis yang menenangkan untuk ruang pribadi Anda
                        </p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div x-show="activeSlide === 2" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                    class="absolute inset-0 flex items-center justify-center bg-cover bg-center"
                    style="background-image: url('https://picsum.photos/1920/400?random=3');">
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="relative text-center text-white px-4 max-w-4xl z-10">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 font-heading">
                            Kualitas Terbaik
                        </h1>
                        <p class="text-base md:text-l opacity-90 font-sans">
                            Produk berkualitas tinggi dengan harga terjangkau untuk semua kalangan
                        </p>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-2">
                    <template x-for="i in slides" :key="i">
                        <button @click="activeSlide = i - 1"
                            :class="activeSlide === i - 1 ? 'bg-white w-8' : 'bg-white/50 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-2 rounded-full font-bold whitespace-nowrap transition-all font-sans {{ !$selectedCategory ? 'bg-primary-primaryPink text-white' : 'bg-accent-pink text-gray-700 hover:bg-pink-300' }}">
                        Semua Produk
                    </a>
                    @foreach($categories as $category)  
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="px-6 py-2 rounded-full font-bold whitespace-nowrap transition-all font-sans {{ $selectedCategory === $category->slug ? 'bg-primary-primaryPink text-white' : 'bg-accent-pink text-gray-700 hover:bg-pink-300' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            @if($selectedCategory)
                @php
                    $categoryName = \App\Models\Category::where('slug', $selectedCategory)->first();
                @endphp
                <h2 class="text-2xl font-bold mb-8 font-heading text-primary-primaryBlue" >
                    Inspirasi untuk {{ $categoryName ? $categoryName->name : ucfirst(str_replace('-', ' ', $selectedCategory)) }} anda
                </h2>
            @else
                <h2 class="text-3xl font-bold mb-8 font-heading text-primary-primaryBlue">
                    Semua Produk
                </h2>
            @endif

            <!-- Success/Error Messages
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif -->

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @forelse($products as $product)
                    <div
                        class="bg-gradient-to-br to-accent-bluesoft from-blue-300 rounded-3xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Product Image -->
                        <div class="rounded-xl mb-4 overflow-hidden"
                            style="height: 200px;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300">
                                    <span class="text-white text-4xl font-bold">{{ substr($product->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="mb-4">
                            <h3 class="font-bold text-lg mb-1 font-heading text-primary-primaryBlue">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-2 font-sans">
                                {{ $product->description }}
                            </p>
                            <p class="font-bold text-lg" style="color: #2d3748;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1 font-sans">
                                Stock: {{ $product->stock }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button onclick="showProductDetail({{ $product->id }})"
                                class="flex-1 bg-white text-gray-800 py-2 rounded-full font-bold hover:bg-gray-100 transition text-sm font-sans">
                                Detail
                            </button>
                            <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}
                                    class="w-10 h-10 bg-accent-blue text-white rounded-full hover:bg-accent-blue/85 transition flex items-center justify-center {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg font-sans">
                            Tidak ada produk yang ditemukan
                        </p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block mt-4 bg-pink-400 text-white px-6 py-2 rounded-full hover:bg-pink-500 transition">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="flex justify-center items-center gap-2">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed font-bold">&lt;</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}"
                            class="px-3 py-2 text-gray-700 hover:text-pink-500 font-bold">&lt;</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = max($products->currentPage() - 2, 1);
                        $end = min($start + 4, $products->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $products->url(1) }}"
                            class="px-4 py-2 text-gray-700 hover:bg-pink-200 rounded-full transition">1</a>
                        @if($start > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $products->currentPage())
                            <span class="px-4 py-2 bg-pink-400 text-white rounded-full font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $products->url($page) }}"
                                class="px-4 py-2 text-gray-700 hover:bg-pink-200 rounded-full transition">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($end < $products->lastPage())
                        @if($end < $products->lastPage() - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $products->url($products->lastPage()) }}"
                            class="px-4 py-2 text-gray-700 hover:bg-pink-200 rounded-full transition">{{ $products->lastPage() }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}"
                            class="px-3 py-2 text-gray-700 hover:text-pink-500 font-bold">&gt;</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed font-bold">&gt;</span>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <!-- Product Detail Modal -->
    <div id="productDetailModal"
        class="hidden fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
        onclick="handleModalClick(event)">

        <div class="bg-accent-bluesoft rounded-2xl max-w-sm w-full relative" style="max-height: 90vh; contain: layout style paint;"
            onclick="event.stopPropagation()">

            <!-- Header with Close Button -->
            <div class="bg-accent-blue rounded-t-2xl px-4 py-2.5 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white font-heading">
                    Detail Product
                </h2>
                <button onclick="closeProductDetail()" class="text-white hover:text-white/30 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div id="productDetailContent" class="p-5 overflow-y-auto will-change-contents" style="max-height: calc(90vh - 50px);">
            </div>
        </div>
    </div>

    <script>
        let currentQuantity = 1;
        let currentProduct = null;
        let productsCache = {};

        // Pre-load all products data
        @foreach($products as $product)
            productsCache[{{ $product->id }}] = {
                id: {{ $product->id }},
                name: '{{ addslashes($product->name) }}',
                slug: '{{ $product->slug }}',
                description: '{{ addslashes($product->description) }}',
                price: {{ $product->price }},
                price_formatted: 'Rp {{ number_format($product->price, 0, ',', '.') }}',
                stock: {{ $product->stock }},
                image: '{{ $product->image ? asset('storage/' . $product->image) : '' }}',
            };
        @endforeach

        function showProductDetail(productId) {
            const modal = document.getElementById('productDetailModal');
            
            // Show modal immediately
            modal.classList.remove('hidden');

            // Get product from cache
            const product = productsCache[productId];
            if (product) {
                currentProduct = product;
                currentQuantity = 1;
                renderProductDetail(product);
            }
        }

        function renderProductDetail(product) {
            const content = document.getElementById('productDetailContent');
            const imageHtml = product.image 
                ? `<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">`
                : `<div class="w-full h-full flex items-center justify-center bg-gray-300">
                    <span class="text-white text-4xl font-bold">${product.name.charAt(0)}</span>
                   </div>`;

            content.innerHTML = `
                <div class="grid grid-cols-1 gap-4">
                    <div class="rounded-2xl overflow-hidden" style="height: 220px;">
                        ${imageHtml}
                    </div>
                    <div class="flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-1 font-heading text-primary-primaryBlue">
                                ${product.name}
                            </h3>
                            <p class="text-sm text-gray-700 mb-2 font-sans" >
                                ${product.description}
                            </p>
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 font-sans" >
                                    Qty : <span class="font-bold">${product.stock}</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2 mb-3">
                                <button onclick="decrementQuantity()" 
                                        class="w-7 h-7 bg-accent-blue text-white rounded-l-lg font-bold hover:bg-accent-blue/75 transition flex items-center justify-center text-sm">
                                    −
                                </button>
                                <span id="quantityDisplay" class="text-sm font-bold w-7 text-center">${currentQuantity}</span>
                                <button onclick="incrementQuantity(${product.stock})" 
                                        class="w-7 h-7 bg-accent-blue text-white rounded-r-lg font-bold hover:bg-accent-blue/15 transition flex items-center justify-center text-sm">
                                    +
                                </button>
                                <div class="flex-1 text-right">
                                    <p class="text-sm font-bold" style="color: #2d3748;">
                                        ${product.price_formatted}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-accent-bluesoft p-2 mb-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold font-sans">Total Harga :</span>
                                    <span id="totalPrice" class="text-lg font-bold" style="color: #2d3748;">
                                        ${product.price_formatted}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="purchaseNow(${product.id})" 
                                    ${product.stock < 1 ? 'disabled' : ''}
                                    class="flex-1 bg-white text-gray-700 py-2 rounded-lg font-sans font-bold text-sm hover:bg-white/75 transition ${product.stock < 1 ? 'opacity-50 cursor-not-allowed' : ''}">
                                Purchase
                            </button>
                            <button onclick="addToCartFromModal(${product.id})" 
                                    ${product.stock < 1 ? 'disabled' : ''}
                                    class="w-10 h-10 bg-accent-blue text-white rounded-full hover:bg-accent-blue/75 transition flex items-center justify-center ${product.stock < 1 ? 'opacity-50 cursor-not-allowed' : ''}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function incrementQuantity(maxStock) {
            if (currentQuantity < maxStock) {
                currentQuantity++;
                updateQuantityDisplay();
            }
        }

        function decrementQuantity() {
            if (currentQuantity > 1) {
                currentQuantity--;
                updateQuantityDisplay();
            }
        }

        function updateQuantityDisplay() {
            document.getElementById('quantityDisplay').textContent = currentQuantity;

            if (currentProduct) {
                const totalPrice = currentProduct.price * currentQuantity;
                // Format harga dengan simpler method
                const formatted = 'Rp ' + totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                document.getElementById('totalPrice').textContent = formatted;
            }
        }

        function addToCartFromModal(productId) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cart.add") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'product_id';
            productIdInput.value = productId;

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = 'quantity';
            qtyInput.value = currentQuantity;

            form.appendChild(csrfToken);
            form.appendChild(productIdInput);
            form.appendChild(qtyInput);

            document.body.appendChild(form);
            form.submit();
        }

        function purchaseNow(productId) {
            // Add to cart then redirect to cart page
            addToCartFromModal(productId);

            // Redirect after a short delay
            setTimeout(() => {
                window.location.href = '{{ route("cart.index") }}';
            }, 500);
        }

        function closeProductDetail() {
            document.getElementById('productDetailModal').classList.add('hidden');
            currentQuantity = 1;
            currentProduct = null;
        }

        function handleModalClick(event) {
            if (event.target.id === 'productDetailModal') {
                closeProductDetail();
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeProductDetail();
            }
        });
    </script>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection