<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('number')->unique();
            $table->date('from_date');
            $table->date('to_date');
            $table->double('total');
            $table->double('opening_balance');
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('statement_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('statement_id')->unsigned();
            $table->date('date');
            $table->string('type');
            $table->string('number');
            $table->double('debits');
            $table->double('credits');
            $table->double('balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statements');
        Schema::dropIfExists('statement_items');
    }
}
