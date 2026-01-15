<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MATERI', function (Blueprint $table) {
            $table->string('ID_MATERI')->primary();
            $table->string('ID_MATA_PELAJARAN');
            $table->string('NAMA_MATERI');
            $table->text('DESKRIPSI_MATERI')->nullable();
            $table->string('FILE_MATERI')->nullable();

            $table->index('ID_MATA_PELAJARAN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MATERI');
    }
};
