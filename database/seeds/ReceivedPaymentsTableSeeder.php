<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\ReceivedPayment\{
    Main,
    Item
};

class ReceivedPaymentsTableSeeder extends Seeder
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
            $amount = $faker->numberBetween(0, 1000);
            $payment = Main::create([
                'client_id' => $faker->numberBetween(1, 25),
                'number' => 'R-'.$faker->numberBetween(10000, 90000),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'amount_used' => $amount,
                'amount_received' => $amount,
                'payment_mode' => 'cheque',
                'internal_note' => '',
                'currency_id' => 1
            ]);

            foreach(range(1, mt_rand(2, 5)) as $i) {
                Item::create([
                    'received_payment_id' => $payment->id,
                    'invoice_id' => $faker->numberBetween(1, 25),
                    'applied_amount' => $faker->numberBetween(100, 1500)
                ]);
            }
        }
    }
}
