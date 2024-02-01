<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxUsers implements ValidationRule
{
    protected $maxUsers;

    /**
     * Create a new rule instance.
     */
    public function __construct(int $maxUsers) {
        $this->maxUsers = $maxUsers;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //check if the number of users assigned to this software exceeds the quantity
        if(count($value) > $this->maxUsers) {
            $fail('The number of people assigned to this software cannot exceed the quantity');
        }
    }
}
