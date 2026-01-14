<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('STUDENT_STATUS_HISTORY', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('ID_SISWA');
            $table->string('STATUS', 32);
            $table->string('REASON', 255)->nullable();
            $table->date('EFFECTIVE_DATE')->nullable();
            $table->string('CHANGED_BY', 64)->nullable();
            $table->timestamps();

            $table->index('ID_SISWA', 'ssh_id_siswa_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('STUDENT_STATUS_HISTORY');
    }
};
