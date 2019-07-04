<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemSalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('es_ES');
        for ($x = 0; $x <= 50; $x++) {
            DB::table('item_sales')->insert([
                'sale_id' => $faker->numberBetween($min = 1, $max = 50),
                'item_id' => $faker->numberBetween($min = 1, $max = 25),
                'sale_date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null)
            ]);
        }
    }
}
