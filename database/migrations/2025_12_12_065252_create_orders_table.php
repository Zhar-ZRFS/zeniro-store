<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ID unik buat user (ZEN-xxx)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Null kalau guest
            $table->decimal('subtotal', 12, 2); // Harga asli
            $table->decimal('discount', 12, 2)->default(0); // Potongan harga
            $table->decimal('total_price', 12, 2); // Harga akhir (Gue saranin pake total_price biar jelas)
            $table->enum('status', ['pending', 'process', 'completed', 'cancelled'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};