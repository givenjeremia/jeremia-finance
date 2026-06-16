<?php

namespace App\Filament\Widgets;

use App\Models\Budget;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BudgetUsageWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 50;
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return Budget::query()
            ->with('category')
            ->take(4)
            ->get()
            ->map(function ($budget) {

                $used = Transaction::query()
                    ->where('type', 'expense')
                    ->where('category_id', $budget->category_id)
                    ->sum('amount');

                $percent = $budget->limit_amount > 0
                    ? round(($used / $budget->limit_amount) * 100)
                    : 0;

                return Stat::make(
                    $budget->category?->name ?? 'Unknown',
                    $percent . '%'
                )
                ->description(
                    'Rp ' .
                    number_format($used, 0, ',', '.')
                    .
                    ' / Rp ' .
                    number_format(
                        $budget->limit_amount,
                        0,
                        ',',
                        '.'
                    )
                );

            })
            ->toArray();
    }
}