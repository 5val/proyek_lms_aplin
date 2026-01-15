<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('SISWA', function (Blueprint $table) {
            $table->string('ID_SISWA')->primary();
            $table->string('NAMA_SISWA');
            $table->string('EMAIL_SISWA')->unique();
            $table->string('PASSWORD_SISWA');
            $table->string('EMAIL_ORANGTUA')->nullable()->unique();
            $table->string('PASSWORD_ORANGTUA')->nullable();
            $table->string('ALAMAT_SISWA')->nullable();
            $table->string('NO_TELPON_SISWA')->nullable();
            $table->string('FOTO_SISWA')->nullable();
            $table->string('STATUS_SISWA')->default('Active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SISWA');
    }
};
