<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Delete\DeleteCustomerByIdCommand;
use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Domains\Shared\Infrastructure\Bus\Messenger\MessengerCommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteCustomerAction
{
    public function __construct(
        private CommandBusInterface $bus
    )
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/customers/{id}",
     *     tags={"customers"},
     *     summary="Delete a customer",
     *     description="Delete a customer",
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
     *         response=204,
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
    public function __invoke(int $id)
    {
        $this->bus->dispatch(
            new DeleteCustomerByIdCommand($id)
        );

        return new JsonResponse([], Response::HTTP_NO_CONTENT, ['Access-Control-Allow-Origin' => '*']);
    }
}
