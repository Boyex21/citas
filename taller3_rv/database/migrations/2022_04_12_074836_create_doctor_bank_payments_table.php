<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorBankPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_bank_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->default(0);
            $table->integer('status')->default(0);
            $table->text('account_info')->nullable();
            $table->text('hand_cash_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_bank_payments');
    }
}
