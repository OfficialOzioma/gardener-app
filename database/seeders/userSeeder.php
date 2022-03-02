<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class userSeeder extends Seeder
{
    public $country;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        User::truncate();

        $customers = [];

        for ($i = 1; $i <= 6; $i++) {
            if ($i >= 4) {

                $customers[] = [
                    'fullname' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'location_id' => $i,
                    'country' => 'Nigeria',
                    'gardener_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {

                $customers[] = [
                    'fullname' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'location_id' => $i,
                    'country' => 'Kenya',
                    'gardener_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        User::insert($customers);
    }
}
