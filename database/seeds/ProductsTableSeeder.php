<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Product::truncate();

        foreach(range(1, 150) as $i) {
            Product::create([
                'item_code' => $faker->numberBetween(100000, 800000),
                'description' => $faker->sentence,
                'unit_price' => $faker->numberBetween(10, 500),
                'vendor_ref' => $faker->numberBetween(400000, 900000),
                'vendor_price' => $faker->numberBetween(5, 400),
                'currency_id' => 1
            ]);
        }
    }
}
