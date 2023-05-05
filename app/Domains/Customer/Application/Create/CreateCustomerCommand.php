<?php

declare(strict_types=1);

namespace App\Domains\Customer\Application\Create;

use App\Domains\Shared\Domain\Bus\Command\CommandInterface;

final class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $dateOfBirth,
        public readonly int $phoneNumber,
        public readonly string $email,
        public readonly int $bankAccountNumber
    )
    {
    }
}
