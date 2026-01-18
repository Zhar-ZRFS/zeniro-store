@extends('admin.layouts.app')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Tabs -->
    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        <a href="{{ route('admin.orders.index') }}" 
           class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $status === 'all' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
           class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $status === 'pending' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
            Pending ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'process']) }}" 
           class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $status === 'process' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
            Process ({{ $statusCounts['process'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" 
           class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $status === 'completed' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
            Completed ({{ $statusCounts['completed'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
           class="px-3 py-1 text-xs rounded-full font-sans font-bold whitespace-nowrap transition {{ $status === 'cancelled' ? 'bg-accent-blue text-white' : 'bg-white text-gray hover:bg-accent-blue/40 hover:text-white' }}">
            Cancelled ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-3 py-1 {{ $order->status_color }} rounded-full text-xs font-sans font-bold">
                                    {{ $order->status_label }}
                                </span>
                                @if($order->user_id)
                                    <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-sans font-bold">
                                        Registered User
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-1 bg-gray/20 text-gray rounded text-xs font-sans font-bold">
                                        Guest
                                    </span>
                                @endif
                            </div>
                            <p class="font-sans font-bold text-black">Order {{ $order->order_number }}</p>
                            <p class="text-sm font-sans text-gray">
                                {{ $order->created_at->format('M d, Y') }} • 
                                {{ $order->address->full_name ?? 'Guest' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-lg font-sans font-bold text-primary-primaryBlue">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Order Items Preview -->
                <div class="space-y-3 mb-4">
                    @foreach($order->items->take(2) as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-accent-bluesoft rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->image)
                                    <img src="{{ filter_var($item->product->image, FILTER_VALIDATE_URL) ? $item->product->image : asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray/20">
                                        <svg class="w-8 h-8 text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-sans font-bold text-black">{{ $item->product_name }}</p>
                                <p class="text-sm font-sans text-gray">
                                    {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @if($order->items->count() > 2)
                        <p class="text-sm font-sans text-gray text-center">
                            +{{ $order->items->count() - 2 }} more item(s)
                        </p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        @method('PUT')
                        
                        <select name="status" 
                                class="px-4 py-2 rounded-lg border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans text-sm">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="process" {{ $order->status === 'process' ? 'selected' : '' }}>Process</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        
                        <button type="submit" 
                                class="px-4 py-2 bg-accent-blue text-white rounded-lg hover:bg-accent-blue/90 transition font-sans font-bold text-sm">
                            Update Status
                        </button>
                    </form>
                    
                    <button onclick="showOrderDetail({{ $order->id }})" 
                            class="px-4 py-2 bg-secondary text-primary-primaryBlue rounded-lg hover:bg-secondary/80 transition font-sans font-bold text-sm">
                        View Details
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="font-sans text-gray text-lg">
                    @if($status !== 'all')
                        No {{ $statuses[$status] ?? $status }} orders found
                    @else
                        Belum ada order
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="flex items-center justify-between bg-white rounded-2xl p-6">
            <p class="font-sans text-gray text-sm">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
            </p>
            <div class="flex items-center gap-2">
                @if ($orders->onFirstPage())
                    <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $orders->appends(['status' => $status])->previousPageUrl() }}" 
                       class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-white transition">
                        Previous
                    </a>
                @endif

                @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    @if($page == $orders->currentPage())
                        <span class="px-4 py-2 bg-accent-blue text-white rounded-lg font-sans font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $orders->appends(['status' => $status])->url($page) }}" 
                           class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-white transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if ($orders->hasMorePages())
                    <a href="{{ $orders->appends(['status' => $status])->nextPageUrl() }}" 
                       class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-white transition">
                        Next
                    </a>
                @else
                    <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>
        </div>
    @endif

</div>

<!-- Order Detail Modal -->
<div id="orderDetailModal" class="hidden fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4 backdrop-blur-sm" onclick="handleModalClick(event)">
    <div class="bg-white rounded-2xl max-w-md w-full relative" style="max-height: 90vh;" onclick="event.stopPropagation()">
        
        <!-- Header -->
        <div class="bg-primary-primaryBlue rounded-t-2xl px-4 py-3 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-heading font-bold text-white">Order Details</h2>
                <p id="modalOrderNumber" class="text-accent-bluesoft font-sans mt-0.5 text-xs">#ZEN-00000</p>
            </div>
            <button onclick="closeModal()" class="text-white hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div id="orderDetailContent" class="p-4 overflow-y-auto" style="max-height: calc(90vh - 80px)">
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-blue"></div>
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
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-blue"></div>
        </div>
    `;
    
    fetch(`/admin/orders/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.getElementById('modalOrderNumber').textContent = data.order.order_number;
                renderOrderDetail(data.order);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-12">
                    <p class="text-red-600 font-sans">Failed to load order details</p>
                </div>
            `;
        });
}

function renderOrderDetail(order) {
    const content = document.getElementById('orderDetailContent');
    
    const itemsHtml = order.items.map(item => `
        <div class="flex items-center gap-2 p-2 bg-secondary/30 rounded-lg">
            <div class="w-12 h-12 bg-accent-bluesoft rounded-lg overflow-hidden flex-shrink-0">
                ${item.product_image 
                    ? `<img src="${item.product_image}" alt="${item.product_name}" class="w-full h-full object-cover">`
                    : `<div class="w-full h-full flex items-center justify-center bg-gray/20">
                         <svg class="w-6 h-6 text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                         </svg>
                       </div>`
                }
            </div>
            <div class="flex-1">
                <p class="font-sans font-bold text-black text-sm">${item.product_name}</p>
                <p class="font-sans text-gray text-xs">${item.quantity} x Rp ${item.price_formatted}</p>
            </div>
            <div class="text-right">
                <p class="font-sans font-bold text-primary-primaryBlue text-sm">${item.subtotal_formatted}</p>
            </div>
        </div>
    `).join('');
    
    content.innerHTML = `
        <div class="space-y-3">
            <!-- Order Info -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-secondary rounded-lg p-3">
                    <p class="text-xs font-sans text-gray mb-1">Order Date</p>
                    <p class="font-sans font-bold text-black text-sm">${order.created_at}</p>
                </div>
                <div class="bg-secondary rounded-lg p-3">
                    <p class="text-xs font-sans text-gray mb-1">Status</p>
                    <span class="inline-block px-2 py-0.5 ${order.status_color} rounded-full font-sans font-bold text-xs">
                        ${order.status_label}
                    </span>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-secondary rounded-lg p-3">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-heading font-bold text-primary-primaryBlue">Customer Information</h3>
                    ${order.user_id 
                        ? '<span class="inline-block px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-sans font-bold">Registered User</span>'
                        : '<span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-700 rounded-full text-xs font-sans font-bold">Guest</span>'}
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-xs font-sans text-gray mb-0.5">Name</p>
                        <p class="font-sans font-bold text-black text-xs">${order.address.full_name}</p>
                    </div>
                    <div>
                        <p class="text-xs font-sans text-gray mb-0.5">Email</p>
                        <p class="font-sans text-black text-xs">${order.address.email}</p>
                    </div>
                    <div>
                        <p class="text-xs font-sans text-gray mb-0.5">Phone</p>
                        <p class="font-sans text-black text-xs">${order.address.phone}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs font-sans text-gray mb-0.5">Address</p>
                        <p class="font-sans text-black text-xs">${order.address.address}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h3 class="text-sm font-heading font-bold text-primary-primaryBlue mb-2">Order Items</h3>
                <div class="space-y-2">
                    ${itemsHtml}
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-primary-primaryBlue rounded-lg p-3 text-white">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-sans text-xs">Subtotal</span>
                        <span class="font-sans font-bold text-xs">${order.subtotal_formatted}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-sans text-xs">Discount</span>
                        <span class="font-sans font-bold text-xs">${order.discount_formatted}</span>
                    </div>
                    <div class="border-t border-white/20 pt-2 flex justify-between">
                        <span class="font-heading text-sm font-bold">Total</span>
                        <span class="font-heading text-sm font-bold">${order.total_formatted}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function closeModal() {
    document.getElementById('orderDetailModal').classList.add('hidden');
}

function handleModalClick(event) {
    if(event.target.id === 'orderDetailModal') {
        closeModal();
    }
}

document.addEventListener('keydown', function(event) {
    if(event.key === 'Escape') {
        closeModal();
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