<?php

namespace App\Domains\Customer\Application\Listing;

use App\Domains\Shared\Domain\Bus\Query\QueryInterface;

class SearchCustomersQuery implements QueryInterface
{
    public function __construct(
        public readonly array $wheres
    )
    {
    }
}
