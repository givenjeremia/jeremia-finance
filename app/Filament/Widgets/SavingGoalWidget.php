<?php

namespace App\Filament\Widgets;

use App\Models\SavingGoal;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SavingGoalWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 60;
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        return SavingGoal::query()
            ->take(4)
            ->get()
            ->map(function ($goal) {

                $percent = 0;

                if ($goal->target_amount > 0) {
                    $percent = round(
                        ($goal->current_amount / $goal->target_amount) * 100
                    );
                }

                return Stat::make(
                    $goal->name,
                    $percent . '%'
                )
                ->description(
                    'Rp ' .
                    number_format(
                        $goal->current_amount,
                        0,
                        ',',
                        '.'
                    )
                    .
                    ' / '
                    .
                    number_format(
                        $goal->target_amount,
                        0,
                        ',',
                        '.'
                    )
                );

            })
            ->toArray();
    }
}