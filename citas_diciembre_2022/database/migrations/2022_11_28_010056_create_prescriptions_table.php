<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->enum('dosage', [1, 2, 3, 4, 5, 6, 7, 8])->default(1);
            $table->integer('days')->default(1);
            $table->enum('time', [1, 2])->default(1);
            $table->string('comments')->nullable();
            $table->bigInteger('medicine_id')->unsigned()->nullable();
            $table->bigInteger('appointment_id')->unsigned()->nullable();
            $table->timestamps();

            #Relations
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('prescriptions');
    }
}
