<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('title');
            $table->string('number')->unique();
            $table->date('date');
            $table->double('discount')->nullable();
            $table->integer('our_ref')->nullable();
            $table->string('customer_po')->nullable();
            $table->double('sub_total');
            $table->double('total');
            $table->integer('status_id');
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('sales_order_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_order_id')->unsigned();
            $table->string('item_code');
            $table->text('description');
            $table->double('unit_price');
            $table->integer('qty');
        });

        Schema::create('sales_order_terms', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_order_id')->unsigned();
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('sales_order_items');
        Schema::dropIfExists('sales_order_terms');
    }
}
