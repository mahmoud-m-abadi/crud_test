<?php

namespace App\Domains\Customer\Infrastructure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class CustomerModel extends Model
{
    use HasFactory;

    const TABLE = 'customers';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const DATE_OF_BIRTH = 'date_of_birth';
    const PHONE_NUMBER = 'phone_number';
    const EMAIL = 'email';
    const BANK_ACCOUNT_NUMBER = 'bank_account_number';

    protected $table = self::TABLE;

    public function __construct(array $attributes = [])
    {
        if (app()->environment() === 'testing') {
            $this->setConnection('sqlite');
        } else {
            $this->setConnection('mysql');
        }

        parent::__construct($attributes);
    }

    protected static function newFactory()
    {
        return CustomerModelFactory::new();
    }
}
