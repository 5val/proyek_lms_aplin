<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MATA_PELAJARAN', function (Blueprint $table) {
            $table->string('ID_MATA_PELAJARAN')->primary();
            $table->string('ID_GURU')->nullable();
            $table->string('ID_PELAJARAN');
            $table->string('ID_KELAS');
            $table->string('JAM_PELAJARAN')->nullable();
            $table->string('HARI_PELAJARAN')->nullable();

            $table->index('ID_GURU');
            $table->index('ID_PELAJARAN');
            $table->index('ID_KELAS');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MATA_PELAJARAN');
    }
};
