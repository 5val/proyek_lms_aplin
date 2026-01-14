<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('FEE_COMPONENTS', function (Blueprint $table) {
            $table->string('TYPE', 16)->default('Wajib')->after('AMOUNT_DEFAULT');
            $table->unsignedBigInteger('ID_CATEGORY')->nullable()->after('TYPE');
            $table->foreign('ID_CATEGORY')->references('ID_CATEGORY')->on('FEE_CATEGORIES')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('FEE_COMPONENTS', function (Blueprint $table) {
            $table->dropForeign(['ID_CATEGORY']);
            $table->dropColumn(['TYPE', 'ID_CATEGORY']);
        });
    }
};
