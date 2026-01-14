<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            if (! Schema::hasColumn('attendance', 'STATUS')) {
                $table->string('STATUS', 16)->default('Hadir')->after('ID_PERTEMUAN');
            }
        });

        $duplicates = DB::table('attendance')
            ->select('ID_SISWA', 'ID_PERTEMUAN', DB::raw('MIN(ID_ATTENDANCE) as keep_id'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('ID_SISWA', 'ID_PERTEMUAN')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('attendance')
                ->where('ID_SISWA', $dup->ID_SISWA)
                ->where('ID_PERTEMUAN', $dup->ID_PERTEMUAN)
                ->where('ID_ATTENDANCE', '<>', $dup->keep_id)
                ->delete();
        }

        Schema::table('attendance', function (Blueprint $table) {
            $table->unique(['ID_SISWA', 'ID_PERTEMUAN'], 'attendance_siswa_pertemuan_unique');
        });
    }

    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            if (Schema::hasColumn('attendance', 'STATUS')) {
                $table->dropColumn('STATUS');
            }
            $table->dropUnique('attendance_siswa_pertemuan_unique');
        });
    }
};
