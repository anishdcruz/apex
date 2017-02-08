<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Counter;

class CreateCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('prefix');
            $table->string('number');
            $table->timestamps();
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counters');
    }

    private function seed()
    {
        $counters = [
            [ "key" => "product", "prefix" => "AD", "number" => 100000 ],
            [ "key" => "quotation", "prefix" => "QT", "number" => 100000 ],
            [ "key" => "sales_order", "prefix" => "SO", "number" => 100000 ],
            [ "key" => "invoice", "prefix" => "IN", "number" => 100000 ],
            [ "key" => "payment_received", "prefix" => "PR", "number" => 100000 ],
            [ "key" => "delivery", "prefix" => "DE", "number" => 100000 ],
            [ "key" => "statement", "prefix" => "ST", "number" => 100000 ],
            [ "key" => "bill", "prefix" => "BL", "number" => 100000 ],
            [ "key" => "purchase", "prefix" => "PO", "number" => 100000 ]
        ];

        foreach($counters as $counter) {
            Counter::create($counter);
        }
    }
}
