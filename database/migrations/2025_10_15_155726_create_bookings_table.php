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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_token', 100)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('product_type', ['accommodation', 'touring', 'area_rental']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('people_count')->default(1);
            $table->integer(('unit_count'))->nullable();
            $table->integer('seat_count')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->enum('status', ['draft', 'pending_payment', 'paid', 'confirmed', 'checked_in', 'completed', 'expired', 'cancelled'])->default('draft');
            $table->string('customer_name', 150)->nullable();
            $table->string('customer_email', 150)->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->timestamps();

            $table->index('booking_token');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
