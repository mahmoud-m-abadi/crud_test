<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Create\CreateCustomerCommand;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Http\Requests\Customer\StoreCustomerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CreateCustomerAction
{
    public function __construct(
        private CommandBusInterface $commandBus
    )
    {
    }

   /**
    * @OA\Post(
    *     path="/api/v1/customers",
    *     tags={"customers"},
    *     summary="Create a new customer",
    *     description="Create a new customer",
    *     @OA\Parameter(
    *         name="first_name",
    *         in="query",
    *         description="first name of customer",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="last_name",
    *         in="query",
    *         description="last name of customer",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="date_of_birth",
    *         in="query",
    *         description="date of birth of customer",
    *         required=true,
    *         example="1991/01/01",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="phone_number",
    *         in="query",
    *         description="phone number of customer",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             default="+989194747602"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="email of customer",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="bank_account_number",
    *         in="query",
    *         description="bank account number of customer",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Returns json with customer=true if available",
    *         @OA\JsonContent(
    *             type="json",
    *             example="{customer:[]}",
    *             description="successful operation",
    *         )
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Parameter wont validate"
    *     )
    * )
    *
    */
    public function __invoke(StoreCustomerRequest $request): JsonResponse
    {
        $this->commandBus->dispatch(
            new CreateCustomerCommand(
                $firstName = $request->get(CustomerModel::FIRST_NAME),
                $lastName = $request->get(CustomerModel::LAST_NAME),
                $dateOfBirth = $request->get(CustomerModel::DATE_OF_BIRTH),
                $phoneNumber = $request->get(CustomerModel::PHONE_NUMBER),
                $email = $request->get(CustomerModel::EMAIL),
                $bankAccountNumber = $request->get(CustomerModel::BANK_ACCOUNT_NUMBER)
            )
        );

        return new JsonResponse(
            [
                'customer' => [
                    CustomerModel::FIRST_NAME => $firstName,
                    CustomerModel::LAST_NAME => $lastName,
                ]
            ],
            Response::HTTP_CREATED,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
