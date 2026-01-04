<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product; // Kalau nanti mau nampilin produk asli
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil data Kategori buat Navbar
        $categories = Category::all(); 

        // 2. Kirim data itu ke View (Layout butuh $categories)
        return view('home', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000'
        ], [
            'first_name.required' => 'Nama depan wajib diisi',
            'last_name.required' => 'Nama belakang wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'message.required' => 'Pesan wajib diisi'
        ]);

        // Tambahkan user_id jika user sudah login
        $validated['user_id'] = Auth::check() ? Auth::id() : null;

        Contact::create($validated);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
}