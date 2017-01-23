<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Term;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach(range(1, 9) as $i) {
            Term::create([
                'description' => $faker->sentence
            ]);
        }
    }
}
