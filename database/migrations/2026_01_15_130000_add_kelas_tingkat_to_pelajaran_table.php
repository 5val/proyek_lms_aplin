<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('PELAJARAN', 'KELAS_TINGKAT')) {
            Schema::table('PELAJARAN', function (Blueprint $table) {
                $table->string('KELAS_TINGKAT', 50)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('PELAJARAN', 'KELAS_TINGKAT')) {
            Schema::table('PELAJARAN', function (Blueprint $table) {
                $table->dropColumn('KELAS_TINGKAT');
            });
        }
    }
};
