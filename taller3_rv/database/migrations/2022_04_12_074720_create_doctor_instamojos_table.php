<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorInstamojosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_instamojos', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->default(0);
            $table->text('api_key');
            $table->text('auth_token');
            $table->string('currency_rate')->default(1);
            $table->string('account_mode')->default('Sandbox');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('doctor_instamojos');
    }
}
