<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Hidden::make('user_id')
                    ->default(fn () => Auth::id()),

                TextInput::make('name')
                    ->required(),

                Select::make('type')
                    ->options([
                        'cash' => 'Cash',
                        'bank' => 'Bank',
                        'ewallet' => 'E-Wallet',
                    ])
                    ->required(),

                TextInput::make('opening_balance')
                    ->numeric()
                    ->default(0)
                    ->required(),

            ]);
    }
}