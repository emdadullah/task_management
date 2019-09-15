<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Task;

class ValidTask implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $id)
    {
        if($id == null){
            return true;
        }else{
            return Task::find($id) != null ? true : false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Parent task not found';
    }
}
