<?php
declare(strict_types=1);

namespace App\Domains\Shared\Domain\ValueObject;

abstract class DateValueObject
{
    public function __construct(public readonly string $value)
    {
    }

    public static function fromValue(string $value)
    {
        return new static($value);
    }
}
