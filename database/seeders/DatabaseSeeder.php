<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. WAJIB: Panggil Role Seeder dulu biar User Admin lo punya power!
        $this->call([
            UserSeeder::class, // 1. Role & User Admin
            CategorySeeder::class,       // 2. Kategori
            ProductSeeder::class,        // 3. Produk (Butuh kategori)
        ]);

        // 2. Kategori Versi Clean (Pake Array + Wadah)


        // 3. Produk Dummy
        // Sekarang lo panggilnya lewat wadah $cats['NamaKategori']



        // [SISA PRODUK LO LANJUTIN PAKE FORMAT $cats['NamaKategori']->id]
    }
}