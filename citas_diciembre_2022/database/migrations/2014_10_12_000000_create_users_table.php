<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('photo')->default('usuario.png');
            $table->string('slug')->unique();
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', [1, 2, 3])->nullable();
            $table->date('birthday')->nullable();
            $table->float('weight', 10, 2)->nullable()->unsigned();
            $table->string('designation')->nullable();
            $table->text('about')->nullable();
            $table->text('education')->nullable();
            $table->string('password')->nullable();
            $table->enum('state', [0, 1])->default(1);
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            #Relations
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
