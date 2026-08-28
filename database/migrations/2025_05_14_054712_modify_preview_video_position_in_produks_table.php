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
        Schema::table('produks', function (Blueprint $table) {
            // Ubah urutan kolom preview_video agar setelah preview_image_3
            $table->string('preview_video')->nullable()->after('preview_image_3')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Kembalikan kolom ke urutan default (jika rollback)
            $table->string('preview_video')->nullable()->change();
        });
    }
};