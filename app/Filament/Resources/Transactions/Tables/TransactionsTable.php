<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('user_id')->numeric()->sortable(),
                TextColumn::make('account.name')->sortable(),
                TextColumn::make('category.name')->label('Category'),
                TextColumn::make('type')->searchable(),
                TextColumn::make('amount')->money('IDR')->sortable(),
                TextColumn::make('transaction_date')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
