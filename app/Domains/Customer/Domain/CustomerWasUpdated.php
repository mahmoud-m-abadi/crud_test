<?php

namespace App\Domains\Customer\Domain;

use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Event\AbstractDomainEvent;

class CustomerWasUpdated extends AbstractDomainEvent
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $dateOfBirth,
        public readonly string $phoneNumber,
        public readonly string $email,
        public readonly string $bankAccountNumber,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): AbstractDomainEvent
    {
        return new self(
            $body[CustomerModel::ID],
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
        return 'customer.was_updated';
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'dateOfBirth' => $this->dateOfBirth,
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
            'bankAccountNumber' => $this->bankAccountNumber,
        ];
    }
}
