<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('PAYMENTS', function (Blueprint $table) {
            $table->bigIncrements('ID_PAYMENT');
            $table->unsignedBigInteger('ID_STUDENT_FEE');
            $table->decimal('PAID_AMOUNT', 12, 2);
            $table->dateTime('PAID_AT')->nullable();
            $table->string('METHOD', 32)->nullable();
            $table->string('MIDTRANS_TXN_ID', 64)->nullable();
            $table->string('STATUS', 16)->default('Pending');
            $table->json('RAW_PAYLOAD')->nullable();
            $table->timestamps();

            $table->index('ID_STUDENT_FEE', 'payments_student_fee_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PAYMENTS');
    }
};
