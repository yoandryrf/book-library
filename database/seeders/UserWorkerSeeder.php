<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use \App\Enums\UserRoleEnum;
use \Faker;


class UserWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();

        foreach (range(1, 3) as $index) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            User::create([
                'name'     => $firstName,
                'last_name'     => $lastName,
                'email'     => $faker->email,
                'role' => UserRoleEnum::WORKER,
                'password' => bcrypt('pass1234')
            ]);
        }
    }
}
