<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->unsigned();
            $table->string('title');
            $table->string('number')->unique();
            $table->string('reference')->nullable();
            $table->date('date');
            $table->double('discount')->nullable();
            $table->double('sub_total');
            $table->double('total');
            $table->double('amount_paid')->default(0);
            $table->integer('status_id');
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('purchase_order_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_order_id')->unsigned();
            $table->string('item_code');
            $table->text('description');
            $table->double('unit_price');
            $table->integer('qty');
        });

        Schema::create('purchase_order_terms', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_order_id')->unsigned();
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
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_order_terms');
    }
}
