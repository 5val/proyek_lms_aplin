<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ENROLLMENT_KELAS', function (Blueprint $table) {
            $table->string('ID_SISWA');
            $table->string('ID_KELAS');
            $table->primary(['ID_SISWA', 'ID_KELAS']);
            $table->index('ID_KELAS');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ENROLLMENT_KELAS');
    }
};
