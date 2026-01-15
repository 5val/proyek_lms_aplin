<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('PELAJARAN', 'STATUS')) {
            Schema::table('PELAJARAN', function (Blueprint $table) {
                $table->string('STATUS')->default('Active');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('PELAJARAN', 'STATUS')) {
            Schema::table('PELAJARAN', function (Blueprint $table) {
                $table->dropColumn('STATUS');
            });
        }
    }
};
