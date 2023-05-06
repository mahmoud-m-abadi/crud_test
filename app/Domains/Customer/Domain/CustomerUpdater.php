<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class CustomerUpdater
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    /**
     * @param CustomerId $id
     * @param CustomerFirstName $firstName
     * @param CustomerLastName $lastName
     * @param CustomerDateOfBirth $dateOfBirth
     * @param CustomerPhoneNumber $phoneNumber
     * @param CustomerEmail $email
     * @param CustomerBankAccountNumber $bankAccountNumber
     *
     * @throws CustomerNotFound
     * @throws EloquentException
     */
    public function __invoke(
        CustomerId $id,
        CustomerFirstName $firstName,
        CustomerLastName $lastName,
        CustomerDateOfBirth $dateOfBirth,
        CustomerPhoneNumber $phoneNumber,
        CustomerEmail $email,
        CustomerBankAccountNumber $bankAccountNumber
    ): void
    {
        $customer = $this->repository->findOneBy([CustomerModel::ID => $id]);

        if(null === $customer) {
            throw new CustomerNotFound();
        }

        $customer = Customer::update(
            $id,
            $firstName,
            $lastName,
            $dateOfBirth,
            $phoneNumber,
            $email,
            $bankAccountNumber
        );
        $this->repository->save($customer);
        $this->eventBus->publish(...$customer->pullDomainEvents());
    }
}
