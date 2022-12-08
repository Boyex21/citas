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
            $table->enum('day', [1, 2, 3, 4, 5, 6, 7])->default(1);
            $table->date('date');
            $table->float('blood_pressure', 10, 2)->nullable()->unsigned();
            $table->float('pulse_rate', 10, 2)->nullable()->unsigned();
            $table->float('temperature', 10, 2)->nullable()->unsigned();
            $table->text('problem_description')->nullable();
            $table->enum('covid', [0, 1])->nullable();
            $table->enum('uci', [0, 1])->nullable();
            $table->date('covid_date')->nullable();
            $table->enum('covid_state', [1, 2])->nullable();
            $table->text('advice')->nullable();
            $table->text('test')->nullable();
            $table->integer('days')->nullable();
            $table->enum('time', [1, 2, 3])->nullable();
            $table->enum('type', [1, 2])->default(1);
            $table->enum('state', [0, 1, 2])->default(2);
            $table->bigInteger('specialty_id')->unsigned()->nullable();
            $table->bigInteger('schedule_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('doctor_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            #Relations
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
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
