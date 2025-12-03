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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'default_units')) {
                $table->integer('default_units')->default(10)->after('duration_type');
            }
            if (!Schema::hasColumn('products', 'default_seats')) {
                $table->integer('default_seats')->default(20)->after('default_units');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'default_units')) {
                $table->dropColumn('default_units');
            }
            if (Schema::hasColumn('products', 'default_seats')) {
                $table->dropColumn('default_seats');
            }
        });
    }
};
