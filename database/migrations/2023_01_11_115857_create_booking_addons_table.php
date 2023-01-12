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
        Schema::create('booking_addons', function (Blueprint $table) {
            $table->bigInteger('booking_id')->unsigned();
            $table->bigInteger('addon_id')->unsigned();
            $table->decimal('amount',8,2);
            $table->string('remarks')->nullable();
            $table->bigInteger('added_by')->unsigned();
            $table->timestamps();
            $table->foreign('added_by')->references('id')->on('users');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('addon_id')->references('id')->on('addons');
            $table->primary(['booking_id','addon_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_addons');
    }
};
