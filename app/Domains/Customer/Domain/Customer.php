<?php

namespace App\Domains\Customer\Domain;

class Customer
{
    public function __construct(
        public readonly CustomerId $id,
        public readonly CustomerFirstName $firstName,
        public readonly CustomerLastName $lastName,
        public readonly CustomerDateOfBirth $dateOfBirth,
        public readonly CustomerPhoneNumber $phoneNumber,
        public readonly CustomerEmail $email,
        public readonly CustomerBankAccountNumber $bankAccountNumber,
    ) {
    }

    public static function fromPrimitives(
        string $id,
        string $firstName,
        string $lastName,
        string $dateOfBirth,
        string $phoneNumber,
        string $email,
        string $bankAccountNumber
    ): self
    {
        return new self(
            CustomerId::fromValue($id),
            CustomerFirstName::fromValue($firstName),
            CustomerLastName::fromValue($lastName),
            CustomerDateOfBirth::fromValue($dateOfBirth),
            CustomerPhoneNumber::fromValue($phoneNumber),
            CustomerEmail::fromValue($email),
            CustomerBankAccountNumber::fromValue($bankAccountNumber)
        );
    }
}
