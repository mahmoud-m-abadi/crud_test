<?php

namespace App\Domains\Shared\Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        try {
            $number = $phoneUtil->parse($value, "IR");
        } catch (\libphonenumber\NumberParseException $e) {
            $fail('The :attribute must be a valid number.');
        }

        if (! $phoneUtil->isValidNumber($number)) {
            $fail('The :attribute must be a valid number.');
        }
    }
}
