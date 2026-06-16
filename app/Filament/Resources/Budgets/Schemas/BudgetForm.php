<?php

namespace App\Filament\Resources\Budgets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('month')
                    ->required()
                    ->numeric(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('limit_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
