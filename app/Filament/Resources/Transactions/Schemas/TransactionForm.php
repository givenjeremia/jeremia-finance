<?php

namespace App\Filament\Resources\Transactions\Schemas;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Auth;
class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')->default(fn () => Auth::id()),
                Select::make('account_id')->relationship('account', 'name')->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->required(),
                Select::make('type')
                    ->options([
                        'income' => 'Income',
                        'expense' => 'Expense',
                    ])->required(),
                TextInput::make('amount')->required()->numeric(),
                Textarea::make('description')->columnSpanFull(),
                DatePicker::make('transaction_date')->default(now())->required(),
            ]);
    }
}
