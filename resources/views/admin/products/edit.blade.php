@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="space-y-6">

    <!-- Back Button & Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-primary-primaryBlue rounded-xl border border-gray/30 hover:bg-primary-primaryBlue/50 transition font-sans font-bold text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        
        <div class="text-right">
            <p class="text-sm font-sans text-gray">Editing Product</p>
            <p class="font-heading font-bold text-primary-primaryBlue">{{ $product->name }}</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Product Details -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Basic Information -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-lg font-heading font-bold text-primary-primaryBlue mb-4">Basic Information</h3>
                    
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-sans font-bold text-black mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $product->name) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans"
                            placeholder="Enter product name"
                            required
                        >
                        @error('name')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-sans font-bold text-black mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="6"
                            class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans resize-none"
                            placeholder="Enter product description..."
                            required
                        >{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-lg font-heading font-bold text-primary-primaryBlue mb-4">Pricing & Inventory</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-sans font-bold text-black mb-2">
                                Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 font-sans font-bold text-gray">Rp</span>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    value="{{ old('price', $product->price) }}"
                                    step="0.01"
                                    min="0"
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans"
                                    placeholder="0"
                                    required
                                >
                            </div>
                            @error('price')
                            <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-sans font-bold text-black mb-2">
                                Stock Quantity <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="stock" 
                                id="stock" 
                                value="{{ old('stock', $product->stock) }}"
                                min="0"
                                class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans"
                                placeholder="0"
                                required
                            >
                            @error('stock')
                            <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                            @enderror
                            @if($product->stock < 10)
                            <p class="text-red-500 text-xs mt-1 font-sans font-bold">⚠️ Low Stock Warning!</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                @if(isset($categories) && $categories->count() > 0)
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-lg font-heading font-bold text-primary-primaryBlue mb-4">Categories</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($categories as $category)
                        <label class="flex items-center space-x-2 cursor-pointer p-3 rounded-lg border border-gray/30 hover:bg-secondary/30 transition {{ $product->categories->contains($category->id) ? 'bg-accent-pink/30 border-accent-blue' : '' }}">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
                                {{ $product->categories->contains($category->id) ? 'checked' : '' }}
                                class="w-4 h-4 text-accent-blue border-gray rounded focus:ring-accent-blue focus:ring-2"
                            >
                            <span class="text-sm font-sans font-bold text-primary-primaryBlue">{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <!-- Right Column - Image & Status -->
            <div class="space-y-6">

                <!-- Product Image -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-lg font-heading font-bold text-primary-primaryBlue mb-4">Product Image</h3>
                    
                    <!-- Current Image Preview -->
                    <div class="mb-4">
                        <label class="block text-sm font-sans font-bold text-black mb-2">Current Image</label>
                        <div class="relative aspect-square rounded-xl overflow-hidden bg-accent-bluesoft/20 border-2 border-dashed border-gray/30">
                            @if($product->image)
                                <img 
                                    id="currentImage"
                                    src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover"
                                >
                                <div class="absolute top-2 right-2 bg-accent-blue text-white text-xs px-3 py-1 rounded-full font-sans font-bold">
                                    Current
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray">
                                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm font-sans">No Image</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upload New Image -->
                    <div>
                        <label for="image" class="block text-sm font-sans font-bold text-black mb-2">
                            Upload New Image
                        </label>
                        <input 
                            type="file" 
                            name="image" 
                            id="image" 
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                            class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-accent-blue file:text-white file:font-sans file:font-bold hover:file:bg-accent-blue/90 file:cursor-pointer"
                        >
                        <p class="text-xs font-sans text-gray mt-2">JPG, PNG, GIF (Max: 1MB)</p>
                        @error('image')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <label class="block text-sm font-sans font-bold text-black mb-2">New Image Preview</label>
                        <div class="relative aspect-square rounded-xl overflow-hidden border-2 border-accent-blue">
                            <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-3 py-1 rounded-full font-sans font-bold">
                                New
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-lg font-heading font-bold text-primary-primaryBlue mb-4">Status</h3>
                    
                    <label class="flex items-start space-x-3 cursor-pointer p-4 rounded-xl border-2 transition 
                        {{ old('is_active', $product->is_active ?? 0) ? 'bg-accent-pink/20 border-accent-blue' : 'border-gray/30 hover:bg-secondary/30' }}">
                        
                        <input type="hidden" name="is_active" value="0">

                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $product->is_active ?? 0) ? 'checked' : '' }}
                            class="w-5 h-5 text-accent-blue border-gray rounded focus:ring-accent-blue focus:ring-2 mt-0.5"
                        >
                        
                        <div>
                            <span class="block font-sans font-bold text-primary-primaryBlue">Active Product</span>
                            <span class="block text-xs font-sans text-gray mt-1">Make this product visible on the website</span>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl p-6 space-y-3">
                    <button 
                        type="submit"
                        class="w-full bg-accent-blue hover:bg-accent-blue/90 text-white font-sans font-bold py-3 px-6 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Product
                    </button>
                    
                    <a 
                        href="{{ route('admin.products.index') }}"
                        class="w-full bg-gray/20 hover:bg-gray/30 text-gray font-sans font-bold py-3 px-6 rounded-xl transition-colors duration-200 text-center block"
                    >
                        Cancel
                    </a>
                </div>

            </div>

        </div>
    </form>

</div>

<!-- Image Preview Script -->
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').classList.add('hidden');
        }
    });
</script>

@endsection