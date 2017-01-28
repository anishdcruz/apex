<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('sales_order_id')->unsigned();
            $table->string('number')->unique();
            $table->text('address');
            $table->date('date');
            $table->integer('status_id');
            $table->timestamps();
        });

        Schema::create('deliveries_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_id')->unsigned();
            $table->string('item_code');
            $table->text('description');
            $table->integer('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('deliveries_items');
    }
}
