@extends('admin.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-4xl">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl p-8 text-center">
            <div class="w-24 h-24 bg-primary-primaryPink rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl font-heading font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            <h3 class="text-xl font-heading font-bold text-primary-primaryBlue mb-1">{{ $user->name }}</h3>
            <p class="font-sans text-gray mb-4">{{ $user->email }}</p>
            <span class="inline-block px-4 py-2 bg-accent-blue text-white rounded-full text-sm font-sans font-bold">
                Administrator
            </span>

            <!-- Additional Info -->
            <div class="mt-6 pt-6 border-t border-gray/20">
                <div class="space-y-3 text-left">
                    <div class="flex items-center gap-3 text-sm">
                        <svg class="w-5 h-5 text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="font-sans text-gray">Joined</p>
                            <p class="font-sans font-bold text-black">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @if($user->phone)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-5 h-5 text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <p class="font-sans text-gray">Phone</p>
                                <p class="font-sans font-bold text-black">{{ $user->phone }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-8">
            <h3 class="text-xl font-heading font-bold text-primary-primaryBlue mb-6">Edit Profile</h3>
            
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Email</label>
                    <input type="email" 
                           value="{{ $user->email }}" 
                           disabled
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 bg-secondary/50 cursor-not-allowed font-sans">
                    <p class="text-xs font-sans text-gray mt-1">Email cannot be changed</p>
                </div>

                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">Phone</label>
                    <input type="tel" 
                           name="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="+62 812-3456-7890"
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="px-8 py-3 bg-accent-blue text-white rounded-xl hover:bg-accent-blue/90 transition font-sans font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Change Password -->
    <div class="bg-white rounded-2xl p-8 mt-6">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <h3 class="text-xl font-heading font-bold text-primary-primaryBlue">Change Password</h3>
        </div>
        
        <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4 max-w-2xl">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       name="current_password" 
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('current_password') border-red-500 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    New Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       name="password" 
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('password') border-red-500 @enderror">
                <p class="text-xs font-sans text-gray mt-1">Minimum 8 characters</p>
                @error('password')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       name="password_confirmation" 
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans">
            </div>

            <div class="pt-4 flex items-center gap-4">
                <button type="submit" 
                        class="px-8 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition font-sans font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Change Password
                </button>
                <p class="text-sm font-sans text-gray">
                    You will need to login again after changing password
                </p>
            </div>
        </form>
    </div>

</div>
@endsection