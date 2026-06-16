<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TopExpenseWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 40;
    protected int|string|array $columnSpan = 1;
    protected function getStats(): array
    {
        $category = Transaction::query()
            ->with('category')
            ->where('type', 'expense')
            ->get()
            ->groupBy(fn ($item) => $item->category?->name)
            ->map(fn ($items) => $items->sum('amount'))
            ->sortDesc()
            ->take(3);

        return $category->map(function ($amount, $name) {

            return Stat::make(
                $name ?? 'Unknown',
                'Rp ' . number_format($amount, 0, ',', '.')
            );

        })->values()->toArray();
    }
}