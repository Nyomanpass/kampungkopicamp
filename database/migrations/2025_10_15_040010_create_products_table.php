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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->enum('type', ['accommodation', 'touring', 'area_rental']); // 👈 FIX: "accommodation"
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('capacity_per_unit')->nullable(); //for accomodation
            $table->integer('max_participant')->nullable(); //for touring
            $table->enum('duration_type', ['daily', 'hourly', 'multi_day'])->default('daily');
            $table->json('images')->nullable();
            $table->json('facilities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
