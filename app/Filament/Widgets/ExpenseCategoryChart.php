<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use App\Support\DashboardFilter;

class ExpenseCategoryChart extends ChartWidget
{
    protected static ?int $sort = 20;
    protected ?string $heading = 'Expense by Category';
    protected int|string|array $columnSpan = 1;
    protected function getData(): array
    {
        $filters = session('dashboard_filters', []);

        $data = DashboardFilter::apply(
            Transaction::query()
                ->with('category')
                ->where('type', 'expense'),
            $filters
        )
        ->get()
        ->groupBy(
            fn ($t) => $t->category?->name ?? 'Unknown'
        )
        ->map(
            fn ($items) => $items->sum('amount')
        );

        return [
            'datasets' => [
                [
                    'data' => $data->values()->toArray(),
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}