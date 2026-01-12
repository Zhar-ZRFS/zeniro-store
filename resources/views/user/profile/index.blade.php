@extends('layouts.app')

@section('title', 'My Profile - Zeniro Store')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold font-heading" style="color: #305C8E;">
                My Profile
            </h1>
            <p class="text-gray-600 mt-2 font-sans">Manage your account and view your activity</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                <p class="text-sm text-green-700 font-sans font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Profile Info & Stats -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Profile Card -->
                <div class="bg-blue-100 rounded-3xl p-6 shadow-md">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="w-24 h-24 bg-primary-primaryPink rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-4xl font-heading font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>

                        <!-- Name & Email -->
                        <h2 class="text-2xl font-heading font-bold text-primary-primaryBlue mb-1">
                            {{ $user->name }}
                        </h2>
                        <p class="text-sm text-gray-600 font-sans mb-1">{{ $user->email }}</p>
                        
                        @if($user->phone)
                            <p class="text-sm text-gray-600 font-sans mb-3">{{ $user->phone }}</p>
                        @endif

                        <!-- Role Badge -->
                        <span class="inline-block px-4 py-1 {{ $user->role_color }} rounded-full text-sm font-sans font-bold mb-4">
                            {{ $user->role_label }}
                        </span>

                        <!-- Edit Profile Button -->
                        <div class="flex gap-4">                     
                        <a href="{{ route('user.profile.edit') }}" 
                        class="flex-1 bg-accent-blue text-white px-4 py-3 rounded-xl font-sans font-bold hover:bg-accent-blue/90 transition text-center">
                            Edit Profile
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="flex-1">
                            @csrf
                            
                            <button type="submit"
                                class="w-full bg-pink-400 text-white px-4 py-3 rounded-xl font-sans font-bold hover:bg-primary-primaryPink/90 transition text-center flex items-center justify-center">
                                
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="bg-blue-100 rounded-3xl p-6 shadow-md">
                    <h3 class="text-lg font-heading font-bold text-primary-primaryBlue mb-4">Account Stats</h3>
                    
                    <div class="space-y-3">
                        <!-- Total Orders -->
                        <div class="flex items-center justify-between bg-white rounded-xl p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <span class="font-sans text-sm text-gray-700">Total Orders</span>
                            </div>
                            <span class="font-heading font-bold text-xl text-primary-primaryBlue">
                                {{ $stats['total_orders'] }}
                            </span>
                        </div>

                        <!-- Total Spent -->
                        <div class="flex items-center justify-between bg-white rounded-xl p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-sans text-sm text-gray-700">Total Spent</span>
                            </div>
                            <span class="font-heading font-bold text-lg text-primary-primaryBlue">
                                Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Pending Orders -->
                        <div class="flex items-center justify-between bg-white rounded-xl p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-sans text-sm text-gray-700">Pending</span>
                            </div>
                            <span class="font-heading font-bold text-xl text-primary-primaryBlue">
                                {{ $stats['pending_orders'] }}
                            </span>
                        </div>

                        <!-- Completed Orders -->
                        <div class="flex items-center justify-between bg-white rounded-xl p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-sans text-sm text-gray-700">Completed</span>
                            </div>
                            <span class="font-heading font-bold text-xl text-primary-primaryBlue">
                                {{ $stats['completed_orders'] }}
                            </span>
                        </div>

                        <!-- Messages -->
                        <div class="flex items-center justify-between bg-white rounded-xl p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="font-sans text-sm text-gray-700">Messages</span>
                            </div>
                            <span class="font-heading font-bold text-xl text-primary-primaryBlue">
                                {{ $stats['total_messages'] }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column - Recent Activity -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Recent Orders -->
                <div class="bg-blue-100 rounded-3xl p-6 shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-heading font-bold text-primary-primaryBlue">Recent Orders</h3>
                        <a href="{{ route('orders.history') }}" 
                           class="text-sm font-sans font-bold text-accent-blue hover:text-primary-primaryBlue transition">
                            View All →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentOrders as $order)
                            <div class="bg-white rounded-2xl p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <p class="font-heading font-bold text-primary-primaryBlue">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600 font-sans">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 {{ $order->status_color }} rounded-full text-xs font-sans font-bold">
                                        {{ $order->status_label }}
                                    </span>
                                </div>

                                <!-- Order Items Preview -->
                                <div class="flex items-center gap-2 mb-3 overflow-x-auto pb-2 scrollbar-hide">
                                    @foreach($order->items->take(3) as $item)
                                        <div class="w-16 h-16 bg-blue-600 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ filter_var($item->product->image, FILTER_VALIDATE_URL) ? $item->product->image : asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-400">
                                                    <span class="text-white text-xs font-bold">?</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-gray-600 text-xs font-bold">+{{ $order->items->count() - 3 }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-600 font-sans">{{ $order->items->count() }} item(s)</p>
                                    <p class="font-heading font-bold text-primary-primaryBlue">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl p-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <p class="text-gray-500 font-sans">No orders yet</p>
                                <a href="{{ route('products.index') }}" 
                                   class="inline-block mt-4 px-6 py-3 bg-primary-primaryPink text-white rounded-full hover:bg-pink-500 transition font-bold">
                                    Start Shopping
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="bg-blue-100 rounded-3xl p-6 shadow-md">
                    <h3 class="text-xl font-heading font-bold text-primary-primaryBlue mb-4">Recent Messages</h3>

                    <div class="space-y-3">
                        @forelse($recentMessages as $message)
                            <div class="bg-white rounded-2xl p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <p class="text-sm text-gray-600 font-sans">{{ $message->created_at->format('M d, Y') }}</p>
                                    @if($message->is_read)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-sans font-bold">
                                            Read
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-sans font-bold">
                                            Unread
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700 font-sans line-clamp-2">{{ $message->message }}</p>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl p-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 font-sans">No messages yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

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