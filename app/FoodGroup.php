<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodGroup extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function foodPlan()
    {
        return $this->hasOne(FoodPlan::class);
    }
}
