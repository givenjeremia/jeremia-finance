<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use App\Support\DashboardFilter;

class IncomeExpenseChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 10;
    protected ?string $heading = 'Income vs Expense';

    protected int|string|array $columnSpan = 3;

    protected function getData(): array
    {
        $incomeData = [];
        $expenseData = [];
        $labels = [];
    
        $year = now()->year;
        $filters = session('dashboard_filters', []);
        for ($month = 1; $month <= 12; $month++) {
    
            $start = Carbon::create(
                $year,
                $month,
                1
            )->startOfMonth();
    
            $end = Carbon::create(
                $year,
                $month,
                1
            )->endOfMonth();
                
            $income = DashboardFilter::apply(
                Transaction::query(),
                $filters 
            )
            ->where('type', 'income')
            ->whereBetween(
                'transaction_date',
                [$start, $end]
            )
            ->sum('amount');
    
            $expense = DashboardFilter::apply(
                Transaction::query(),
                $filters 
            )
            ->where('type', 'expense')
            ->whereBetween(
                'transaction_date',
                [$start, $end]
            )
            ->sum('amount');
    
            $incomeData[] = (float) $income;
            $expenseData[] = (float) $expense;
    
            $labels[] = Carbon::create()
                ->month($month)
                ->format('M');
        }
    
        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => $incomeData,
                    'borderWidth' => 3,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Expense',
                    'data' => $expenseData,
                    'borderWidth' => 3,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            now()->year => now()->year,
            now()->year - 1 => now()->year - 1,
            now()->year - 2 => now()->year - 2,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}