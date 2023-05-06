<?php

namespace App\Domains\Customer\Application\Update;

use App\Domains\Shared\Domain\Bus\Command\CommandInterface;

class UpdateCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id,
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
