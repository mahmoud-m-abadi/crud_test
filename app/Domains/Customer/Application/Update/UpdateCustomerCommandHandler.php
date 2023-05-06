<?php

namespace App\Domains\Customer\Application\Update;

use App\Domains\Customer\Domain\CustomerAlreadyExists;
use App\Domains\Customer\Domain\CustomerBankAccountNumber;
use App\Domains\Customer\Domain\CustomerDateOfBirth;
use App\Domains\Customer\Domain\CustomerEmail;
use App\Domains\Customer\Domain\CustomerFirstName;
use App\Domains\Customer\Domain\CustomerId;
use App\Domains\Customer\Domain\CustomerLastName;
use App\Domains\Customer\Domain\CustomerNotFound;
use App\Domains\Customer\Domain\CustomerPhoneNumber;
use App\Domains\Customer\Domain\CustomerUpdater;
use App\Domains\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class UpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CustomerUpdater $updater)
    {
    }

    /**
     * @param UpdateCustomerCommand $customer
     * @throws EloquentException
     * @throws CustomerNotFound
     */
    public function __invoke(UpdateCustomerCommand $customer): void
    {
        $id = CustomerId::fromValue($customer->id);
        $firstName = CustomerFirstName::fromValue($customer->firstName);
        $lastName = CustomerLastName::fromValue($customer->lastName);
        $dateOfBirth = CustomerDateOfBirth::fromValue($customer->dateOfBirth);
        $phoneNumber = CustomerPhoneNumber::fromValue($customer->phoneNumber);
        $email = CustomerEmail::fromValue($customer->email);
        $bankAccountNumber = CustomerBankAccountNumber::fromValue($customer->bankAccountNumber);

        $this->updater->__invoke(
            $id,
            $firstName,
            $lastName,
            $dateOfBirth,
            $phoneNumber,
            $email,
            $bankAccountNumber
        );
    }
}
