<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Bill\{
    Main,
    Item
};

class BillsTableSeeder extends Seeder
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
            $bill = Main::create([
                'vendor_id' => $faker->numberBetween(1, 25),
                'purchase_order_id' => $i,
                'vendor_invoice_no' => 'TP/121/'.$faker->numberBetween(10000, 90000),
                'number' => 'Q-'.$faker->numberBetween(10000, 90000),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'due_date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'total' => $faker->numberBetween(100, 1000),
                'amount_paid' => $faker->numberBetween(0, 600),
                'status_id' => $faker->numberBetween(1, 5),
                'currency_id' => 1
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                Item::create([
                    'bill_id' => $bill->id,
                    'item_code' => $faker->numberBetween(100000, 900000),
                    'description' => $faker->sentence,
                    'unit_price' => $faker->numberBetween(100, 1500),
                    'qty' => $faker->numberBetween(1, 15)
                ]);
            }
        }
    }
}
