<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Customer\Infrastructure\CustomerRepository;
use App\Domains\Shared\Domain\ValueObject\EmailValueObject;
use InvalidArgumentException;

class CustomerEmail extends EmailValueObject
{
//    protected function assertIsValidEmail(string $value)
//    {
//        $checkEmailInDB = (app(CustomerRepositoryInterface::class))
//            ->findOneBy([
//                CustomerModel::EMAIL => $value
//            ]);
//
//        if (! filter_var($value, FILTER_VALIDATE_EMAIL) OR !is_null($checkEmailInDB) ) {
//            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $value));
//        }
//    }
}
