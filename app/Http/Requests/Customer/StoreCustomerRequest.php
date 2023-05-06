<?php

namespace App\Http\Requests\Customer;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Rules\BankAccountNumberRule;
use App\Domains\Shared\Domain\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            CustomerModel::FIRST_NAME => [
                'required',
                'string',
                'min:3',
                'max:50'
            ],
            CustomerModel::LAST_NAME => [
                'required',
                'string',
                'min:3',
                'max:50'
            ],
            CustomerModel::EMAIL => [
                'required',
                'email',
                'min:5',
                'max:60'
            ],
            CustomerModel::DATE_OF_BIRTH => [
                'required',
                'date'
            ],
            CustomerModel::PHONE_NUMBER => [
                'required',
                new PhoneNumberRule()
            ],
            CustomerModel::BANK_ACCOUNT_NUMBER => [
                'required',
                'numeric',
                new BankAccountNumberRule()
            ]
        ];
    }
}
