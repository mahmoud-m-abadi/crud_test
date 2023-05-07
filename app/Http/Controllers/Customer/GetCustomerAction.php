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

    /**
     * @OA\Get(
     *     path="/api/v1/customers/{id}",
     *     tags={"customers"},
     *     summary="Show a customer",
     *     description="Show a customer",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of customer",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns empty json if success",
     *         @OA\JsonContent(
     *             type="json",
     *             example="{customer:[]}",
     *             description="successful operation",
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Customer not found"
     *     )
     * )
     *
     */
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
