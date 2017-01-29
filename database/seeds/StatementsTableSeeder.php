<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Statement\{
    Main,
    Item
};

use App\Invoice\Main as Invoice;
use App\ReceivedPayment\Main as Payment;

class StatementsTableSeeder extends Seeder
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
                'number' => 'ST-'.$faker->numberBetween(10000, 90000),
                'from_date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'to_date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'total' => $faker->numberBetween(100, 1000),
                'opening_balance' => 0,
                'currency_id' => 1
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                $item = new Item([
                    'statement_id' => $sales_order->id,
                    'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                    'debits' => 0,
                    'credits' => 0,
                    'balance' => 0
                ]);

                $k = mt_rand(1, 2);
                switch ($k) {
                    case 1:
                        // invoice
                        $item->number = 'IN-'.$faker->numberBetween(10000, 90000);
                        $item->type = 'Invoice';
                        $item->debits = $faker->numberBetween(1000, 10000);
                        $item->balance = $item->debits;
                        break;
                    case 2:
                        // payment
                        $item->number = 'RP-'.$faker->numberBetween(10000, 90000);
                        $item->type = 'Payment';
                        $item->credits = $faker->numberBetween(1000, 10000);
                        $item->balance = $item->debits;
                        break;
                    default:
                        # code...
                        break;
                }

                $item->save();

            }
        }
    }
}
