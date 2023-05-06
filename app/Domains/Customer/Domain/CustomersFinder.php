<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class CustomersFinder
{
    public function __construct(
        private CustomerRepositoryInterface $repository
    ) {
    }

    /**
     * @param array $wheres
     * @return Customers
     */
    public function __invoke(
        array $wheres
    ): Customers
    {
        return $this->repository->findBy($wheres);
    }
}
