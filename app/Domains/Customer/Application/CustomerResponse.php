<?php

namespace App\Domains\Customer\Application;

use App\Domains\Customer\Domain\Customer;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Query\ResponseInterface;

final class CustomerResponse implements ResponseInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phoneNumber,
    ) {
    }

    public static function fromCustomer(Customer $customer): self
    {
        return new self(
            $customer->id->value,
            $customer->firstName->value,
            $customer->lastName->value,
            $customer->email->value,
            $customer->phoneNumber->value,
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            CustomerModel::ID => $this->id,
            CustomerModel::FIRST_NAME => $this->firstName,
            CustomerModel::LAST_NAME => $this->lastName,
            CustomerModel::EMAIL => $this->email,
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ];
    }

    public function toArray()
    {
        return [
            CustomerModel::ID => $this->id,
            CustomerModel::FIRST_NAME => $this->firstName,
            CustomerModel::LAST_NAME => $this->lastName,
            CustomerModel::EMAIL => $this->email,
            CustomerModel::PHONE_NUMBER => $this->phoneNumber,
        ];
    }
}
