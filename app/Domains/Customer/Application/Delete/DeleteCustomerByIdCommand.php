<?php

namespace App\Domains\Customer\Application\Delete;

use App\Domains\Shared\Domain\Bus\Command\CommandInterface;

final class DeleteCustomerByIdCommand implements CommandInterface
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}
