<?php

declare(strict_types=1);

namespace App\Domains\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Illuminate\Support\Str;

abstract class AbstractDomainEvent
{
    private string $aggregateId;
    private string $eventId;
    private string $occurredOn;

    public function __construct(string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = Str::uuid()->toString();
        $this->eventId = $eventId ?: Str::random();
        $this->occurredOn = $occurredOn ?: (new DateTimeImmutable())->format('Y-m-d H:i:s.u T');
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
