<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('STUDENT_FEES', function (Blueprint $table) {
            $table->bigIncrements('ID_STUDENT_FEE');
            $table->string('ID_SISWA');
            $table->unsignedBigInteger('ID_PERIODE');
            $table->unsignedBigInteger('ID_COMPONENT');
            $table->decimal('AMOUNT', 12, 2);
            $table->date('DUE_DATE')->nullable();
            $table->string('STATUS', 16)->default('Unpaid');
            $table->string('INVOICE_CODE', 64)->unique();
            $table->string('MIDTRANS_ORDER_ID', 64)->nullable();
            $table->timestamps();

            $table->index(['ID_SISWA', 'ID_PERIODE'], 'student_fees_siswa_periode_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('STUDENT_FEES');
    }
};
