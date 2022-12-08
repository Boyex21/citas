<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->integer('appointment_order_id');
            $table->integer('user_id');
            $table->integer('day_id');
            $table->integer('schedule_id');
            $table->integer('chamber_id');
            $table->date('date');
            $table->double('fee');
            $table->string('blood_pressure')->nullable();
            $table->string('pulse_rate')->nullable();
            $table->string('temperature')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('advice')->nullable();
            $table->text('test')->nullable();
            $table->tinyInteger('already_treated')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
