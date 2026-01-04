@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
    <div class="mb-4 text-center md:text-left">
        <h2 class="text-white text-3xl md:text-4xl font-bold">Sign Up</h2>
        <p class="text-white text-xs md:text-sm mt-1 opacity-90">Selamat Datang di Ketenangan yang hangat</p>
    </div>



    {{-- Spacing antar input dipersempit (space-y-3) --}}
    <form action="{{ route('register.post') }}" method="POST" class="space-y-3">
        @csrf

        {{-- Input field di-press padding-nya (py-2.5) --}}
        <div class="flex gap-3">
            <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}"
                class="w-full px-4 py-2.5 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">

            <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}"
                class="w-full px-4 py-2.5 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">
        </div>
        {{-- Error message diperkecil --}}
        @error('first_name') <p class="text-red-200 text-[10px] ml-2">{{ $message }}</p> @enderror

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
            class="w-full px-4 py-2.5 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">
        @error('email') <p class="text-red-200 text-[10px] ml-2">{{ $message }}</p> @enderror

        <input type="password" name="password" placeholder="Password"
            class="w-full px-4 py-2.5 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">
        @error('password') <p class="text-red-200 text-[10px] ml-2">{{ $message }}</p> @enderror

        <input type="password" name="password_confirmation" placeholder="Re Password"
            class="w-full px-4 py-2.5 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">
        @if ($errors->any())
            <div class="text-red-500 text-xs md:text-sm mt-1 opacity-90">
                {{ implode('', $errors->all(':message')) }}
            </div>
        @endif
        {{-- Margin top area aksi diperkecil (mt-6) dan padding tombol dikurangi --}}
        <div class="flex flex-col items-center gap-4 mt-6">
            <a href="{{ route('login') }}" class="text-white text-xs font-medium hover:underline">Sudah Punya Akun?
                Login</a>

            <button type="submit"
                class="bg-[#005a8d] text-white px-10 py-2.5 rounded-full text-base font-bold hover:scale-105 transition-transform shadow-lg w-full md:w-auto">
                Sign Up
            </button>
        </div>
    </form>

@endsection