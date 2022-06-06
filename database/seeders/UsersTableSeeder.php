<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Kitchen;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        $created_at = $this->faker->dateTimeBetween('-3 months', '-2 months');

        $data = [
            [
//                'name' => 'John',
//                'surname' => 'Smith',
//                'email' => 'john@gmail.com',
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
            ],
            [
//                'name' => 'Nazarіy',
//                'surname' => 'Tymoschuk',
//                'email' => 'naz@gmail.com',
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
            ],
        ];

        return $data;





    }
}
