<?php

namespace App\Domains\Customer\Application\Delete;

use App\Domains\Customer\Domain\CustomerDeleter;
use App\Domains\Customer\Domain\CustomerId;
use App\Domains\Customer\Domain\CustomerNotFound;
use App\Domains\Shared\Domain\Bus\Command\CommandHandlerInterface;

class DeleteCustomerByIdCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerDeleter $deleter
    )
    {
    }

    /**
     * @param DeleteCustomerByIdCommand $customerId
     * @throws CustomerNotFound
     */
    public function __invoke(DeleteCustomerByIdCommand $customerId)
    {
        $customerId = CustomerId::fromValue($customerId->id);

        $this->deleter->__invoke($customerId);

        // Run event
    }
}
