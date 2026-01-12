@extends('admin.layouts.app')

@section('title', 'Add New User')
@section('page-title', 'Add New User')

@section('content')
<div class="max-w-4xl">

    <div class="bg-white rounded-2xl p-8">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('name') border-red-500 @enderror"
                       placeholder="Masukan nama lengkap">
                @error('name')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('email') border-red-500 @enderror"
                       placeholder="contoh@pengguna.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-4 border-2 border-gray/30 rounded-xl cursor-pointer hover:border-accent-blue transition has-[:checked]:border-accent-blue has-[:checked]:bg-accent-blue/5">
                        <input type="radio" 
                               name="role" 
                               value="user" 
                               {{ old('role', 'user') === 'user' ? 'checked' : '' }}
                               required
                               class="w-5 h-5 text-accent-blue">
                        <div>
                            <p class="font-sans font-bold text-black">Member / Customer</p>
                            <p class="text-xs font-sans text-gray mt-1">Pengguna biasa dengan akses umum</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 border-2 border-gray/30 rounded-xl cursor-pointer hover:border-accent-blue transition has-[:checked]:border-accent-blue has-[:checked]:bg-accent-blue/5">
                        <input type="radio" 
                               name="role" 
                               value="admin" 
                               {{ old('role') === 'admin' ? 'checked' : '' }}
                               required
                               class="w-5 h-5 text-accent-blue">
                        <div>
                            <p class="font-sans font-bold text-black">Administrator</p>
                            <p class="text-xs font-sans text-gray mt-1">Akses penuh ke admin panel</p>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                    Phone Number
                </label>
                <input type="tel" 
                       name="phone" 
                       value="{{ old('phone') }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('phone') border-red-500 @enderror"
                       placeholder="+62 812-3456-7890">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans @error('password') border-red-500 @enderror"
                           placeholder="Minimal 8 karakter">
                    <p class="text-xs font-sans text-gray mt-1">Minimal 8 karakter</p>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1 font-sans">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-sans font-bold text-primary-primaryBlue mb-2">
                        Konfirmasi password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           required
                           class="w-full px-4 py-3 rounded-xl border border-gray/30 focus:outline-none focus:ring-2 focus:ring-accent-blue font-sans"
                           placeholder="Masukan ulang password">
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-secondary rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-accent-blue flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-sans font-bold text-primary-primaryBlue text-sm">Catatan Penting</p>
                    <ul class="text-xs font-sans text-gray mt-1 space-y-1">
                        <li>• Penerima akan menerima login credentials yang dibuat</li>
                        <li>• Pastikan untuk beritahu user tentang akun yang dibuat</li>
                        <li>• Akun admin akan memiliki akses penuh ke ZENIRO Admin Panel</li>
                    </ul>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray/20">
                <button type="submit"
                        class="px-8 py-3 bg-accent-blue text-white rounded-xl hover:bg-accent-blue/90 transition font-sans font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Create User
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-8 py-3 bg-gray/20 text-gray rounded-xl hover:bg-gray/30 transition font-sans font-bold">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>
@endsection