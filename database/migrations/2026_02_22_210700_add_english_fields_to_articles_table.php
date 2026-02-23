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
        Schema::table('articles', function (Blueprint $table) {

            // Tambah versi English
            $table->string('title_en')->nullable()->after('title');
            $table->text('excerpt_en')->nullable()->after('excerpt');
            $table->longText('content_en')->nullable()->after('content');
            $table->text('meta_description_en')->nullable()->after('meta_description');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->dropColumn([
                'title_en',
                'excerpt_en',
                'content_en',
                'meta_description_en'
            ]);

        });
    }
};
