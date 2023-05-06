<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Delete\DeleteCustomerByIdCommand;
use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Domains\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Illuminate\Http\Request;

class DeleteCustomerAction
{
    public function __construct(
        private CommandBusInterface $bus
    )
    {
    }

    public function __invoke(int $customerId)
    {
        $this->bus->dispatch(
            new DeleteCustomerByIdCommand($customerId)
        );
    }
}
