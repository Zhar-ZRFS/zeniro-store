@extends('layouts.app')

@section('title', 'Track Your Order - Zeniro Store')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold mb-4 font-heading" style="color: #305C8E;">
                Track Your Order
            </h1>
            <p class="text-gray-600 text-base font-sans">
                Masukkan Order Number dan Email untuk melacak pesanan Anda
            </p>
        </div>

        <!-- Track Form -->
        <div class="bg-blue-100 rounded-2xl p-8 shadow-md">
            <form id="trackOrderForm" class="space-y-6">
                @csrf

                <!-- Order Number Input -->
                <div>
                    <label for="order_number" class="block text-sm font-bold mb-3 font-heading" style="color: #2d3748;">
                        Order Number <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="order_number" 
                        name="order_number"
                        placeholder="Contoh: ZEN-1234567890"
                        required
                        class="w-full px-5 py-4 rounded-xl border-2 border-gray-300 focus:outline-none focus:border-blue-500 transition font-sans text-sm"
                    >
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-bold mb-3 font-heading" style="color: #2d3748;">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        placeholder="email@example.com"
                        required
                        class="w-full px-5 py-4 rounded-xl border-2 border-gray-300 focus:outline-none focus:border-blue-500 transition font-sans text-sm"
                    >
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <p class="text-sm text-red-700 font-medium font-sans"></p>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    id="trackButton"
                    class="w-full bg-pink-400 text-white px-6 py-4 rounded-xl text-base font-bold hover:bg-pink-500 transition font-sans flex items-center justify-center gap-3"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Track Order</span>
                </button>
            </form>

            <!-- Info Text -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 font-sans">
                    Order Number dapat ditemukan di email konfirmasi atau struk pembayaran Anda
                </p>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-white rounded-3xl p-6 shadow-md">
            <h3 class="text-xl font-bold mb-4 font-heading" style="color: #305C8E;">
                Butuh Bantuan?
            </h3>
            <div class="space-y-3 text-sm font-sans text-gray-700">
                <p>• Order Number bisa ditemukan di email konfirmasi setelah checkout</p>
                <p>• Pastikan menggunakan email yang sama saat melakukan pemesanan</p>
                <p>• Jika mengalami kesulitan, silakan hubungi kami melalui halaman <a href="{{ route('home') }}#kontak" class="font-bold font-sans text-accent-blue hover:text-accent-blue/90">Contact Us</a></p>
            </div>
        </div>

    </div>
</div>

<!-- Order Detail Modal (Ukuran 40% Lebih Besar) -->
<div id="orderDetailModal" class="hidden fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm"
    onclick="handleModalClick(event)">

    <div class="bg-secondary rounded-xl max-w-xl w-full relative" style="max-height: 90vh;"
        onclick="event.stopPropagation()">

        <!-- Header -->
        <div class="bg-primary-primaryBlue rounded-t-xl px-6 py-4 flex items-center justify-between">
            <h2 class="text-xl font-bold text-white font-heading">
                Order Tracking Details
            </h2>
            <button onclick="closeOrderDetail()" class="text-white hover:text-gray-200 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <div id="orderDetailContent" class="p-7 overflow-y-auto" style="max-height: calc(90vh - 70px);">
            <!-- Loading State -->
            <div class="flex justify-center items-center py-16">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('trackOrderForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const button = document.getElementById('trackButton');
        const errorDiv = document.getElementById('errorMessage');
        const orderNumber = document.getElementById('order_number').value;
        const email = document.getElementById('email').value;

        // Hide error
        errorDiv.classList.add('hidden');

        // Show loading
        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Searching...</span>
        `;

        try {
            const response = await fetch('{{ route("track.order.search") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    order_number: orderNumber,
                    email: email
                })
            });

            const data = await response.json();

            if (data.success) {
                // Show modal with order details
                showOrderDetail(data.order);
            } else {
                // Show error
                errorDiv.querySelector('p').textContent = data.message;
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            errorDiv.querySelector('p').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            errorDiv.classList.remove('hidden');
        } finally {
            // Reset button
            button.disabled = false;
            button.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Track Order</span>
            `;
        }
    });

    function showOrderDetail(order) {
        const modal = document.getElementById('orderDetailModal');
        const content = document.getElementById('orderDetailContent');

        modal.classList.remove('hidden');
        renderOrderDetail(order);
    }

    function renderOrderDetail(order) {
        const content = document.getElementById('orderDetailContent');

        // Progress Steps berdasarkan status
        const steps = [
            { key: 'pending', label: 'Pending', icon: 'clock' },
            { key: 'process', label: 'Processing', icon: 'cog' },
            { key: 'completed', label: 'Completed', icon: 'check' },
        ];

        const currentStatusIndex = steps.findIndex(step => step.key === order.status);
        const isCancelled = order.status === 'cancelled';

        const progressHtml = `
            <div class="mb-6">
                ${isCancelled 
                    ? `<div class="bg-red-100 border-l-4 border-red-500 p-5 rounded-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-bold text-xl text-red-800 font-heading">Order Dibatalkan</p>
                                <p class="text-sm text-red-700 font-sans">Pesanan Anda telah dibatalkan</p>
                            </div>
                        </div>
                    </div>`
                    : `<div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            ${steps.map((step, index) => {
                                const isActive = index <= currentStatusIndex;
                                const isCurrent = index === currentStatusIndex;
                                
                                return `
                                    <div class="flex flex-col items-center flex-1 relative">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center ${
                                            isActive ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600'
                                        } mb-2 relative z-10 shadow-lg">
                                            ${step.icon === 'clock' ? `
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            ` : step.icon === 'cog' ? `
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            ` : `
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            `}
                                        </div>
                                        <p class="text-sm font-bold font-heading ${isActive ? 'text-blue-600' : 'text-gray-500'}">
                                            ${step.label}
                                        </p>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>`
                }
            </div>
        `;

        const itemsHtml = order.items.map(item => `
            <div class="flex items-center gap-4 bg-white rounded-2xl p-4">
                <div class="w-20 h-20 bg-blue-600 rounded-lg overflow-hidden flex-shrink-0">
                    ${item.product_image
                        ? `<img src="${item.product_image}" alt="${item.product_name}" class="w-full h-full object-cover">`
                        : `<div class="w-full h-full flex items-center justify-center bg-gray-400">
                             <span class="text-white text-base font-bold">?</span>
                           </div>`
                    }
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-base font-heading truncate">
                        ${item.product_name}
                    </h4>
                    <p class="text-sm text-gray-600 font-sans mt-1">
                        ${item.price_formatted} x ${item.qty}
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-bold text-base" style="color: #2d3748;">
                        ${item.subtotal_formatted}
                    </p>
                </div>
            </div>
        `).join('');

        content.innerHTML = `
            <div class="space-y-6">
                <!-- Progress Tracker -->
                ${progressHtml}

                <!-- Order Info -->
                <div class="bg-white rounded-lg p-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 font-sans mb-1">Order Number</p>
                            <p class="font-bold text-base font-heading text-primary-primaryBlue truncate">
                                ${order.order_number}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-sans mb-1">Order Date</p>
                            <p class="font-bold text-base font-heading" style="color: #2d3748;">
                                ${order.created_at}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-2 font-sans">Status</p>
                        <span class="inline-block px-4 py-2 rounded-full ${order.status_color} font-bold text-sm">
                            ${order.status_label}
                        </span>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg p-5">
                    <h3 class="text-base font-bold mb-4 font-heading" style="color: #2d3748;">
                        Alamat Pengiriman
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 mb-1 font-sans">Nama Penerima</p>
                            <p class="font-bold font-sans">${order.address.full_name}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1 font-sans">Nomor Telepon</p>
                            <p class="text-gray-700 font-bold font-sans">${order.address.phone}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1 font-sans">Email</p>
                            <p class="text-gray-700 font-bold break-all font-sans">${order.address.email}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1 font-sans">Alamat Lengkap</p>
                            <p class="text-gray-700 font-bold font-sans">${order.address.address}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg p-5">
                    <h3 class="text-base font-bold mb-4 font-heading" style="color: #2d3748;">
                        Produk yang Dipesan
                    </h3>
                    <div class="space-y-3">
                        ${itemsHtml}
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="bg-primary-primaryBlue rounded-lg p-5 text-white">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-heading font-semibold">Total Harga</span>
                        <span class="text-base font-heading font-semibold">
                            ${order.total_subtotal_formatted}
                        </span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-heading font-semibold">Total Discount</span>
                        <span class="text-base font-heading font-semibold">
                            ${order.total_discount_formatted}
                        </span>
                    </div>
                    <hr class="my-3 border-white/30" />
                    <div class="flex justify-between items-center">
                        <span class="text-base font-bold font-heading">Total Pembayaran</span>
                        <span class="text-2xl font-bold font-heading">
                            ${order.total_price_formatted}
                        </span>
                    </div>
                </div>

                <!-- Download PDF Button -->
                <div class="flex justify-center w-full gap-4">
                    <a href="/order/download-receipt/${order.order_number}" 
                       class="inline-flex items-center gap-3 bg-green-600 text-white px-6 py-4 rounded-lg text-base font-bold hover:bg-green-700 transition shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Download Struk PDF</span>
                    </a>
                    <a onclick="closeOrderDetail()" 
                       class="inline-flex items-center gap-3 bg-red-600 text-white px-6 py-4 rounded-lg text-base font-bold hover:bg-red-700 transition shadow-lg">
                        <span>Close</span>
                    </a>
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

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeOrderDetail();
        }
    });
</script>

@endsection