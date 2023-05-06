<?php

namespace App\Domains\Customer\Application\Listing;

use App\Domains\Customer\Application\CustomersResponse;
use App\Domains\Customer\Domain\CustomersFinder;
use App\Domains\Shared\Domain\Bus\Query\QueryHandlerInterface;

class SearchCustomersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CustomersFinder $customersFinder
    )
    {
    }

    public function __invoke(
        SearchCustomersQuery $customersQuery
    )
    {
        $customers = $this->customersFinder->__invoke($customersQuery->wheres);

        return CustomersResponse::fromCustomers($customers);
    }
}
