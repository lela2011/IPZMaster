<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrcidValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!empty($value)) {
            $pattern = '/^\d{4}-\d{4}-\d{4}-\d{3}[0-9X]$/';
            if(!preg_match($pattern, $value)) {
                $fail("The provided ORCID doesn't follow the required pattern.");
            }

            $cleanedOrcid = str_replace('-', '', $value);
            // Remove check digit
            $orcidNoFinal = substr($cleanedOrcid, 0, -1);

            // Generate check digit. Copied from https://support.orcid.org/hc/en-us/articles/360006897674-Structure-of-the-ORCID-Identifier
            $total = 0;
            foreach(str_split($orcidNoFinal) as $char) {
                $digit = intval($char);
                $total = ($total + $digit) * 2;
            }
            $remainder = $total % 11;
            $result = (12 - $remainder) % 11;
            $checkDigit = $result == 10 ? "X" : strval($result);

            // Compare if generated check digit is equal to provided one
            if(substr($cleanedOrcid, -1) !== $checkDigit) {
                $fail('The provided ORCID is not valid.');
            }
        }
    }
}
