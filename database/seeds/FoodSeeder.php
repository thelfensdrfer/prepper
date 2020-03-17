<?php

use Illuminate\Database\Seeder;

use App\Food;
use App\User;
use App\FoodGroup;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $foodGroups = FoodGroup::all();

        factory(Food::class, 30)->create([
            'user_id' => 1,
            'food_group_id' => 1,
        ])->each(function (Food $food) use ($users, $foodGroups) {
            $food->user_id = $users->random(1)->first()->id;
            $food->food_group_id = $foodGroups->random(1)->first()->id;

            $food->save();
        });
    }
}
