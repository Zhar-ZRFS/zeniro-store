@extends('admin.layouts.app')

@section('title', 'Manage Products')
@section('page-title', 'Manage Products')

@section('content')
<div class="space-y-6">

    <!-- Actions Bar -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full md:w-auto">
            <!-- Search -->
            <div class="relative w-full md:w-40">
                <input type="text" 
       name="search" 
       value="{{ request('search') }}"
       placeholder="Search products..."
       class="w-full pl-10 pr-4 py-1.5 text-sm rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans">
                <svg class="w-5 h-5 absolute left-3 top-2 text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Filter -->
            <select name="category" 
                    onchange="this.form.submit()"
                    class="w-full md:w-auto px-4 py-1.5 text-sm rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex gap-4 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-3 py-1.5 text-center inline-block text-sm bg-accent-blue text-white rounded-lg hover:bg-accent-bluesoft transition font-sans font-bold">
                    Search
                </button>

                @if(request('search') || request('category'))
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex-1 md:flex-none px-3 py-1.5 text-center inline-block text-sm bg-gray/20 text-gray rounded-lg hover:bg-gray/30 transition font-sans font-bold">
                        Clear
                    </a>
                @endif
            </div>
        </form>

        <a href="{{ route('admin.products.create') }}"
           class="w-full md:w-auto px-2 py-2 text-sm bg-accent-blue text-white rounded-lg hover:bg-accent-blue/90 transition font-sans font-bold flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
            <thead class="bg-primary-primaryBlue">
                <tr>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Image</th>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Product Name</th>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Category</th>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Price</th>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Stock</th>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Status</th>
                    <th class="px-4 py-2.5 text-left text-sm font-heading font-bold text-white">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray/20">
                @forelse($products as $product)
                    <tr class="hover:bg-secondary/30 transition">
                        <td class="px-4 py-2.5">
                            <div class="w-16 h-16 bg-accent-bluesoft rounded-lg overflow-hidden">
                                @if($product->image)
                                    <img src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray/20">
                                        <svg class="w-8 h-8 text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2.5">
                            <p class="font-sans font-bold text-black">{{ $product->name }}</p>
                            <p class="text-sm font-sans text-gray">{{ Str::limit($product->description, 50) }}</p>
                        </td>
                        <td class="px-4 py-2.5">
                            <div class="flex flex-wrap gap-1">
                                @foreach($product->categories as $category)
                                    <span class="px-3 py-1 bg-accent-pink text-primary-primaryBlue rounded-full text-xs font-sans font-bold">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-2.5 font-sans text-base font-bold text-black w-45">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2.5">
                            <span class="font-sans text-black">{{ $product->stock }}</span>
                            @if($product->stock < 10)
                                <span class="block text-xs text-red-500 font-bold mt-1">Low Stock!</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5">
                            @if($product->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-sans font-bold">
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-sans font-bold">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="p-2 text-accent-blue hover:bg-accent-blue/10 rounded-lg transition"
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product)}}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus product {{ $product->name }}?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition"
                                            title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="font-sans text-gray text-lg">
                                @if(request('search') || request('category'))
                                    No products found matching your search
                                @else
                                    Belum ada produk
                                @endif
                            </p>
                            @if(!request('search') && !request('category'))
                                <a href="{{ route('admin.products.create') }}" 
                                   class="inline-block mt-4 px-6 py-3 bg-accent-blue text-white rounded-xl hover:bg-accent-blue/90 transition font-sans font-bold">
                                    Add Your First Product
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white rounded-2xl p-6">
            <p class="font-sans text-gray text-sm">
                <span class="hidden md:block">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} <br />of {{ $products->total() }} products</span>
                <span class="md:hidden">{{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}</span>
            </p>
            <div class="flex items-center gap-2">
                @if ($products->onFirstPage())
                    <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed flex items-center gap-2">
                        <span class="hidden md:block">Previous</span>
                        <span class="md:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    </span>
                @else
                    <a href="{{ $products->appends(request()->except('page'))->previousPageUrl() }}" 
                       class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-gray/10 transition flex items-center gap-2">
                        <span class="hidden md:block">Previous</span>
                        <span class="md:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    </a>
                @endif
                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                        <span class="px-4 py-2 bg-accent-blue text-white rounded-lg font-sans font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $products->appends(request()->except('page'))->url($page) }}" 
                           class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-gray/10 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
                @if ($products->hasMorePages())
                    <a href="{{ $products->appends(request()->except('page'))->nextPageUrl() }}" 
                       class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray hover:bg-gray/10 transition flex items-center gap-2">
                        <span class="hidden md:block">Next</span>
                        <span class="md:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </a>
                @else
                    <span class="px-4 py-2 border border-gray/30 rounded-lg font-sans font-bold text-gray cursor-not-allowed flex items-center gap-2">
                        <span class="hidden md:block">Next</span>
                        <span class="md:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </span>
                @endif
            </div>
        </div>
     @endif

</div>
@endsection