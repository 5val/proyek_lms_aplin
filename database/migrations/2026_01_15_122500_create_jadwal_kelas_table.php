<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('JADWAL_KELAS', function (Blueprint $table) {
            $table->bigIncrements('ID_JADWAL');
            $table->string('ID_KELAS');
            $table->string('ID_MATA_PELAJARAN')->nullable();
            $table->unsignedBigInteger('ID_JAM_PELAJARAN');
            $table->string('ID_RUANGAN')->nullable();
            $table->timestamps();

            $table->unique(['ID_KELAS', 'ID_JAM_PELAJARAN'], 'kelas_slot_unique');
            $table->index('ID_MATA_PELAJARAN');
            $table->index('ID_RUANGAN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('JADWAL_KELAS');
    }
};
