<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($x = 0; $x <= 50; $x++) {
            DB::table('sales')->insert([
                'subtotal' => $faker->numberBetween($min = 1000, $max = 85000),
                'total' => $faker->numberBetween($min = 1000, $max = 80000),
                'discount' => $faker->numberBetween($min = 0, $max = 1),
                'sale_date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null)
            ]);
        }
    }
}
