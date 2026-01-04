@extends('layouts.app')

@section('title','Order Berhasil')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-secondary rounded-2xl shadow-lg p-8 text-center">

                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Berhasil!</h1>
                <p class="text-gray-600 mb-8">Terima kasih telah berbelanja</p>

                <!-- Order Details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6 text-left">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Order Number</p>
                            <p class="font-bold text-gray-800">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="font-bold text-gray-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-bold text-gray-800">{{ $order->address->full_name ?? 'No Name' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-bold text-gray-800">{{ $order->address->email ?? 'No Email' }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}"
                        class="bg-blue-700 text-white px-6 py-3 rounded-full font-bold hover:bg-blue-800 transition">
                        Kembali ke Beranda
                    </a>

                    <a href="{{ route('order.receipt.download', $order->order_number) }}"
                        class="bg-green-600 text-white px-6 py-3 rounded-full font-bold hover:bg-green-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="Status-down-logic-here..."></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Struk (PDF)
                    </a>

                    @auth
                        <a href="{{ route('orders.history') }}"
                            class="bg-white text-gray-800 px-6 py-3 rounded-full font-bold hover:bg-gray-300 transition">
                            Lihat Pesanan Saya
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection