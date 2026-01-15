<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('PERTEMUAN', function (Blueprint $table) {
            $table->string('ID_PERTEMUAN')->primary();
            $table->string('ID_MATA_PELAJARAN');
            $table->text('DETAIL_PERTEMUAN')->nullable();
            $table->date('TANGGAL_PERTEMUAN')->nullable();

            $table->index('ID_MATA_PELAJARAN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PERTEMUAN');
    }
};
