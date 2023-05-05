<?php
declare(strict_types=1);

namespace App\Domains\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class BankAccountValueObject
{
    public function __construct(public readonly string $value)
    {
        $this->assertIsValidBankAccount($value);
    }

    public static function fromValue(string $value)
    {
        return new static($value);
    }

    /**
     * @param string $value
     * @return void
     */
    private function assertIsValidBankAccount(string $value)
    {
        if (! preg_match('/^[0-9]{9,18}$/', $value) ) {
            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $value));
        }
    }

    public static function random()
    {
        return fake()->numberBetween(4444444444, 9999999999);
    }
}
