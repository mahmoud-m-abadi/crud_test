<?php

namespace App\Domains\Customer\Infrastructure;

use App\Domains\Customer\Domain\Customer;
use App\Domains\Customer\Domain\CustomerId;
use App\Domains\Customer\Domain\CustomerRepositoryInterface;
use App\Domains\Customer\Domain\Customers;
use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;
use Illuminate\Support\Facades\DB;
use Exception;

class CustomerRepository implements CustomerRepositoryInterface
{
    private CustomerModel $model;

    public function __construct(CustomerModel $model)
    {
        $this->model = $model;
    }

    /**
     * Convert to related DOMAIN
     *
     * @param CustomerModel $eloquentCustomerModel
     * @return Customer
     */
    private function toDomain(CustomerModel $eloquentCustomerModel): Customer
    {
        return Customer::fromPrimitives(
            $eloquentCustomerModel->id ?? null,
            $eloquentCustomerModel->first_name,
            $eloquentCustomerModel->last_name,
            $eloquentCustomerModel->date_of_birth,
            $eloquentCustomerModel->phone_number,
            $eloquentCustomerModel->email,
            $eloquentCustomerModel->bank_account_number
        );
    }

    /**
     * Delete item.
     *
     * @param CustomerId $id
     * @return void
     */
    public function delete(CustomerId $id): void
    {
        $customer = $this->model->find($id->value);

        $customer->delete();
    }

    /**
     * Find and get a list
     * @param array $wheres
     * @return Customers
     */
    public function findBy(array $wheres = []): Customers
    {
        $customers = $this->model
            ->where($wheres)
            ->get()
            ->map(
                function (CustomerModel $eloquentBoard) {
                    return $this->toDomain($eloquentBoard);
                }
            )->toArray();

        return new Customers($customers);
    }

    /**
     * Find one item
     *
     * @param array $wheres
     * @return Customer|null
     */
    public function findOneBy(array $wheres = []): ?Customer
    {
        $customer = $this->model
            ->where($wheres)
            ->first();

        return is_null($customer) ? null : $this->toDomain($customer);
    }

    /**
     * Save in DB
     *
     * @throws EloquentException
     */
    public function save(Customer $customer): void
    {
        $customerModel = $this->model->find(optional($customer->id)->value ?? 0);

        if (null === $customerModel) {
            $customerModel = new CustomerModel();
        }

        $customerModel->{CustomerModel::FIRST_NAME} = $customer->firstName->value;
        $customerModel->{CustomerModel::LAST_NAME} = $customer->lastName->value;
        $customerModel->{CustomerModel::DATE_OF_BIRTH} = $customer->dateOfBirth->value;
        $customerModel->{CustomerModel::PHONE_NUMBER} = str_replace(['-','(',')',' ','/','\\'], '',  $customer->phoneNumber->value);
        $customerModel->{CustomerModel::EMAIL} = $customer->email->value;
        $customerModel->{CustomerModel::BANK_ACCOUNT_NUMBER} = $customer->bankAccountNumber->value;

        DB::beginTransaction();
        try {
            $customerModel->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new EloquentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }
}
