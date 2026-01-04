<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // Tetap kasih ini biar lo tau pesan ini dari user mana (kalau dia login)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->text('message');

            $table->softDeletes(); // Sesuai kesepakatan awal kita
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
