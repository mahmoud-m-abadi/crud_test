<?php

declare(strict_types=1);

namespace App\Domains\Shared\Infrastructure\Bus;

use App\Domains\Shared\Infrastructure\InfrastructureException;
use Throwable;

final class QueryNotRegistered extends InfrastructureException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "" === $message ? "Query not registered" : $message;
        parent::__construct($message, $code, $previous);
    }
}
