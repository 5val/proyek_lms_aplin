<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('DETAIL_KELAS');

        Schema::create('DETAIL_KELAS', function (Blueprint $table) {
            $table->bigIncrements('ID_DETAIL_KELAS');
            $table->string('KODE_RUANGAN')->unique();
            $table->string('RUANGAN_KELAS');
            $table->string('NAMA_KELAS');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('DETAIL_KELAS');

        Schema::create('DETAIL_KELAS', function (Blueprint $table) {
            $table->string('ID_DETAIL_KELAS')->primary();
            $table->string('RUANGAN_KELAS');
            $table->string('NAMA_KELAS');
        });

        Schema::enableForeignKeyConstraints();
    }
};
