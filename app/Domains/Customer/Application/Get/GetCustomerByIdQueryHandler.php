<?php

namespace App\Domains\Customer\Application\Get;

use App\Domains\Customer\Application\CustomerResponse;
use App\Domains\Customer\Domain\CustomerFinder;
use App\Domains\Customer\Domain\CustomerId;
use App\Domains\Shared\Domain\Bus\Query\QueryHandlerInterface;

class GetCustomerByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CustomerFinder $finder
    )
    {
    }

    public function __invoke(
        GetCustomerByIdQuery $customer
    ): CustomerResponse
    {
        $id = CustomerId::fromValue($customer->id);

        $customer = $this->finder->__invoke($id);

        return CustomerResponse::fromCustomer($customer);
    }
}
