<?php
declare(strict_types=1);

namespace App\Domains\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(public readonly int $value)
    {
    }

    public static function fromValue(int $value)
    {
        return new static($value);
    }
}
