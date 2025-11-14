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
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('pricing_type', [
                'per_booking',
                'per_unit_per_night',
                'per_person',
                'per_hour',
                'per_slot'
            ]);
            $table->decimal('price', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            // ✅ Fix typo: has_iventory → has_inventory
            $table->boolean('has_inventory')->default(false);

            // ✅ Inventory management fields
            $table->integer('stock_quantity')->nullable();
            $table->integer('low_stock_threshold')->default(5);

            // ✅ Quantity limits
            $table->integer('min_quantity')->default(1);
            $table->integer('max_quantity')->nullable();

            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};
