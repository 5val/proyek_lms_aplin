<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('FEE_COMPONENTS', function (Blueprint $table) {
            $table->bigIncrements('ID_COMPONENT');
            $table->string('NAME', 128);
            $table->decimal('AMOUNT_DEFAULT', 12, 2)->default(0);
            $table->string('DESCRIPTION', 255)->nullable();
            $table->string('STATUS', 16)->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FEE_COMPONENTS');
    }
};
