@extends('layouts.app')

@section('title', 'Order History - Zeniro Store')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Title -->
            <h1 class="text-4xl font-bold mb-8 font-heading" style="color: #305C8E;">
                History
            </h1>

            <!-- Status Filter -->
            <div class="mb-8">
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                    <a href="{{ route('orders.history', ['status' => 'all']) }}"
                        class="px-6 py-2 rounded-full font-bold whitespace-nowrap transition-all font-sans {{ $status === 'all' ? 'bg-pink-400 text-white' : 'bg-pink-200 text-gray-700 hover:bg-pink-300' }}">
                        All
                    </a>
                    @foreach($statuses as $key => $label)
                        <a href="{{ route('orders.history', ['status' => $key]) }}"
                            class="px-6 py-2 rounded-full font-bold whitespace-nowrap transition-all font-sans {{ $status === $key ? 'bg-pink-400 text-white' : 'bg-pink-200 text-gray-700 hover:bg-pink-300' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Orders List -->
            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-blue-100 rounded-3xl p-6 shadow-md">

                        <!-- Order Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <!-- Status Badge -->
                                <div class="px-4 py-2 rounded-full {{ $order->status_color }} font-bold text-sm">
                                    {{ $order->status_label }}
                                </div>

                                <div>
                                    <p class="text-sm text-gray-600 font-sans">
                                        {{ $order->created_at->format('d/m/Y') }} | ID Order : {{ $order->order_number }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-sm text-gray-600 font-sans">Total:</p>
                                <p class="text-lg font-bold" style="color: #2d3748;">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($order->items->take(2) as $item)
                                <div class="flex items-center gap-4">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 bg-blue-600 rounded-xl overflow-hidden flex-shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ filter_var($item->product->image, FILTER_VALIDATE_URL) ? $item->product->image : asset('storage/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-400">
                                                <span class="text-white text-xl font-bold">?</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg font-heading"
                                            style="color: #2d3748;">
                                            {{ $item->product ? $item->product->name : 'Product Deleted' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 font-sans">
                                            Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            @if($order->items->count() > 2)
                                <p class="text-sm text-gray-600 text-center font-sans">
                                    +{{ $order->items->count() - 2 }} produk lainnya
                                </p>
                            @endif
                        </div>

                        <!-- Order Details Button -->

                        <div class="flex justify-end items-center gap-3">
                            <a href="{{ route('order.receipt.download', $order->order_number) }}"
                                class="bg-green-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-green-700 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Struk PDF</span>
                            </a>

                            <button onclick="showOrderDetail({{ $order->id }})"
                                class="bg-blue-600 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-primary-primaryBlue/90 font-sans">
                                Order Details
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center shadow-md">
                        <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg mb-4 font-sans">
                            Belum ada riwayat pesanan
                        </p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block bg-pink-400 text-white px-6 py-3 rounded-full hover:bg-pink-500 transition font-bold">
                            Mulai Belanja
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8 flex justify-center items-center gap-2">
                    @if ($orders->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed font-bold">&lt;</span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}"
                            class="px-3 py-2 text-gray-700 hover:text-pink-500 font-bold">&lt;</a>
                    @endif

                    @php
                        $start = max($orders->currentPage() - 2, 1);
                        $end = min($start + 4, $orders->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $orders->url(1) }}"
                            class="px-4 py-2 text-gray-700 hover:bg-pink-200 rounded-full transition">1</a>
                        @if($start > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $orders->currentPage())
                            <span class="px-4 py-2 bg-pink-400 text-white rounded-full font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $orders->url($page) }}"
                                class="px-4 py-2 text-gray-700 hover:bg-pink-200 rounded-full transition">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($end < $orders->lastPage())
                        @if($end < $orders->lastPage() - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $orders->url($orders->lastPage()) }}"
                            class="px-4 py-2 text-gray-700 hover:bg-pink-200 rounded-full transition">{{ $orders->lastPage() }}</a>
                    @endif

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}"
                            class="px-3 py-2 text-gray-700 hover:text-pink-500 font-bold">&gt;</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 cursor-not-allowed font-bold">&gt;</span>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <!-- Order Detail Modal -->
    <div id="orderDetailModal" class="hidden fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
        onclick="handleModalClick(event)">

        <div class="bg-secondary rounded-2xl max-w-sm w-full relative" style="max-height: 90vh;"
            onclick="event.stopPropagation()">

            <!-- Header -->
            <div class="bg-primary-primaryBlue rounded-t-2xl px-4 py-2.5 flex items-center justify-between">
                <h2 class="text-lg font-bold text-white font-heading">
                    Order Details
                </h2>
                <button onclick="closeOrderDetail()" class="text-white hover:text-gray-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div id="orderDetailContent" class="p-5 overflow-y-auto" style="max-height: calc(90vh - 50px);">
                <!-- Loading State -->
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showOrderDetail(orderId) {
            const modal = document.getElementById('orderDetailModal');
            const content = document.getElementById('orderDetailContent');

            modal.classList.remove('hidden');

            content.innerHTML = `
                        <div class="flex justify-center items-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                        </div>
                    `;

            fetch(`/orders/detail/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderOrderDetail(data.order);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = `
                                <div class="text-center py-12">
                                    <p class="text-red-600">Gagal memuat detail order</p>
                                </div>
                            `;
                });
        }

        function renderOrderDetail(order) {
            const content = document.getElementById('orderDetailContent');

            const itemsHtml = order.items.map(item => `
                        <div class="flex items-center gap-3 bg-white rounded-2xl p-3">
                            <div class="w-16 h-16 bg-blue-600 rounded-lg overflow-hidden flex-shrink-0">
                                ${item.product_image
                    ? `<img src="${item.product_image}" alt="${item.product_name}" class="w-full h-full object-cover">`
                    : `<div class="w-full h-full flex items-center justify-center bg-gray-400">
                                         <span class="text-white text-sm font-bold">?</span>
                                       </div>`
                }
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm font-heading truncate">
                                    ${item.product_name}
                                </h4>
                                <p class="text-xs text-gray-600 font-sans mt-0.5">
                                    ${item.price_formatted} x ${item.qty}
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-bold text-sm" style="color: #2d3748;">
                                    ${item.subtotal_formatted}
                                </p>
                            </div>
                        </div>
                    `).join('');

            content.innerHTML = `
                        <div class="space-y-4">
                            <!-- Order Info -->
                            <div class="bg-white rounded-lg p-4">
                                
                                    <div>
                                        <p class="text-xs text-gray-600 font-sans mb-0.5">Order Number</p>
                                        <p class="font-bold text-sm font-heading text-primary-primaryBlue truncate">
                                            ${order.order_number}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 font-sans">Order Date</p>
                                        <p class="font-bold text-sm font-heading" style="color: #2d3748;">
                                            ${order.created_at}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 mb-1 font-sans">Status</p>
                                        <span class="inline-block px-2 py-1 rounded-full ${order.status_color} font-bold text-xs">
                                            ${order.status_label}
                                        </span>
                                    </div>
                                
                            </div>

                            <!-- Shipping Address -->
                            <div class="bg-white rounded-lg p-4">
                                <h3 class="text-sm font-bold mb-3 font-heading" style="color: #2d3748;">
                                    Alamat Pengiriman
                                </h3>
                                <div class="space-y-2 text-xs">
                                    <div>
                                        <p class="text-gray-600 mb-0.5 font-sans">Nama Penerima</p>
                                        <p class="font-bold font-sans">${order.address.full_name}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-0.5 font-sans">Nomor Telepon</p>
                                        <p class="text-gray-700 font-bold font-sans">${order.address.phone}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-0.5 font-sans">Email</p>
                                        <p class="text-gray-700 font-bold break-all font-sans">${order.address.email}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-0.5 font-sans">Alamat Lengkap</p>
                                        <p class="text-gray-700 font-bold font-sans">${order.address.address}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-white rounded-lg p-4">
                                <h3 class="text-sm font-bold mb-3 font-heading" style="color: #2d3748;">
                                    Produk yang Dipesan
                                </h3>
                                <div class="space-y-2">
                                    ${itemsHtml}
                                </div>
                            </div>

                            <div class="bg-primary-primaryBlue rounded-lg p-4 text-white">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-heading font-semibold">Total Harga</span>
                                    <span class="text-sm font-heading font-semibold">
                                        ${order.total_subtotal_formatted}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-heading font-semibold">Total Discount</span>
                                    <span class="text-sm font-heading font-semibold">
                                        ${order.total_discount_formatted}
                                    </span>
                                </div>
                                <hr class="my-2" />
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold font-heading">Total Pembayaran</span>
                                    <span class="text-lg font-bold font-heading">
                                        ${order.total_price_formatted}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
        }

        function closeOrderDetail() {
            document.getElementById('orderDetailModal').classList.add('hidden');
        }

        function handleModalClick(event) {
            if (event.target.id === 'orderDetailModal') {
                closeOrderDetail();
            }
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeOrderDetail();
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
    </style>

@endsection