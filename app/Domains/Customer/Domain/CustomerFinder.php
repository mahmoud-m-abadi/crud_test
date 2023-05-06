<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class CustomerFinder
{
    public function __construct(
        private CustomerRepositoryInterface $repository
    ) {
    }

    /**
     * @param CustomerId $id
     * @return Customer
     * @throws CustomerNotFound
     */
    public function __invoke(
        CustomerId $id
    ): Customer
    {
        $customer = $this->repository->findOneBy([
            CustomerModel::ID => $id->value
        ]);

        if (null === $customer) {
            throw new CustomerNotFound();
        }

        return $customer;
    }
}
