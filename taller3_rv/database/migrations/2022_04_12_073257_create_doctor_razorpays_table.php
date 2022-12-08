<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorRazorpaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_razorpays', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->default(0);
            $table->integer('status')->default(0);
            $table->double('currency_rate')->default(1);
            $table->string('country_code')->nullable();
            $table->string('currency_code')->nullable();
            $table->text('key')->nullable();
            $table->text('secret_key')->nullable();
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
        Schema::dropIfExists('doctor_razorpays');
    }
}
