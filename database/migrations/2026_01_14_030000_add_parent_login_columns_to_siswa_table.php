<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('SISWA', function (Blueprint $table) {
            $table->string('EMAIL_ORANGTUA')->nullable()->unique()->after('EMAIL_SISWA');
            $table->string('PASSWORD_ORANGTUA')->nullable()->after('PASSWORD_SISWA');
        });
    }

    public function down(): void
    {
        Schema::table('SISWA', function (Blueprint $table) {
            $table->dropColumn(['EMAIL_ORANGTUA', 'PASSWORD_ORANGTUA']);
        });
    }
};
