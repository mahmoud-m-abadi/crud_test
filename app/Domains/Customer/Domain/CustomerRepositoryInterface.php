<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Shared\Infrastructure\Eloquent\EloquentException;

interface CustomerRepositoryInterface
{
    /**
     * Delete item.
     *
     * @param CustomerId $id
     * @return void
     */
    public function delete(CustomerId $id): void;

    /**
     * Find and get a list
     * @param array $wheres
     * @return Customers
     */
    public function findBy(array $wheres = []): Customers;

    /**
     * Find one item
     *
     * @param array $wheres
     * @return Customer|null
     */
    public function findOneBy(array $wheres = []): ?Customer;

    /**
     * Save in DB
     *
     * @throws EloquentException
     */
    public function save(Customer $board): void;
}
