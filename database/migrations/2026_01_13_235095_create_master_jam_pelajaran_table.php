<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MASTER_JAM_PELAJARAN', function (Blueprint $table) {
            $table->bigIncrements('ID_JAM_PELAJARAN');
            $table->string('HARI_PELAJARAN');
            $table->unsignedTinyInteger('SLOT_KE');
            $table->enum('JENIS_SLOT', ['Pelajaran', 'Istirahat'])->default('Pelajaran');
            $table->time('JAM_MULAI');
            $table->time('JAM_SELESAI');
            $table->string('LABEL')->nullable();
            $table->unique(['HARI_PELAJARAN', 'SLOT_KE'], 'master_jam_hari_slot_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MASTER_JAM_PELAJARAN');
    }
};
