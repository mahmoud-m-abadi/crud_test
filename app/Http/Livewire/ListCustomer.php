<?php

namespace App\Http\Livewire;

use App\Domains\Customer\Infrastructure\CustomerModel;
use Livewire\Component;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListCustomer extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return CustomerModel::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make(CustomerModel::FIRST_NAME),
            Tables\Columns\TextColumn::make(CustomerModel::LAST_NAME),
            Tables\Columns\TextColumn::make(CustomerModel::EMAIL),
            Tables\Columns\TextColumn::make(CustomerModel::DATE_OF_BIRTH),
            Tables\Columns\TextColumn::make(CustomerModel::PHONE_NUMBER),
            Tables\Columns\TextColumn::make(CustomerModel::BANK_ACCOUNT_NUMBER),
        ];
    }

    public function render()
    {
        return view('livewire.list-customer');
    }
}
