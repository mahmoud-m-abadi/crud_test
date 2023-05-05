<?php

declare(strict_types=1);

namespace App\Domains\Shared\Domain\Bus\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
