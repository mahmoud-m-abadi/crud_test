<?php

namespace App\Domains\Customer\Application;

use App\Domains\Shared\Domain\Bus\Query\ResponseInterface;

class CustomerResponse implements ResponseInterface
{

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
    }
}
