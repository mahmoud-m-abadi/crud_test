<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Create\CreateCustomerCommand;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
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
     * @OA\POST(
     *     path="/customers",
     *     description="Save a new customer",
     *     @OA\Response(response="JsonResponse", description="Save Customer"),
     *     @OA\PathItem(path="customers", description="Save a new customer"),
     * )
     */
    public function __invoke(Request $request): JsonResponse
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
