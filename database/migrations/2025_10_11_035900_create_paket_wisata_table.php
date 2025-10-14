<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paket_wisata', function (Blueprint $table) {
            $table->id();
            $table->json('title');       // {"id":"Judul ID", "en":"Title EN"}
            $table->json('description'); // {"id":"Deskripsi ID", "en":"Description EN"}
            $table->decimal('price', 12, 2);        // Harga per paket
            $table->integer('max_person');          // Maksimal orang
            $table->string('location')->nullable(); // Lokasi
            $table->string('duration')->nullable(); // Durasi, contoh "2D1N"
            $table->string('main_image')->nullable(); // Foto utama
            $table->json('gallery')->nullable();    // Array foto tambahan
            $table->json('fasilitas')->nullable();  // Array fasilitas
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_wisata');
    }
};
