<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->double('price');
            $table->integer('expiration_day')->default(0);
            $table->integer('online_consulting')->default(0);
            $table->integer('message_system')->default(0);
            $table->integer('daily_appointment_qty')->default(0);
            $table->integer('online_prescription')->default(0);
            $table->integer('review_system')->default(0);
            $table->integer('maximum_staff')->default(0);
            $table->integer('maximum_image')->default(0);
            $table->integer('maximum_video')->default(0);
            $table->integer('maximum_chamber')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('packages');
    }
}
