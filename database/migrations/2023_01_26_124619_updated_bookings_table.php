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
        Schema::table('bookings', function(Blueprint $table) {
            $table->decimal('cc_surcharge_percent',4,2)->nullable();
            $table->string('cc_surcharge_portion')->nullable(); //down payment, balance, total
            $table->decimal('vat')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function(Blueprint $table) {
            $table->dropColumn('cc_surcharge_percent');
            $table->dropColumn('cc_surcharge_portion');
            $table->dropColumn('vat');
        });
    }
};
