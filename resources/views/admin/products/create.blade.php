@extends('admin.layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="max-w-4xl">

    <div class="bg-white rounded-2xl p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Product Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('name') @enderror"
                       placeholder="Enter product name">
                @error('name')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Category <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 p-3 border-2 border-gray/30 rounded-xl cursor-pointer hover:border-accent-blue transition has-[:checked]:border-accent-blue has-[:checked]:bg-accent-blue/5">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}" 
                                   {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-accent-blue rounded">
                            <span class="font-sans text-sm">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('categories')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Description <span class="text-red-500">*</span></label>
                <textarea name="description" 
                          rows="4" 
                          required
                          class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans resize-none @error('description') @enderror"
                          placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Price (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" 
                           name="price" 
                           value="{{ old('price') }}"
                           required
                           min="0"
                           step="0.01"
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('price') @enderror"
                           placeholder="0">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Stock <span class="text-red-500">*</span></label>
                    <input type="number" 
                           name="stock" 
                           value="{{ old('stock') }}"
                           required
                           min="0"
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('stock') @enderror"
                           placeholder="0">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Product Image</label>
                
                <!-- Preview Image -->
                <div id="imagePreview" class="hidden mb-4">
                    <img src="" alt="Preview" class="w-48 h-48 object-cover rounded-xl border-2 border-accent-blue">
                    <button type="button" 
                            onclick="removeImage()"
                            class="mt-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-sans font-bold text-sm">
                        Remove Image
                    </button>
                </div>

                <!-- Upload Area -->
                <div id="uploadArea" 
                     class="border-2 border-dashed border-gray/30 rounded-xl p-8 text-center hover:border-accent-blue transition cursor-pointer"
                     onclick="document.getElementById('imageInput').click()">
                    <svg class="w-12 h-12 mx-auto text-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="font-sans text-gray mb-2">Click to upload or drag and drop</p>
                    <p class="font-sans text-sm text-gray">PNG, JPG up to 1MB</p>
                </div>
                
                <input type="file" 
                       id="imageInput"
                       name="image" 
                       accept="image/*" 
                       onchange="previewImage(event)"
                       class="hidden">
                
                @error('image')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-accent-blue rounded">
                    <span class="font-sans font-bold text-primary-primaryBlue">Set as Active Product</span>
                </label>
                <p class="text-sm font-sans text-gray mt-1 ml-8">Active products will be visible to customers</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray/20">
                <button type="submit"
                        class="px-8 py-3 bg-accent-blue text-white rounded-xl hover:bg-accent-blue/90 transition font-sans font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Product
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="px-8 py-3 bg-gray/20 text-gray rounded-xl hover:bg-gray/30 transition font-sans font-bold">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    
    if (file) {
        // Validate file size (1MB)
        if (file.size > 1 * 1024 * 1024) {
            alert('File size must be less than 1MB');
            event.target.value = '';
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            const img = preview.querySelector('img');
            
            img.src = e.target.result;
            preview.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        }
        
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    const preview = document.getElementById('imagePreview');
    const uploadArea = document.getElementById('uploadArea');
    const input = document.getElementById('imageInput');
    const img = preview.querySelector('img');
    
    img.src = '';
    input.value = '';
    preview.classList.add('hidden');
    uploadArea.classList.remove('hidden');
}
</script>

@endsection