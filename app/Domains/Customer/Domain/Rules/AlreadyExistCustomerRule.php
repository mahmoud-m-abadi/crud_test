<?php

namespace App\Domains\Customer\Domain\Rules;

use App\Domains\Customer\Application\Listing\SearchCustomersQuery;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Query\QueryBusInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AlreadyExistCustomerRule implements ValidationRule
{
    /**
     * @var QueryBusInterface
     */
    private QueryBusInterface $bus;

    public function __construct(
        private string $lastName,
        private string $dateOfBirth,
        private ?int $id = null
    )
    {
        $this->bus = app(QueryBusInterface::class);
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = [
            CustomerModel::FIRST_NAME => $value,
            CustomerModel::LAST_NAME => $this->lastName,
            CustomerModel::DATE_OF_BIRTH => $this->dateOfBirth,
        ];

        if(!is_null($this->id)) {
            $data[CustomerModel::ID] = [CustomerModel::ID, '!=', $this->id];
        }

        $customers = $this->bus->ask(
            new SearchCustomersQuery($data)
        );

        if (count($customers->jsonSerialize())) {
            $fail('This user already existed!');
        }
    }
}
