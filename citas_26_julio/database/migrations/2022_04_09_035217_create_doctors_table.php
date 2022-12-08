<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('location_id');
            $table->string('department_id');
            $table->text('about')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('image')->nullable();
            $table->string('forget_password_token')->nullable();
            $table->integer('status')->default(0);
            $table->integer('profile_fillup')->default(0);
            $table->timestamp('email_verified_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('doctors');
    }
}
