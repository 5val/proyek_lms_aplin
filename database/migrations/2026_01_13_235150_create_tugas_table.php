<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('TUGAS', function (Blueprint $table) {
            $table->string('ID_TUGAS')->primary();
            $table->string('ID_MATA_PELAJARAN');
            $table->string('NAMA_TUGAS');
            $table->text('DESKRIPSI_TUGAS')->nullable();
            $table->dateTime('DEADLINE_TUGAS')->nullable();

            $table->index('ID_MATA_PELAJARAN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TUGAS');
    }
};
