<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('FEE_CATEGORIES', function (Blueprint $table) {
            $table->bigIncrements('ID_CATEGORY');
            $table->string('NAME', 128);
            $table->string('STATUS', 16)->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FEE_CATEGORIES');
    }
};
