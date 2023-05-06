<?php

namespace App\Http\Controllers\Customer;

use App\Domains\Customer\Application\Update\UpdateCustomerCommand;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Http\Requests\Customer\StoreCustomerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateCustomerAction
{
    public function __construct(
        private CommandBusInterface $bus
    )
    {
    }

    public function __invoke(StoreCustomerRequest $request, int $id): JsonResponse
    {
        $firstName = $request->get(CustomerModel::FIRST_NAME);
        $lastName = $request->get(CustomerModel::LAST_NAME);
        $dateOfBirth = $request->get(CustomerModel::DATE_OF_BIRTH);
        $email = $request->get(CustomerModel::EMAIL);
        $phoneNumber = $request->get(CustomerModel::PHONE_NUMBER);
        $bankAccountNumber = $request->get(CustomerModel::BANK_ACCOUNT_NUMBER);

        $this->bus->dispatch(
            new UpdateCustomerCommand(
                $id,
                $firstName,
                $lastName,
                $dateOfBirth,
                $phoneNumber,
                $email,
                $bankAccountNumber
            )
        );

        return new JsonResponse(
            [
                CustomerModel::ID => $id,
                CustomerModel::FIRST_NAME => $firstName,
                CustomerModel::LAST_NAME => $lastName,
            ],
            Response::HTTP_OK,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
