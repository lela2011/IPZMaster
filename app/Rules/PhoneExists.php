<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userName = request()->route('user') ?? request()->user();
        $user = User::find($userName);

        if (in_array('phone', $value) && empty($user->phone)) {
            $fail('You must provide a phone number first.');
        }
    }
}
