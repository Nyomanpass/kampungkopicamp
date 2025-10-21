<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->integer('discount_amount')->default(0); // Untuk percentage & fixed
            $table->json('bonus_details')->nullable(); // Untuk bonus type
            $table->timestamp('redeemed_at');
            $table->timestamps();

            // Constraint: 1 voucher per booking
            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voucher_redemptions');
    }
};