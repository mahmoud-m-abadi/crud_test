<?php
declare(strict_types=1);

namespace App\Domains\Shared\Domain\ValueObject;

use App\Domains\Shared\Infrastructure\Services\GooglePhoneValidationInterface;
use InvalidArgumentException;

abstract class PhoneValueObject
{
    /**
     * @throws \Exception
     */
    public function __construct(public readonly string $value)
    {
        $this->assertIsValidPhone($value);
    }

    public static function fromValue(string $value)
    {
        return new static($value);
    }

    /**
     * @param string $value
     * @return void
     * @throws \Exception
     */
    private function assertIsValidPhone(string $value): void
    {
        if (! self::isValid($value)) {
            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $value));
        }
    }

    /**
     * Check if phone in valid
     *
     * @param string $value
     *
     * @return bool
     * @throws \Exception
     */
    public static function isValid(string $value): bool
    {
        $phoneVerifier = app(GooglePhoneValidationInterface::class);
        $number = $phoneVerifier->parse($value, "IR");

        return $phoneVerifier->isValidNumber($number);
    }

    public static function random()
    {
        return fake()->numberBetween(4444444444, 9999999999);
    }
}
