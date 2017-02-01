<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\PurchaseOrder\{
    Main,
    Item,
    Term
};

class PurchaseOrdersTableSeeder extends Seeder
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
            $purchase_order = Main::create([
                'vendor_id' => $faker->numberBetween(1, 25),
                'title' => $faker->sentence,
                'number' => 'Q-'.$faker->numberBetween(10000, 90000),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'discount' => $faker->numberBetween(0, 1000),
                'sub_total' => $faker->numberBetween(100, 1000),
                'total' => $faker->numberBetween(100, 1000),
                'amount_paid' => $faker->numberBetween(0, 600),
                'reference' => 'SO/P/'.$faker->numberBetween(10000, 80000),
                'status_id' => $faker->numberBetween(1, 5),
                'currency_id' => 1
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                Item::create([
                    'purchase_order_id' => $purchase_order->id,
                    'item_code' => $faker->numberBetween(100000, 900000),
                    'description' => $faker->sentence,
                    'unit_price' => $faker->numberBetween(100, 1500),
                    'qty' => $faker->numberBetween(1, 15)
                ]);
            }

            foreach(range(1, mt_rand(2, 4)) as $i) {
                Term::create([
                    'purchase_order_id' => $purchase_order->id,
                    'description' => $faker->text
                ]);
            }
        }
    }
}
