<?php

use Illuminate\Database\Seeder;
use App\Expense;
use Faker\Factory;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Expense::truncate();

        foreach(range(1, 25) as $i) {
            $exp = Expense::create([
                'vendor_id' => $faker->numberBetween(1, 25),
                'date' => '2016-'.mt_rand(1, 12).'-'.mt_rand(1, 28),
                'amount' => $faker->numberBetween(0, 600),
                'account' => 'expenses',
                'paid_through' => 'petty_cash',
                'payment_reference' => null,
                'internal_note' => $faker->sentence,
                'image' => null,
                'vendor_receipt' => 'RP'.$faker->numberBetween(10000, 80000),
                'currency_id' => 1
            ]);
        }
    }
}
