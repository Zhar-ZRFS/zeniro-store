@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="mb-6 text-center md:text-left">
        <h2 class="text-white text-3xl md:text-4xl font-bold">Login</h2>
        <p class="text-white text-xs md:text-sm mt-1 opacity-90">Selamat Datang di Ketenangan yang hangat</p>
    </div>

    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                class="w-full px-4 py-3 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">
            @error('email') <p class="text-red-200 text-[10px] ml-2 mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div>
            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-3 rounded-2xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-300 transition text-sm">
            @error('password') <p class="text-red-200 text-[10px] ml-2 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-between items-center px-2">
            <a href="{{ route('register') }}" class="text-white text-xs font-medium hover:underline tracking-tight">Tidak punya akun? Sign Up</a>
            <a href="{{ route('home') }}" class="text-white text-xs font-medium hover:underline tracking-tight">Visit without Login</a>
        </div>

        <div class="flex justify-center mt-8">
            <button type="submit" class="bg-[#005a8d] text-white px-12 py-3 rounded-full text-base font-bold hover:scale-105 transition-transform shadow-lg w-full md:w-auto">
                Login
            </button>
        </div>
    </form>
@endsection