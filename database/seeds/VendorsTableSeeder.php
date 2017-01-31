<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Vendor::truncate();

        foreach(range(1, 25) as $i) {
            Vendor::create([
                'person' => $faker->name,
                'company' => $faker->company,
                'telephone'=> $faker->phoneNumber,
                'email' => $faker->email,
                'shipping_address' => $faker->address,
                'billing_address' => $faker->address,
                'payment_details' => $faker->text,
                'currency_id' => 1
            ]);
        }
    }
}
