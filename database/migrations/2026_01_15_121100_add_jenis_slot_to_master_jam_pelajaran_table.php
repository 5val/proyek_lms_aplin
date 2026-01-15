<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('MASTER_JAM_PELAJARAN', 'JENIS_SLOT')) {
            Schema::table('MASTER_JAM_PELAJARAN', function (Blueprint $table) {
                $table->enum('JENIS_SLOT', ['Pelajaran', 'Istirahat'])->default('Pelajaran')->after('SLOT_KE');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('MASTER_JAM_PELAJARAN', 'JENIS_SLOT')) {
            Schema::table('MASTER_JAM_PELAJARAN', function (Blueprint $table) {
                $table->dropColumn('JENIS_SLOT');
            });
        }
    }
};
