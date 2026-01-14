<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('FEE_COMPONENTS', function (Blueprint $table) {
            $table->boolean('AUTO_BILL')->default(false)->after('STATUS');
        });
    }

    public function down(): void
    {
        Schema::table('FEE_COMPONENTS', function (Blueprint $table) {
            $table->dropColumn('AUTO_BILL');
        });
    }
};
