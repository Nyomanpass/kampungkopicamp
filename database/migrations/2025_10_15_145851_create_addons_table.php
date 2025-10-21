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
            $table->boolean('has_iventory')->default(false);
            $table->boolean('is_active')->default(true);
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
