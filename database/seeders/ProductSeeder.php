<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tarik semua kategori ke koleksi biar bisa dicari berdasarkan nama
        // Ini biar lo nggak perlu ngetik ID manual.
        $cats = Category::all()->keyBy('name');

        // 2. Daftar Produk Dummy
        
        // Produk 1
        $p1 = Product::create([
            'name' => 'Rak Putih',
            'slug' => Str::slug('Rak Putih'),
            'description' => 'Rak Mini, Minimalis untuk menaruh barang dan hiasan kamar anda',
            'price' => 99099,
            'stock' => 20,
            'image' => 'furniture/personal-room/rak-putih.jpeg',
        ]);
        $p1->categories()->attach([$cats['Dekorasi']->id, $cats['Personal Room']->id]);

        // Produk 2
        $p2 = Product::create([
            'name' => 'Meja Kayu',
            'slug' => Str::slug('Meja Kayu'),
            'description' => 'Meja kayu sederhana, untuk gaya minimalis ruang tamu anda',
            'price' => 249099,
            'stock' => 14,
            'image' => 'furniture/rumah-tangga/meja-kayu.jpeg'
        ]);
        $p2->categories()->attach([$cats['Rumah Tangga']->id]);

        // Produk 3
        $p3 = Product::create([
            'name' => 'Lampu Belajar',
            'slug' => Str::slug('Lampu Belajar'),
            'description' => 'Lampu yang menyinarkan kehangatan, bagi keluarga, kamar dan waktu belajar anda.',
            'price' => 128099,
            'stock' => 18,
            'image' => 'furniture/personal-room/study-light.jpeg',
        ]);
        $p3->categories()->attach([$cats['Dekorasi']->id, $cats['Hobby']->id, $cats['Personal Room']->id]);

        // Produk 4
        $p4 = Product::create([
            'name' => 'Pot Alam',
            'slug' => Str::slug('Pot Alam'),
            'description' => 'Tempat menyimpan tanaman hijau, untuk hiasan ruang tamu anda.',
            'price' => 228099,
            'stock' => 8,
            'image' => 'furniture/dekorasi/pot-alam.jpeg',
        ]);
        $p4->categories()->attach([$cats['Dekorasi']->id]);

        // Produk 5 (Pot Kaca)
        $p5a = Product::create([
            'name' => 'Pot Kaca',
            'slug' => Str::slug('Pot Kaca'),
            'description' => 'Penyimpanan bunga yang indah, menampilkan kealamian tanaman anda.',
            'price' => 109999,
            'stock' => 9,
            'image' => 'furniture/dekorasi/pot-bening.jpeg',
        ]);
        $p5a->categories()->attach([$cats['Dekorasi']->id]);

        // Produk 6 (Pot Mini)
        $p5b = Product::create([
            'name' => 'Pot Mini',
            'slug' => Str::slug('Pot Mini'),
            'description' => 'Hiasi ruang tamu anda dengan tanaman sederhana.',
            'price' => 99789,
            'stock' => 8,
            'image' => 'furniture/dekorasi/pot-mini.jpeg',
        ]);
        $p5b->categories()->attach([$cats['Dekorasi']->id]);

        // Produk 7
        $p6 = Product::create([
            'name' => 'Rak Buku Kayu',
            'slug' => Str::slug('Rak Buku Kayu'),
            'description' => 'Tempat penyimpanan barang yang hemat tempat.',
            'price' => 99789,
            'stock' => 8,
            'image' => 'furniture/dekorasi/rak-dekorasi.jpeg',
        ]);
        $p6->categories()->attach([$cats['Dekorasi']->id, $cats['Personal Room']->id, $cats['Rumah Tangga']->id]);

        // Produk 8
        $p7 = Product::create([
            'name' => 'Baju Rajut',
            'slug' => Str::slug('Baju Rajut'),
            'description' => 'Pakaian hasil tangan, ikatan benang yang saling menguatkan.',
            'price' => 104099,
            'stock' => 2,
            'image' => 'furniture/hobby/baju-rajut.jpeg',
        ]);
        $p7->categories()->attach([$cats['Hobby']->id]);

        // Produk 9
        $p8 = Product::create([
            'name' => 'Rak Buku',
            'slug' => Str::slug('Rak Buku'),
            'description' => 'Tempat untuk menyimpan apa yang anda sukai.',
            'price' => 246499,
            'stock' => 45,
            'image' => 'furniture/hobby/book-shelf.jpeg',
        ]);
        $p8->categories()->attach([$cats['Hobby']->id, $cats['Personal Room']->id, $cats['Dekorasi']->id]);

        // Produk 10
        $p9 = Product::create([
            'name' => 'Penahan Buku',
            'slug' => Str::slug('Penahan Buku'),
            'description' => 'Amankan bukumu, amankan juga semua cerita didalamnya.',
            'price' => 38499,
            'stock' => 70,
            'image' => 'furniture/hobby/penahan-buku.jpeg',
        ]);
        $p9->categories()->attach([$cats['Hobby']->id, $cats['Personal Room']->id, $cats['Dekorasi']->id]);

        // Produk 11
        $p10 = Product::create([
            'name' => 'Rajutan Set',
            'slug' => Str::slug('Rajutan'),
            'description' => 'Rajut kembali gulungan benang dengan warna beragam.',
            'price' => 98499,
            'stock' => 89,
            'image' => 'furniture/hobby/set-rajutan.jpeg',
        ]);
        $p10->categories()->attach([$cats['Hobby']->id]);

        // Produk 12
        $p11 = Product::create([
            'name' => 'Kursi Jati',
            'slug' => Str::slug('Kursi Jati'),
            'description' => 'Seperti pohon jati dengan kualitas tinggi, tahan banting.',
            'price' => 78499,
            'stock' => 89,
            'image' => 'furniture/personal-room/kursi-kayu.jpeg',
        ]);
        $p11->categories()->attach([$cats['Personal Room']->id, $cats['Rumah Tangga']->id]);

        // Produk 13
        $p12 = Product::create([
            'name' => 'Set Meja',
            'slug' => Str::slug('Set Meja'),
            'description' => 'Satu set tempat kerja, belajar dilengkapi kursi putih.',
            'price' => 298499,
            'stock' => 8,
            'image' => 'furniture/personal-room/set-meja.jpeg',
        ]);
        $p12->categories()->attach([$cats['Personal Room']->id, $cats['Hobby']->id]);

        // Produk 14
        $p13 = Product::create([
            'name' => 'Set Gelas',
            'slug' => Str::slug('Gelas'),
            'description' => 'Set Gelas model keramik, menampung segala macam air.',
            'price' => 149069,
            'stock' => 14,
            'image' => 'furniture/rumah-tangga/gelas-putih.jpeg'
        ]);
        $p13->categories()->attach([$cats['Rumah Tangga']->id, $cats['Dekorasi']->id]);

        // Produk 15
        $p14 = Product::create([
            'name' => 'Set Mangkok',
            'slug' => Str::slug('Mangkok'),
            'description' => 'Menyimpan segala jenis makanan, ideal sebagai tempat penyimpanan.',
            'price' => 109069,
            'stock' => 19,
            'image' => 'furniture/rumah-tangga/mangkok-bercorak.jpeg'
        ]);
        $p14->categories()->attach([$cats['Rumah Tangga']->id, $cats['Dekorasi']->id]);
    }
}