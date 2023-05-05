<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Shared\Domain\AbstractCollection;

class Customers extends AbstractCollection
{
    protected function type(): string
    {
        return Customer::class;
    }
}
