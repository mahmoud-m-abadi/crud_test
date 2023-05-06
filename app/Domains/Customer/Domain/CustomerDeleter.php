<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class CustomerDeleter
{
    public function __construct(
        private CustomerRepositoryInterface $repository) {
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(
        CustomerId $id
    ): void
    {
        $customer = $this->repository->findOneBy([CustomerModel::ID => $id->value]);

        if (null === $customer) {
            throw new CustomerNotFound();
        }

        $this->repository->delete($id);
    }
}
