<?php
declare(strict_types=1);

namespace App\Domains\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class EmailValueObject
{
    public function __construct(public readonly string $value)
    {
        $this->assertIsValidEmail($value);
    }

    public static function fromValue(string $value)
    {
        return new static($value);
    }

    private function assertIsValidEmail(string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL) ) {
            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $value));
        }
    }
}
