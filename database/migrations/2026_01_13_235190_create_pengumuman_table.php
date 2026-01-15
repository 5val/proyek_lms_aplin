<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('PENGUMUMAN', function (Blueprint $table) {
            $table->bigIncrements('ID_PENGUMUMAN');
            $table->string('JUDUL');
            $table->text('ISI');
            $table->timestamp('TANGGAL')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PENGUMUMAN');
    }
};
