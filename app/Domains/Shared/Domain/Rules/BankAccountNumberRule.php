<?php

namespace App\Domains\Shared\Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BankAccountNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^[0-9]{9,18}$/', $value) ) {
            $fail('The :attribute must be a valid number.');
        }
    }
}
