@extends('layouts.app')

@section('content')
@section('title', 'My Cart - Zeniro Store')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Side - Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                
                <!-- Select All & Action Buttons Header -->
                <div class="bg-accent-blue rounded-2xl p-4 flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" id="selectAll" 
                               class="w-5 h-5 rounded border-2 border-accent-blue checked:bg-white">
                        <span class="text-white font-bold">Select All</span>
                    </label>
                    <button onclick="deleteSelected()" 
                            class="bg-white text-accent-blue px-6 py-2 rounded-full font-bold hover:bg-secondary transition">
                        Delete
                    </button>
                </div>
                        
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

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                        <ul class="text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Cart Items List -->
                <div id="cartItemsContainer" class="space-y-4">
                    @forelse($cartItems as $item)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200" data-cart-id="{{ $item->id }}" data-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}">
                            <div class="flex items-center gap-4">
                                <!-- Checkbox -->
                                <input type="checkbox" 
                                       class="cart-checkbox w-5 h-5 rounded border-2 border-blue-700 checked:bg-blue-700"
                                       value="{{ $item->id }}"
                                       onchange="updateCheckoutSummary()">
                                
                                <!-- Product Image -->
                                <div class="w-24 h-24 bg-accent-blue rounded-xl flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover rounded-xl">
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $item->product->description }}</p>
                                    <p class="font-bold text-gray-800 mt-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-2">
                                    <button onclick="updateQuantity({{ $item->id }}, -1)" 
                                            class="w-8 h-8 bg-accent-blue text-white rounded-l-lg hover:bg-accent-blue/30 transition font-bold">
                                        −
                                    </button>
                                    <span class="w-12 text-center font-bold" id="quantity-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button onclick="updateQuantity({{ $item->id }}, 1)" 
                                            class="w-8 h-8 bg-accent-blue text-white rounded-r-lg hover:bg-accent-blue/30 transition font-bold">
                                        +
                                    </button>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-6 h-6 text-red-500 rounded-lg hover:text-red-700 hover:bg-red-50 transition ml-2 flex items-center justify-center">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl p-12 text-center">
                            <p class="text-gray-500 text-lg">Cart Anda kosong</p>
                            <a href="{{ route('products.index') }}" 
                               class="inline-block mt-4 bg-accent-blue text-white px-6 py-2 rounded-full hover:bg-blue-800 transition">
                                Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>

            <!-- Right Side - Checkout Form -->
            <div class="space-y-6">
                
                <!-- Detail Order -->
                <div class="bg-secondary rounded-2xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Order</h2>
                    
                    <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm" class="space-y-4">
                        @csrf
                        
                        <input type="text" 
                               name="full_name" 
                               placeholder="Full Name"
                               value="{{ Auth::check() ? Auth::user()->name : old('full_name') }}"
                               {{ Auth::check() ? 'readonly' : '' }}
                               required
                               class="w-full px-4 py-3 rounded-xl bg-white border-0 focus:ring-2 focus:ring-blue-500 {{ Auth::check() ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                        
                        <input type="email" 
                               name="email" 
                               placeholder="Email"
                               value="{{ Auth::check() ? Auth::user()->email : old('email') }}"
                               {{ Auth::check() ? 'readonly' : '' }}
                               required
                               class="w-full px-4 py-3 rounded-xl bg-white border-0 focus:ring-2 focus:ring-blue-500 {{ Auth::check() ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                        
                        <input type="tel" 
                               name="phone" 
                               placeholder="Phone"
                               value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}"
                               required
                               class="w-full px-4 py-3 rounded-xl bg-white border-0 focus:ring-2 focus:ring-blue-500">
                        
                        <textarea name="address" 
                                  placeholder="Address" 
                                  rows="4"
                                  required
                                  class="w-full px-4 py-3 rounded-xl bg-white border-0 focus:ring-2 focus:ring-blue-500 resize-none">{{ old('address') }}</textarea>
                    </form>
                </div>

                <!-- Check Out Summary -->
                <div class="bg-secondary rounded-2xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Check Out</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Sub Total</span>
                            <span class="font-bold" id="subtotalDisplay">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-700">
                            <span>Total Discount</span>
                            <span class="font-bold" id="discountDisplay">Rp {{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                        
                        <hr class="border-gray-400">
                        
                        <div class="flex justify-between text-gray-800 text-lg">
                            <span class="font-bold">Total</span>
                            <span class="font-bold" id="totalDisplay">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Purchase Button -->
                <button type="button"
                        onclick="purchaseSelected()"
                        class="w-full bg-accent-blue text-white py-4 rounded-2xl font-bold text-lg hover:bg-accent-blue/80 transition">
                    Purchase Selected
                </button>

            </div>

        </div>
    </div>
</div>

<script>
// Calculate Discount based on subtotal
function calculateDiscount(subtotal) {
    if (subtotal > 2000000) return subtotal * 0.15; // 15% discount
    if (subtotal > 1000000) return subtotal * 0.10; // 10% discount
    if (subtotal > 100000) return subtotal * 0.01; // 1% discount
    return 0;
}

// Format number to currency
function formatCurrency(value) {
    return 'Rp ' + Math.round(value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Update Checkout Summary based on selected items
function updateCheckoutSummary() {
    const selectedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
    let selectedSubtotal = 0;

    selectedCheckboxes.forEach(checkbox => {
        const cartItem = checkbox.closest('[data-cart-id]');
        const price = parseFloat(cartItem.dataset.price);
        const quantity = parseInt(cartItem.dataset.quantity);
        selectedSubtotal += price * quantity;
    });

    // Calculate discount and total
    const discount = calculateDiscount(selectedSubtotal);
    const total = selectedSubtotal - discount;

    // Update display
    document.getElementById('subtotalDisplay').textContent = formatCurrency(selectedSubtotal);
    document.getElementById('discountDisplay').textContent = formatCurrency(discount);
    document.getElementById('totalDisplay').textContent = formatCurrency(total);
}

// Select All Functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.cart-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateCheckoutSummary();
});

// Update individual checkbox to affect select all
document.querySelectorAll('.cart-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const selectAll = document.getElementById('selectAll');
        const allCheckboxes = document.querySelectorAll('.cart-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
        selectAll.checked = allCheckboxes.length === checkedCheckboxes.length;
        updateCheckoutSummary();
    });
});

// Purchase Selected Items
function purchaseSelected() {
    const selectedIds = Array.from(document.querySelectorAll('.cart-checkbox:checked'))
        .map(cb => cb.value);

    let selectedInput = document.getElementById('selectedCartIds');
    if (!selectedInput) {
        selectedInput = document.createElement('input');
        selectedInput.type = 'hidden';
        selectedInput.id = 'selectedCartIds';
        selectedInput.name = 'selected_cart_ids';
        document.getElementById('checkoutForm').appendChild(selectedInput);
    }
    
    // if (selectedIds.length === 0) {
    //     alert('Pilih item yang ingin dibeli');
    //     return;
    // }

    selectedInput.value = JSON.stringify(selectedIds);
    
    // Submit checkout form
    document.getElementById('checkoutForm').submit();
}

// Delete Selected Items
function deleteSelected() {
    const selectedIds = Array.from(document.querySelectorAll('.cart-checkbox:checked'))
        .map(cb => cb.value);
    
    // if (selectedIds.length === 0) {
    //     alert('Pilih item yang ingin dihapus');
    //     return;
    // }
    if (selectedIds.length > 0) {
        if (!confirm('Yakin mau menghapus item yang dipilih?')) return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("cart.deleteSelected") }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    form.appendChild(methodField);
    
    selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'cart_ids[]';
        input.value = id;
        form.appendChild(input);
    });

    selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'cart_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}

// Update Quantity
function updateQuantity(cartId, change) {
    const quantityElement = document.getElementById(`quantity-${cartId}`);
    let currentQuantity = parseInt(quantityElement.textContent);
    let newQuantity = currentQuantity + change;
    
    if (newQuantity < 1) return;
    
    fetch(`/cart/update/${cartId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            quantityElement.textContent = newQuantity;
            
            // Update the data attribute for quantity
            const cartItem = document.querySelector(`[data-cart-id][data-price]`);
            if (cartItem) {
                const cartItemDiv = quantityElement.closest('[data-cart-id]');
                if (cartItemDiv) {
                    cartItemDiv.dataset.quantity = newQuantity;
                }
            }
            
            // Recalculate checkout summary
            updateCheckoutSummary();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection