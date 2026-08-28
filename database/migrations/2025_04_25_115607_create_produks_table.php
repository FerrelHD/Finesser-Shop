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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama produk
            $table->text('description')->nullable(); // Deskripsi produk
            $table->string('file_path'); // Path file utama
            $table->string('file_type'); // Jenis file (contoh: psd, ai, mp4)
            $table->string('preview_image')->nullable(); // Gambar pratinjau
            $table->decimal('price', 10, 2); // Harga produk
            $table->json('editable_layers')->nullable(); // Informasi layer yang bisa diedit
            $table->string('tags')->nullable(); // Tag produk, bisa dipisah koma
            $table->enum('license_type', ['free', 'personal', 'commercial'])->default('personal'); // Tipe lisensi
            $table->boolean('is_active')->default(true); // Status aktif atau tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
