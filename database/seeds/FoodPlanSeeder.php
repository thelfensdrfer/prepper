<?php

use Illuminate\Database\Seeder;

use App\FoodGroup;
use App\FoodPlan;
use App\User;

class FoodPlanSeeder extends Seeder
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

        factory(FoodPlan::class, 20)->create([
            'user_id' => 1,
            'food_group_id' => 1,
        ])->each(function (FoodPlan $plan) use ($users, $foodGroups) {
            $plan->user_id = $users->random(1)->first()->id;
            $plan->food_group_id = $foodGroups->random(1)->first()->id;

            $plan->save();
        });
    }
}
