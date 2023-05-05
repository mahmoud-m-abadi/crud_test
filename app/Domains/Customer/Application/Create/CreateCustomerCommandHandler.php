<?php

namespace App\Domains\Customer\Application\Create;

use App\Domains\Customer\Domain\CustomerAlreadyExists;
use App\Domains\Customer\Domain\CustomerBankAccountNumber;
use App\Domains\Customer\Domain\CustomerCreator;
use App\Domains\Customer\Domain\CustomerDateOfBirth;
use App\Domains\Customer\Domain\CustomerEmail;
use App\Domains\Customer\Domain\CustomerFirstName;
use App\Domains\Customer\Domain\CustomerLastName;
use App\Domains\Customer\Domain\CustomerPhoneNumber;
use App\Domains\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

final class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CustomerCreator $creator)
    {
    }

    /**
     * @throws CustomerAlreadyExists
     * @throws EloquentException
     */
    public function __invoke(CreateCustomerCommand $customer): void
    {
        $firstName = CustomerFirstName::fromValue($customer->firstName);
        $lastName = CustomerLastName::fromValue($customer->lastName);
        $dateOfBirth = CustomerDateOfBirth::fromValue($customer->dateOfBirth);
        $phoneNumber = CustomerPhoneNumber::fromValue($customer->phoneNumber);
        $email = CustomerEmail::fromValue($customer->email);
        $bankAccountNumber = CustomerBankAccountNumber::fromValue($customer->bankAccountNumber);

        $this->creator->__invoke(
            $firstName,
            $lastName,
            $dateOfBirth,
            $phoneNumber,
            $email,
            $bankAccountNumber
        );
    }
}
