<?php

namespace App\Domains\Customer\Application\Get;

use App\Domains\Shared\Domain\Bus\Query\QueryInterface;

class GetCustomerByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}
