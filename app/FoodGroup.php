<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FoodGroup extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods()
    {
        return $this->hasMany(Food::class)
            ->where('user_id', Auth::user()->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function foodPlan()
    {
        return $this->hasOne(FoodPlan::class)
            ->where('user_id', Auth::user()->id);
    }
}
