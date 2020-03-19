<?php

namespace App\Http\Controllers;

use App\FoodGroup;
use Illuminate\Support\Facades\Auth;

use App\Food;
use App\Http\Requests\StoreFood;
use App\Http\Requests\UpdateFood;

class FoodController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('food.index', [
            'foodGroups' => FoodGroup::
                with([
                    'foods',
                    'foodPlan',
                ])
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFood $request
     * @param FoodGroup $foodGroup
     * @return Food
     */
    public function store(StoreFood $request, FoodGroup $foodGroup)
    {
        $food = new Food;
        $food->user_id = Auth::user()->id;
        $food->food_group_id = $foodGroup->id;

        $food->fill($request->validated());
        $food->save();

        return $food;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFood $request
     * @param \App\Food $food
     * @return Food
     */
    public function update(UpdateFood $request, Food $food)
    {
        $food->fill($request->validated())
            ->save();

        return $food;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Food $food
     * @return void
     * @throws \Exception
     */
    public function delete(Food $food)
    {
        $food->delete();
    }
}
