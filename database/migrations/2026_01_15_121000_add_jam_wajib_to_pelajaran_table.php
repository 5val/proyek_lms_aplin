<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('PELAJARAN', 'JML_JAM_WAJIB')) {
            Schema::table('PELAJARAN', function (Blueprint $table) {
                $table->unsignedTinyInteger('JML_JAM_WAJIB')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('PELAJARAN', 'JML_JAM_WAJIB')) {
            Schema::table('PELAJARAN', function (Blueprint $table) {
                $table->dropColumn('JML_JAM_WAJIB');
            });
        }
    }
};
