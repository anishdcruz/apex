<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotatonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('title');
            $table->string('number')->unique();
            $table->date('date');
            $table->date('expiry_date');
            $table->double('discount')->nullable();
            $table->double('sub_total');
            $table->double('total');
            $table->integer('status_id');
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('quotation_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('quotation_id')->unsigned();
            $table->string('item_code');
            $table->text('description');
            $table->double('unit_price');
            $table->integer('qty');
        });

        Schema::create('quotation_terms', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('quotation_id')->unsigned();
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
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotation_terms');
    }
}
