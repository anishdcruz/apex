<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Currency;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->tinyInteger('decimal_place');
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
        Schema::dropIfExists('currencies');
    }

    private function seed()
    {
        $currencies = [
            [ "code" => "USD", "name" => "United States Dollar", "decimal_place" => 2 ],
            [ "code" => "KWD", "name" => "Kuwaiti Dinar", "decimal_place" => 3 ],
        ];

        foreach($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
