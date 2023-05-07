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

    /**
     * @OA\Get(
     *     path="/api/v1/customers",
     *     tags={"customers"},
     *     summary="Show a list of customers",
     *     description="Show a list of customers",
     *     @OA\Response(
     *         response=200,
     *         description="Returns array json of customers",
     *         @OA\JsonContent(
     *             type="json",
     *             example="{customers:[]}",
     *             description="successful operation",
     *         )
     *     )
     * )
     *
     */
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
