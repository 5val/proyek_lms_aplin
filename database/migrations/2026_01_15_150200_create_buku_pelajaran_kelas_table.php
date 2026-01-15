<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('BUKU_PELAJARAN_KELAS', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->unsignedBigInteger('ID_BUKU');
            $table->string('ID_KELAS');
            $table->timestamps();

            $table->unique(['ID_BUKU', 'ID_KELAS']);
            $table->foreign('ID_BUKU')->references('ID_BUKU')->on('BUKU_PELAJARAN')->onDelete('cascade');
            $table->foreign('ID_KELAS')->references('ID_KELAS')->on('KELAS')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('BUKU_PELAJARAN_KELAS');
    }
};
