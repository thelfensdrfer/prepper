<?php

use Illuminate\Database\Seeder;

use App\FoodGroup;
use Illuminate\Support\Facades\DB;

class FoodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('food_groups')->insert([
            [
                'name' => 'water',
                'icon' => 'glass',
            ],
            [
                'name' => 'fruits',
                'icon' => 'apple-crate'
            ],
            [
                'name' => 'grain',
                'icon' => 'wheat'
            ],
            [
                'name' => 'dairy',
                'icon' => 'cheese-swiss'
            ],
            [
                'name' => 'fat',
                'icon' => 'oil-can'
            ],
            [
                'name' => 'meat',
                'icon' => 'meat'
            ],
            [
                'name' => 'vegetables',
                'icon' => 'carrot'
            ],
        ]);
    }
}
