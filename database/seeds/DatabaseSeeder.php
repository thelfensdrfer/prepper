<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        if (config('app.debug')) {
            $this->call(FoodGroupSeeder::class);
            $this->call(FoodPlanSeeder::class);
            $this->call(FoodSeeder::class);
        }
    }
}
