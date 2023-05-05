<?php

declare(strict_types=1);

namespace App\Domains\Shared\Domain\Bus\Event;

interface DomainEventSubscriberInterface
{
    public static function subscribedTo(): array;
}
