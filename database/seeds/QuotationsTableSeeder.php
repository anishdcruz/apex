<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Quotation\Main;
use App\Quotation\Item;
use App\Quotation\Term;

class QuotationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Main::truncate();
        Item::truncate();
        Term::truncate();

        foreach(range(1, 25) as $i) {
            $quotation = Main::create([
                'client_id' => $faker->numberBetween(1, 25),
                'title' => $faker->sentence,
                'number' => 'Q-'.$faker->numberBetween(10000, 90000),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'expiry_date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'discount' => $faker->numberBetween(0, 1000),
                'sub_total' => $faker->numberBetween(100, 1000),
                'total' => $faker->numberBetween(100, 1000),
                'status_id' => $faker->numberBetween(1, 5),
                'currency_id' => 1
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                Item::create([
                    'quotation_id' => $quotation->id,
                    'item_code' => 'A-'.$faker->numberBetween(10000, 90000),
                    'description' => $faker->sentence,
                    'unit_price' => $faker->numberBetween(100, 1500),
                    'qty' => $faker->numberBetween(1, 15)
                ]);
            }

            foreach(range(1, mt_rand(2, 4)) as $i) {
                Term::create([
                    'quotation_id' => $quotation->id,
                    'description' => $faker->sentence
                ]);
            }
        }
    }
}
