<?php

namespace App\Domains\Shared\Infrastructure\Services;

interface GooglePhoneValidationInterface
{
    public function parse(string $number, string $region): mixed;
    public function isValidNumber(string $number): bool;
}
