<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Timezone implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value, timezone_identifiers_list());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The timezone you selected is invalid!');
    }
}
