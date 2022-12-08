<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('doctor_id');
            $table->string('package_name');
            $table->date('purchase_date');
            $table->integer('expired_day');
            $table->date('expired_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('transaction_id')->nullable();
            $table->tinyInteger('payment_status')->default(0);
            $table->double('amount')->default(0);
            $table->integer('online_consulting');
            $table->integer('message_system');
            $table->integer('daily_appointment_qty');
            $table->integer('online_prescription');
            $table->integer('review_system');
            $table->integer('maximum_staff');
            $table->integer('maximum_image');
            $table->integer('maximum_video');
            $table->integer('maximum_chamber');
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
        Schema::dropIfExists('orders');
    }
}
