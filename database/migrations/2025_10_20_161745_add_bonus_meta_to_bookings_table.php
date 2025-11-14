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
            $table->json('bonus_meta')->nullable()->after('customer_phone');
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->nullOnDelete()->after('bonus_meta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('voucher_id');
            $table->dropColumn(['bonus_meta', 'voucher_id']);
        });
    }
};
