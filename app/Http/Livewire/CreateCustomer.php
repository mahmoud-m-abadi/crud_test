<?php

namespace App\Http\Livewire;

use App\Domains\Customer\Application\Create\CreateCustomerCommand;
use App\Domains\Customer\Domain\Rules\AlreadyExistCustomerRule;
use App\Domains\Customer\Infrastructure\CustomerModel;
use App\Domains\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Domains\Shared\Domain\Rules\BankAccountNumberRule;
use App\Domains\Shared\Domain\Rules\PhoneNumberRule;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;
use Filament\Forms;

class CreateCustomer extends Component implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public CustomerModel $customer;

    public $first_name;
    public $last_name;
    public $email;
    public $date_of_birth;
    public $phone_number;
    public $bank_account_number;

    public function rules()
    {
        return [
            CustomerModel::FIRST_NAME => [
                'required',
                'string',
                'min:3',
                'max:50',
                new AlreadyExistCustomerRule(
                    $this->last_name,
                    $this->date_of_birth
                )
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
                'max:60',
                sprintf('unique:%s,%s', CustomerModel::TABLE, CustomerModel::EMAIL)
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

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make(CustomerModel::FIRST_NAME)
                        ->required(),
                    Forms\Components\TextInput::make(CustomerModel::LAST_NAME)->required(),
                    Forms\Components\TextInput::make(CustomerModel::EMAIL)->email()->required(),
                    Forms\Components\DatePicker::make(CustomerModel::DATE_OF_BIRTH)
                        ->rule('date')
                        ->required(),
                    Forms\Components\TextInput::make(CustomerModel::PHONE_NUMBER)
                        ->rule(new PhoneNumberRule())
                        ->required(),
                    Forms\Components\TextInput::make(CustomerModel::BANK_ACCOUNT_NUMBER)
                        ->rule(new BankAccountNumberRule())
                        ->required(),
                ])
        ];
    }

    public function submit(): void
    {
        $this->validate($this->rules());

        $commandBus = app(CommandBusInterface::class);
        $commandBus->dispatch(
            new CreateCustomerCommand(
                $this->first_name,
                $this->last_name,
                $this->date_of_birth,
                $this->phone_number,
                $this->email,
                $this->bank_account_number
            )
        );

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.create-customer');
    }
}
