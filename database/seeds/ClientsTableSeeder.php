<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Client::truncate();

        foreach(range(1, 25) as $i) {
            Client::create([
                'person' => $faker->name,
                'company' => $faker->company,
                'telephone'=> $faker->phoneNumber,
                'email' => $faker->email,
                'shipping_address' => $faker->address,
                'billing_address' => $faker->address,
                'currency_id' => 1
            ]);
        }
    }
}
