<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{

    protected $ref;
    public function __construct($ref)
    {
        $this->ref = $ref;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(in_array(strtolower($value), $this->ref)){
            $fail('the '. $attribute. ' '. $value. ' is not recomended!');
        }
    }
}
