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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_source')->default('online')->after('status'); // online/walk-in
            $table->string('payment_method')->nullable()->after('booking_source'); // cash/transfer/edc/other
            $table->text('payment_notes')->nullable()->after('payment_method');
            $table->text('status_notes')->nullable()->after('payment_notes'); // untuk notes saat change status
            $table->json('addon_history')->nullable()->after('status_notes'); // untuk track addon changes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_source', 'payment_method', 'payment_notes', 'status_notes', 'addon_history']);
        });
    }
};
