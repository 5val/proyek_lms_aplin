<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('NILAI_KELAS', function (Blueprint $table) {
            $table->string('ID_NILAI')->primary();
            $table->string('ID_SISWA');
            $table->string('ID_MATA_PELAJARAN');
            $table->integer('NILAI_UTS')->nullable();
            $table->integer('NILAI_UAS')->nullable();
            $table->integer('NILAI_TUGAS')->nullable();
            $table->decimal('NILAI_AKHIR', 5, 2)->nullable();

            $table->index('ID_SISWA');
            $table->index('ID_MATA_PELAJARAN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('NILAI_KELAS');
    }
};
