<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\SalesOrder\{
    Main,
    Item,
    Term
};

class SalesOrdersTableSeeder extends Seeder
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
            $sales_order = Main::create([
                'client_id' => $faker->numberBetween(1, 25),
                'title' => $faker->sentence,
                'number' => 'SO-'.$faker->numberBetween(10000, 90000),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'our_ref' => $faker->numberBetween(1, 25),
                'customer_po' => 'LPO'.$faker->numberBetween(10000, 100000),
                'discount' => $faker->numberBetween(0, 1000),
                'sub_total' => $faker->numberBetween(100, 1000),
                'total' => $faker->numberBetween(100, 1000),
                'status_id' => $faker->numberBetween(1, 5),
                'currency_id' => 1
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                Item::create([
                    'sales_order_id' => $sales_order->id,
                    'item_code' => 'A-'.$faker->numberBetween(10000, 90000),
                    'description' => $faker->sentence,
                    'unit_price' => $faker->numberBetween(100, 1500),
                    'qty' => $faker->numberBetween(1, 15)
                ]);
            }

            foreach(range(1, mt_rand(2, 4)) as $i) {
                Term::create([
                    'sales_order_id' => $sales_order->id,
                    'description' => $faker->sentence
                ]);
            }
        }
    }
}
