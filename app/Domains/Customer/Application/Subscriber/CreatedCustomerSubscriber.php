<?php

namespace App\Domains\Customer\Application\Subscriber;

use App\Domains\Customer\Domain\CustomerWasCreated;
use App\Domains\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class CreatedCustomerSubscriber implements DomainEventSubscriberInterface
{
    public function __invoke(CustomerWasCreated $event): void
    {
        // TODO add here some logic in relation with the event
    }

    public static function subscribedTo(): array
    {
        return [
            CustomerWasCreated::class
        ];
    }
}
