<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('GURU', function (Blueprint $table) {
            if (! Schema::hasColumn('GURU', 'FOTO_GURU')) {
                $table->string('FOTO_GURU')->nullable()->after('NO_TELPON_GURU');
            }
        });

        Schema::table('SISWA', function (Blueprint $table) {
            if (! Schema::hasColumn('SISWA', 'FOTO_SISWA')) {
                $table->string('FOTO_SISWA')->nullable()->after('NO_TELPON_SISWA');
            }
        });

        if (Schema::hasColumn('GURU', 'STATUS_GURU')) {
            DB::table('GURU')->where('STATUS_GURU', 'Aktif')->update(['STATUS_GURU' => 'Active']);
            DB::statement("ALTER TABLE GURU MODIFY STATUS_GURU VARCHAR(255) DEFAULT 'Active'");
        }

        if (Schema::hasColumn('SISWA', 'STATUS_SISWA')) {
            DB::table('SISWA')->where('STATUS_SISWA', 'Aktif')->update(['STATUS_SISWA' => 'Active']);
            DB::statement("ALTER TABLE SISWA MODIFY STATUS_SISWA VARCHAR(255) DEFAULT 'Active'");
        }
    }

    public function down(): void
    {
        Schema::table('GURU', function (Blueprint $table) {
            if (Schema::hasColumn('GURU', 'FOTO_GURU')) {
                $table->dropColumn('FOTO_GURU');
            }
        });

        Schema::table('SISWA', function (Blueprint $table) {
            if (Schema::hasColumn('SISWA', 'FOTO_SISWA')) {
                $table->dropColumn('FOTO_SISWA');
            }
        });

        if (Schema::hasColumn('GURU', 'STATUS_GURU')) {
            DB::statement("ALTER TABLE GURU MODIFY STATUS_GURU VARCHAR(255) DEFAULT 'Aktif'");
        }

        if (Schema::hasColumn('SISWA', 'STATUS_SISWA')) {
            DB::statement("ALTER TABLE SISWA MODIFY STATUS_SISWA VARCHAR(255) DEFAULT 'Aktif'");
        }
    }
};
