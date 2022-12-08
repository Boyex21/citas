<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentSymptomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_symptom', function (Blueprint $table) {
            $table->id();
            $table->enum('symptom', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->default(1);
            $table->bigInteger('appointment_id')->unsigned()->nullable();
            $table->timestamps();

            #Relations
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_symptom');
    }
}
