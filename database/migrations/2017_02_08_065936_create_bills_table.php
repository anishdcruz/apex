<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->unsigned();
            $table->integer('purchase_order_id')->nullable();
            $table->date('date');
            $table->date('due_date');
            $table->string('number')->unique();
            $table->string('vendor_invoice_no');
            $table->double('total');
            $table->double('amount_paid')->default(0);
            $table->integer('status_id');
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('bill_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_id')->unsigned();
            $table->string('item_code');
            $table->text('description');
            $table->double('unit_price');
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
        Schema::dropIfExists('bills');
        Schema::dropIfExists('bill_items');
    }
}
