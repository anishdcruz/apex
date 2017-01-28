<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Delivery\{
    Main,
    Item
};

class DeliveriesTableSeeder extends Seeder
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

        foreach(range(1, 25) as $i) {
            $sales_order = Main::create([
                'client_id' => $faker->numberBetween(1, 25),
                'number' => 'DE-'.$faker->numberBetween(10000, 90000),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'sales_order_id' => $faker->numberBetween(1, 20),
                'address' => $faker->address,
                'status_id' => $faker->numberBetween(1, 3),
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                Item::create([
                    'delivery_id' => $sales_order->id,
                    'item_code' => 'A-'.$faker->numberBetween(10000, 90000),
                    'description' => $faker->sentence,
                    'qty' => $faker->numberBetween(1, 15)
                ]);
            }
        }
    }
}
