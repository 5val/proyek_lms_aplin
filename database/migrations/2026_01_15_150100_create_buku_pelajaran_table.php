<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('BUKU_PELAJARAN', function (Blueprint $table) {
            $table->bigIncrements('ID_BUKU');
            $table->string('JUDUL');
            $table->text('DESKRIPSI')->nullable();
            $table->string('FILE_PATH');
            $table->unsignedBigInteger('FILE_SIZE');
            $table->string('FILE_EXT', 10);
            $table->string('MIME_TYPE', 100)->nullable();
            $table->string('KATEGORI')->nullable();
            $table->string('WATERMARK_TEXT')->nullable();
            $table->enum('STATUS', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('UPLOADED_BY')->nullable();
            $table->timestamps();

            $table->index('STATUS');
            $table->index('KATEGORI');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('BUKU_PELAJARAN');
    }
};
