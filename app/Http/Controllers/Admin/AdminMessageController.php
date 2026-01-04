<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = Contact::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Contact::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'full_name' => $message->full_name,
                'email' => $message->email,
                'message' => $message->message,
                'date' => $message->created_at->format('d M Y'),
                'time' => $message->created_at->format('H:i'),
                'is_user' => $message->user_id !== null, // Cek apakah dia registered

                'user_data' => $message->user ? [
                    'name' => $message->user->name,
                    'email' => $message->user->email,
                    'role' => $message->user->role ?? 'User', // Opsional
                    ] : null,
            ]
        ]);
    }

    public function destroy($id) // Ubah jadi $id biar aman, kita cari manual.
    {
        // 1. Cari Manual (Lebih aman buat debugging)
        $message = Contact::find($id);

        // 2. Cek Ketemu Gak?
        if (!$message) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        // 3. Eksekusi Hapus (Soft Delete kalau Model udah disetting)
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message berhasil dihapus!');
    }
}