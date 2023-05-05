<?php

declare(strict_types=1);

namespace App\Domains\Shared\Domain\Aggregate;

use App\Domains\Shared\Domain\Bus\Event\AbstractDomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(AbstractDomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
