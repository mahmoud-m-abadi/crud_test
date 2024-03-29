<?php

declare(strict_types=1);

namespace App\Domains\Shared\Infrastructure\Bus\Messenger;

use App\Domains\Shared\Domain\Bus\Event\AbstractDomainEvent;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class MessengerEventBus implements EventBusInterface
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forPipedCallables($subscribers)
                    )
                ),
            ]
        );
    }

    public function publish(AbstractDomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch(new Envelope($event));
            } catch (NoHandlerForMessageException) {
                // TODO optionally throw exception or not
            }
        }
    }
}
