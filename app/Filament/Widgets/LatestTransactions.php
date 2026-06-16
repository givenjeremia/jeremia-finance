<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestTransactions extends TableWidget
{
    protected static ?int $sort = 30;
    protected static ?string $heading = 'Latest Transactions';

    protected int|string|array $columnSpan = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('account.name')->label('Account'),

                Tables\Columns\TextColumn::make('category.name')->label('Category'),

                Tables\Columns\BadgeColumn::make('type'),

                Tables\Columns\TextColumn::make('amount')->money('IDR'),

                Tables\Columns\TextColumn::make('transaction_date')->date(),
            ])
            ->defaultPaginationPageOption(10);
    }
}