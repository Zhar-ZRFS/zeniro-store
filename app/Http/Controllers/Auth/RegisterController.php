<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function register(Request $request) 
{
    // 1. Ubah validasinya biar nyari first_name & last_name
    $request->validate([
        'first_name' => 'required|string|max:100',
        // 'last_name' => 'string|max:100',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // 2. Gabungin jadi satu di sini buat masuk ke kolom 'name' di DB
    $user = User::create([
        'name' => $request->first_name . ' ' . $request->last_name, 
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', 'Registrasi Berhasil!, Silahkan Login');
}
}