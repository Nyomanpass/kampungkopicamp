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
            $table->enum('status', [
                'draft',
                'pending_payment',
                'paid',
                'checked_in',
                'completed',
                'cancelled',
                'refunded',
                'expired',
                'no_show'
            ])->default('draft')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', [
                'draft',
                'pending_payment',
                'paid',
                'checked_in',
                'completed',
                'cancelled',
                'refunded',
                'expired',
            ])->default('draft')->change();
        });
    }
};
