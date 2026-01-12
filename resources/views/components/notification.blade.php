<!-- Floating Notification Component -->
@if(session('success') || session('error') || session('info'))
<div x-data="{ 
        show: true,
        message: '{{ session('success') ?? session('error') ?? session('info') }}',
        type: '{{ session('success') ? 'success' : (session('error') ? 'error' : 'info') }}'
     }"
     x-init="setTimeout(() => show = false, 5000)"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-24 right-4 z-50 max-w-sm w-full shadow-2xl rounded-xl overflow-hidden"
     style="display: none;">
    
    <div :class="{
        'bg-green-50 border-l-4 border-green-500': type === 'success',
        'bg-red-50 border-l-4 border-red-500': type === 'error',
        'bg-blue-50 border-l-4 border-blue-500': type === 'info'
    }" class="p-4 flex items-start gap-3">
        
        <!-- Icon -->
        <div class="flex-shrink-0">
            <!-- Success Icon -->
            <svg x-show="type === 'success'" class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <!-- Error Icon -->
            <svg x-show="type === 'error'" class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <!-- Info Icon -->
            <svg x-show="type === 'info'" class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <!-- Message -->
        <div class="flex-1">
            <p :class="{
                'text-green-800': type === 'success',
                'text-red-800': type === 'error',
                'text-blue-800': type === 'info'
            }" class="text-sm font-sans font-bold" x-text="message"></p>
        </div>
        
        <!-- Close Button -->
        <button @click="show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
@endif