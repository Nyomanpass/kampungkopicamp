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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('parent_invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->enum('type', ['primary', 'addon_onsite'])->default('primary');
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('status', ['draft', 'pending', 'paid', 'void', 'refunded'])->default('draft');
            $table->timestamps();

            $table->index('booking_id');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
