<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('SUBMISSION_TUGAS', function (Blueprint $table) {
            $table->string('ID_SUBMISSION')->primary();
            $table->string('ID_TUGAS');
            $table->string('ID_SISWA');
            $table->text('JAWABAN')->nullable();
            $table->decimal('NILAI_TUGAS', 5, 2)->nullable();
            $table->timestamp('SUBMITTED_AT')->useCurrent();
            $table->timestamp('TANGGAL_SUBMISSION')->nullable();

            $table->index('ID_TUGAS');
            $table->index('ID_SISWA');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SUBMISSION_TUGAS');
    }
};
