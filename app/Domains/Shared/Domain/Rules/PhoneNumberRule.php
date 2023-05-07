<?php

namespace App\Domains\Shared\Domain\Rules;

use App\Domains\Shared\Infrastructure\Services\GooglePhoneValidationInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhoneNumberRule implements ValidationRule
{
    /**
     * @var mixed
     */
    private mixed $phoneVerifier;

    public function __construct()
    {
        $this->phoneVerifier = app(GooglePhoneValidationInterface::class);
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $number = $this->phoneVerifier->parse($value, "IR");

        if (! $this->phoneVerifier->isValidNumber($number)) {
            $fail('The :attribute must be a valid number.');
        }
    }
}
