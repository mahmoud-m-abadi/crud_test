<?php

namespace App\Domains\Customer\Application\Subscriber;

use App\Domains\Customer\Domain\CustomerWasUpdated;
use App\Domains\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class UpdatedCustomerSubscriber implements DomainEventSubscriberInterface
{
    public function __invoke(CustomerWasUpdated $event): void
    {
    }

    public static function subscribedTo(): array
    {
        return [
            CustomerWasUpdated::class
        ];
    }
}
