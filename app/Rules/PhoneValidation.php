<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // checks if the phone number is not empty
        if(!empty($value)) {

            // checks if the phone number follows the required pattern
            $pattern = '/^\+41 \d{2} \d{3} \d{2} \d{2}$/';
            if(!preg_match($pattern, $value)) {
                // returns error message if the phone number doesn't follow the required pattern
                $fail("The provided phone number doesn't follow the required pattern.");
            }
        }
    }
}
