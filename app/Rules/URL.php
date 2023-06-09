<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class URL implements Rule
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
    public function passes($attribute, $request)
    {
        if(preg_match('^/https://youtu.be/',$request)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'YoutubeのURLを入力してください。';
    }
}
