<?php

namespace App\Filament\Resources\Debts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DebtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('person_name')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                DatePicker::make('due_date'),
                Toggle::make('is_paid')
                    ->required(),
            ]);
    }
}
