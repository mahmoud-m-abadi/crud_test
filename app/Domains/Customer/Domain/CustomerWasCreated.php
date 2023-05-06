<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\AbstractDomainEvent;

class CustomerWasCreated extends AbstractDomainEvent
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $dateOfBirth,
        public readonly string $phoneNumber,
        public readonly string $email,
        public readonly string $bankAccountNumber,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct(null, $eventId, $occurredOn);
    }

    public static function fromPrimitives(int|string|null $aggregateId, array $body, string $eventId, string $occurredOn): AbstractDomainEvent
    {
        return new self(
            $body[CustomerModel::FIRST_NAME],
            $body[CustomerModel::LAST_NAME],
            $body[CustomerModel::DATE_OF_BIRTH],
            $body[CustomerModel::PHONE_NUMBER],
            $body[CustomerModel::EMAIL],
            $body[CustomerModel::BANK_ACCOUNT_NUMBER],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'customer.was_created';
    }

    public function toPrimitives(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'dateOfBirth' => $this->dateOfBirth,
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
            'bankAccountNumber' => $this->bankAccountNumber,
        ];
    }
}
