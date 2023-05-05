<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\EventBusInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class CustomerCreator
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    /**
     * @throws CustomerAlreadyExists
     * @throws EloquentException
     */
    public function __invoke(
        CustomerFirstName $firstName,
        CustomerLastName $lastName,
        CustomerDateOfBirth $dateOfBirth,
        CustomerPhoneNumber $phoneNumber,
        CustomerEmail $email,
        CustomerBankAccountNumber $bankAccountNumber
    ): void
    {
        $customer = $this->repository->findOneBy([
            CustomerModel::FIRST_NAME => $firstName->value,
            CustomerModel::LAST_NAME => $lastName->value,
            CustomerModel::DATE_OF_BIRTH => $dateOfBirth->value
        ]);

        if (null !== $customer) {
            throw new CustomerAlreadyExists();
        }

        $customer = Customer::create(
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
