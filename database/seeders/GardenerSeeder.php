<?php

namespace Database\Seeders;

use App\Models\Gardener;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GardenerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        Gardener::truncate();

        $gardeners = [];

        for ($i = 1; $i <= 6; $i++) {
            if ($i >= 4) {

                $gardeners[] = [
                    'fullname' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'location_id' => $i,
                    'country' => 'Nigeria',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {

                $gardeners[] = [
                    'fullname' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'location_id' => $i,
                    'country' => 'Kenya',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // $gardeners = [
        //     [
        //         'fullname' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'location_id' => '1',
        //         'country' => 'kenya',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'fullname' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'location_id' => '2',
        //         'country' => 'kenya',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'fullname' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'location_id' => '3',
        //         'country' => 'kenya',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],

        //     [
        //         'fullname' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'location_id' => '4',
        //         'country' => 'Nigeria',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],

        //     [
        //         'fullname' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'location_id' => '5',
        //         'country' => 'Nigeria',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],

        //     [
        //         'fullname' => $faker->name(),
        //         'email' => $faker->unique()->safeEmail(),
        //         'location_id' => '6',
        //         'country' => 'Nigeria',
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],

        // ];

        Gardener::insert($gardeners);
    }
}