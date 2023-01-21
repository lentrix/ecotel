<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->bigInteger('room_id')->unsigned();
            $table->decimal('room_rate',8,2);
            $table->bigInteger('added_by')->unsigned();
            $table->string('status')->default('pending'); //pending (no deposit yet), confirmed (with deposit)
            $table->decimal('down_payment',8,2)->default(0);
            $table->string("payment_mode")->nullable();
            $table->string("source")->default('Walk-in');
            $table->boolean('with_breakfast')->default(0);
            $table->string('purpose');
            $table->string('discount_remarks')->nullable();
            $table->decimal('discount_amount', 8,2)->nullable();
            $table->timestamps();
            $table->foreign('added_by')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
