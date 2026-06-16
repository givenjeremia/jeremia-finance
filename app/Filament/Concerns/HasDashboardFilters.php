<?php

namespace App\Filament\Concerns;

use App\Models\Account;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

trait HasDashboardFilters
{
    public ?string $period = 'today';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?int $accountId = null;

    public ?string $transactionType = null;

    public function getFilterFormSchema(): array
    {
        return [
            Select::make('period')
                ->label('Period')
                ->options([
                    'today' => 'Today',
                    'week' => 'This Week',
                    'month' => 'This Month',
                    'year' => 'This Year',
                    'custom' => 'Custom Range',
                ])
                ->default('today')
                ->live(),

            DatePicker::make('startDate')
                ->visible(fn ($get) => $get('period') === 'custom'),

            DatePicker::make('endDate')
                ->visible(fn ($get) => $get('period') === 'custom'),

            Select::make('accountId')
                ->label('Account')
                ->options(
                    Account::query()
                        ->pluck('name', 'id')
                        ->toArray()
                )
                ->searchable(),

            Select::make('transactionType')
                ->label('Type')
                ->options([
                    'income' => 'Income',
                    'expense' => 'Expense',
                ]),
        ];
    }
}