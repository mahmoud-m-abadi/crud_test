<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Listing\SearchCustomersQuery;
use App\Domains\Shared\Domain\Bus\Query\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchCustomersAction
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $customers = $this->queryBus->ask(
            new SearchCustomersQuery($request->get('wheres', []))
        );

        return new JsonResponse(
            [
                'customers' => $customers
            ],
            Response::HTTP_OK,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

}
