<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar kategori sesuai branding ZENIRO lo
        $categories = [
            [
                'name' => 'Dekorasi',
                'icon' => 'home',
            ],
            [
                'name' => 'Rumah Tangga',
                'icon' => 'archive',
            ],
            [
                'name' => 'Hobby',
                'icon' => 'gift',
            ],
            [
                'name' => 'Personal Room',
                'icon' => 'user',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']), // Otomatis handle spasi & huruf kecil
                'icon' => $category['icon'],
            ]);
        }
    }
}