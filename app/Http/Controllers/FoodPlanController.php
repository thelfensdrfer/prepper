<?php

namespace App\Http\Controllers;

use App\FoodGroup;
use Illuminate\Support\Facades\Auth;

use App\FoodPlan;
use App\Http\Requests\UpdateFoodPlan;

class FoodPlanController extends Controller
{
    public function update(UpdateFoodPlan $request, FoodGroup $foodGroup)
    {
        return FoodPlan::updateOrCreate([
            'food_group_id' => $foodGroup->id,
            'user_id' => Auth::user()->id,
        ], [
            'optimal_stock' => $request->input('optimal_stock'),
        ]);
    }
}
