<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Get\GetCustomerByIdQuery;
use App\Domains\Shared\Domain\Bus\Query\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetCustomerAction
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $customerResponse = $this->queryBus->ask(
            new GetCustomerByIdQuery($id)
        );

        return new JsonResponse(
            [
                'customer' => $customerResponse->toArray()
            ],
            Response::HTTP_OK,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
