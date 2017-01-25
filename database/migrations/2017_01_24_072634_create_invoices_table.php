<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('title');
            $table->string('number')->unique();
            $table->date('date');
            $table->date('due_date');
            $table->double('discount')->nullable();
            $table->double('sub_total');
            $table->double('total');
            $table->double('amount_paid')->default(0);
            $table->string('reference')->nullable();
            $table->integer('status_id');
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('invoice_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->string('item_code');
            $table->text('description');
            $table->double('unit_price');
            $table->integer('qty');
        });

        Schema::create('invoice_terms', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
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
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoice_terms');
    }
}
