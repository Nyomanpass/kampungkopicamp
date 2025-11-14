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
        Schema::table('availability', function (Blueprint $table) {
            $table->boolean('is_overridden')->default(false)->after('available_seat');
            $table->text('override_reason')->nullable()->after('is_overridden');
            $table->unsignedBigInteger('overridden_by')->nullable()->after('override_reason');
            $table->timestamp('overridden_at')->nullable()->after('overridden_by');

            $table->foreign('overridden_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['product_id', 'date', 'is_overridden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availability', function (Blueprint $table) {
            $table->dropForeign(['overridden_by']);
            $table->dropIndex(['product_id', 'date', 'is_overridden']);
            $table->dropColumn(['is_overridden', 'override_reason', 'overridden_by', 'overridden_at']);
        });
    }
};
