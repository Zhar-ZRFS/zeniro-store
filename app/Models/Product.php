<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import trait ini

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock'=> 'integer',
        'is_active' => 'boolean'
    ];

    protected $guarded = ['id'];

    // RELASI MANY-TO-MANY
    // "Satu produk bisa masuk ke BANYAK kategori"
    // Perhatikan: Nama fungsinya jamak 'categories', bukan 'category'
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    use SoftDeletes; // 2. Gunakan trait ini di dalam class

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    protected $dates = ['deleted_at']; // 3. Daftarkan kolomnya (opsional di Laravel versi terbaru, tapi bagus buat kejelasan)
}