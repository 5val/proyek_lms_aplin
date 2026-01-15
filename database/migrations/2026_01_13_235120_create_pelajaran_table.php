<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('PELAJARAN', function (Blueprint $table) {
            $table->string('ID_PELAJARAN')->primary();
            $table->string('NAMA_PELAJARAN');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PELAJARAN');
    }
};
