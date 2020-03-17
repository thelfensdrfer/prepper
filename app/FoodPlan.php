<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodPlan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'food_group_id',
        'user_id',
        'optimal_stock',
    ];
}
