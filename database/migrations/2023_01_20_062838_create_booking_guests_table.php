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
        Schema::create('booking_guests', function (Blueprint $table) {
            $table->bigInteger('guest_id')->unsigned();
            $table->bigInteger('booking_id')->unsigned();
            $table->timestamps();
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->primary(['guest_id','booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_guests');
    }
};
