<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Support\DashboardFilter;

class MonthlySummaryWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {

        $filters = session('dashboard_filters', []);


        $query = DashboardFilter::apply(
            Transaction::query(),
            $filters
        );

        $income = $query
            ->where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $expense = $query
            ->where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $saving = $income - $expense;

        $days = max(now()->day, 1);

        $dailyAverage = $expense / $days;

        return [

            Stat::make(
                'Income This Month',
                'Rp ' . number_format($income, 0, ',', '.')
            ),

            Stat::make(
                'Expense This Month',
                'Rp ' . number_format($expense, 0, ',', '.')
            ),

            Stat::make(
                'Saving This Month',
                'Rp ' . number_format($saving, 0, ',', '.')
            ),

            Stat::make(
                'Daily Spending',
                'Rp ' . number_format($dailyAverage, 0, ',', '.')
            ),

        ];
    }
}