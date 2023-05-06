<?php

namespace App\Domains\Customer\Application;

use App\Domains\Customer\Domain\Customer;
use App\Domains\Customer\Domain\Customers;
use App\Domains\Shared\Domain\Bus\Query\ResponseInterface;

class CustomersResponse implements ResponseInterface
{
    /**
     * @param array<CustomerResponse> $customers
     */
    public function __construct(private array $customers)
    {
    }

    public static function fromCustomers(Customers $customers): self
    {
        $customerResponses = array_map(
            function (Customer $customer) {
                return CustomerResponse::fromCustomer($customer);
            },
            $customers->all()
        );

        return new self($customerResponses);
    }

    public function jsonSerialize(): array
    {
        return array_map(function (CustomerResponse $boardResponse) {
            return $boardResponse->jsonSerialize();
        }, $this->customers);
    }
}
