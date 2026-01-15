<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('KELAS', function (Blueprint $table) {
            if (! Schema::hasColumn('KELAS', 'KAPASITAS')) {
                $table->integer('KAPASITAS')->default(0)->after('ID_PERIODE');
            }
        });
    }

    public function down(): void
    {
        Schema::table('KELAS', function (Blueprint $table) {
            if (Schema::hasColumn('KELAS', 'KAPASITAS')) {
                $table->dropColumn('KAPASITAS');
            }
        });
    }
};
