<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('number')->unique();
            $table->double('amount_received');
            $table->date('date');
            $table->string('payment_mode');
            $table->string('reference')->nullable();
            $table->double('amount_used');
            $table->text('internal_note')->nullable();
            $table->integer('currency_id');
            $table->timestamps();
        });

        Schema::create('received_payment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('received_payment_id');
            $table->integer('invoice_id');
            $table->double('applied_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_payments');
        Schema::dropIfExists('received_payment_items');
    }
}
