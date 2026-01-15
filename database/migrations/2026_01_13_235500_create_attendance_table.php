<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('ID_ATTENDANCE');
            $table->string('ID_SISWA');
            $table->string('ID_PERTEMUAN');
            $table->string('STATUS', 16)->default('Hadir');
            $table->unique(['ID_SISWA', 'ID_PERTEMUAN'], 'attendance_siswa_pertemuan_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
