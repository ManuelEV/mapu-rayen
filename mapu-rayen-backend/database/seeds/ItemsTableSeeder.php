<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan make:seeder ItemsTableSeeder
        //php artisan db:seed --class=ItemsTableSeeder
        $faker = Faker::create('es_ES');
        for ($x = 0; $x <= 25; $x++) {
            DB::table('items')->insert([
                'name' => $faker->word,
                'value' => $faker->numberBetween($min = 1000, $max = 20000),
                'stock' => $faker->numberBetween($min = 5, $max = 50)
            ]);
        }
    }
}
