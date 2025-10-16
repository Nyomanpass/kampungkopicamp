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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
                  $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('provider', 50)->default('midtrans');
            $table->string('order_id', 100)->unique();
            $table->string('payment_code_or_url', 255)->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('status', [
                'initiated',
                'pending',
                'settlement',
                'expire',
                'cancel',
                'refund'
            ])->default('initiated');
            $table->datetime('expired_at')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();

              $table->index('booking_id');
            $table->index('order_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
