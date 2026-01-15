<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('KELAS', 'NAMA_KELAS')) {
            Schema::table('KELAS', function (Blueprint $table) {
                $table->string('NAMA_KELAS', 100)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('KELAS', 'NAMA_KELAS')) {
            Schema::table('KELAS', function (Blueprint $table) {
                $table->dropColumn('NAMA_KELAS');
            });
        }
    }
};
