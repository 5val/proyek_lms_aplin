<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('KELAS', function (Blueprint $table) {
            $table->string('ID_KELAS')->primary();
            $table->unsignedBigInteger('ID_DETAIL_KELAS')->nullable();
            $table->string('ID_GURU')->nullable();
            $table->string('ID_PERIODE')->nullable();
            $table->integer('KAPASITAS')->default(0);

            $table->index('ID_DETAIL_KELAS');
            $table->index('ID_GURU');
            $table->index('ID_PERIODE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('KELAS');
    }
};
