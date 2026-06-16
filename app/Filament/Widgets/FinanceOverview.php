<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Support\DashboardFilter;

class FinanceOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        $filters = session('dashboard_filters', []);


        $query = DashboardFilter::apply(
            Transaction::query(),
            $filters
        );
        
        $income = (clone $query)
            ->where('type', 'income')
            ->sum('amount');
        
        $expense = (clone $query)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $income - $expense;

        return [

            Stat::make(
                'Balance',
                'Rp '.number_format(
                    $balance,
                    0,
                    ',',
                    '.'
                )
            ),

            Stat::make(
                'Income',
                'Rp '.number_format(
                    $income,
                    0,
                    ',',
                    '.'
                )
            ),

            Stat::make(
                'Expense',
                'Rp '.number_format(
                    $expense,
                    0,
                    ',',
                    '.'
                )
            ),

            Stat::make(
                'Transactions',
                Transaction::count()
            ),

        ];
    }
}