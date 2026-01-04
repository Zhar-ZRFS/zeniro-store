@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Products -->
        <div class="bg-white rounded-2xl p-6 border-l-4 border-accent-blue">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-sans text-gray mb-1">Total Products</p>
                    <p class="text-3xl font-heading font-bold text-primary-primaryBlue">{{ $stats['total_products'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl p-6 border-l-4 border-primary-primaryPink">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-sans text-gray mb-1">Total Orders</p>
                    <p class="text-3xl font-heading font-bold text-primary-primaryBlue">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-primaryPink/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-primaryPink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-2xl p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-sans text-gray mb-1">Pending Orders</p>
                    <p class="text-3xl font-heading font-bold text-primary-primaryBlue">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-2xl p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-sans text-gray mb-1">Total Users</p>
                    <p class="text-3xl font-heading font-bold text-primary-primaryBlue">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-heading font-bold text-primary-primaryBlue">Order Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-accent-blue font-sans text-sm font-bold hover:underline">
                    View All
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between p-4 bg-secondary/50 rounded-xl">
                        <div class="flex items-center gap-4">
                            <!-- Product Image (first item) -->
                            @if($order->items->isNotEmpty() && $order->items->first()->product && $order->items->first()->product->image)
                                <div class="w-12 h-12 bg-accent-bluesoft rounded-lg overflow-hidden">
                                    <img src="{{ filter_var($order->items->first()->product->image, FILTER_VALIDATE_URL) ? $order->items->first()->product->image : asset('storage/' . $order->items->first()->product->image) }}" 
                                         alt="{{ $order->items->first()->product->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-12 h-12 bg-accent-bluesoft rounded-lg"></div>
                            @endif
                            
                            <div>
                                <p class="font-sans font-bold text-black">Order {{ $order->order_number }}</p>
                                <p class="text-sm font-sans text-gray">
                                    {{ $order->items->count() }} {{ $order->items->count() > 1 ? 'items' : 'item' }} • 
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <span class="px-3 py-1 {{ $order->status_color }} rounded-full text-xs font-sans font-bold">
                            {{ $order->status_label }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="font-sans text-gray">Belum ada order</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-6">
            <h3 class="text-xl font-heading font-bold text-primary-primaryBlue mb-6">Aksi Cepat</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" 
                   class="flex items-center gap-3 p-4 bg-accent-blue text-white rounded-xl hover:bg-accent-blue/90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="font-sans font-bold">Add Product</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 p-4 bg-accent-pink text-primary-primaryBlue rounded-xl hover:bg-primary-primaryPink/90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-sans font-bold">Manage Users</span>
                </a>

                <a href="{{ route('admin.messages.index') }}" 
                   class="flex items-center gap-3 p-4 bg-secondary text-primary-primaryBlue rounded-xl hover:bg-secondary/80 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-sans font-bold">View Messages</span>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection