<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('GURU', function (Blueprint $table) {
            $table->string('ID_GURU')->primary();
            $table->string('NAMA_GURU');
            $table->string('EMAIL_GURU')->unique();
            $table->string('PASSWORD_GURU');
            $table->string('ALAMAT_GURU')->nullable();
            $table->string('NO_TELPON_GURU')->nullable();
            $table->string('FOTO_GURU')->nullable();
            $table->string('STATUS_GURU')->default('Active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('GURU');
    }
};
