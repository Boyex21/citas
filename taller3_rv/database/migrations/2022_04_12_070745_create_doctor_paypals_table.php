<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPaypalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_paypals', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->default(0);
            $table->integer('status')->default(0);
            $table->string('account_mode')->default('sandbox');
            $table->text('client_id')->nullable();
            $table->text('secret_id')->nullable();
            $table->string('country_code')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_rate')->default(1);
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
        Schema::dropIfExists('doctor_paypals');
    }
}
