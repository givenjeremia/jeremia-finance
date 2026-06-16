<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

use App\Filament\Widgets\FinanceOverview;
use App\Filament\Widgets\MonthlySummaryWidget;
use App\Filament\Widgets\IncomeExpenseChart;
use App\Filament\Widgets\ExpenseCategoryChart;
use App\Filament\Widgets\LatestTransactions;
use App\Filament\Widgets\TopExpenseWidget;
use App\Filament\Widgets\BudgetUsageWidget;
use App\Filament\Widgets\SavingGoalWidget;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function getHeaderWidgetsColumns(): int|array
    {
        return [
            'md' => 4,
            'xl' => 4,
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardFilters::class,
            FinanceOverview::class,

            MonthlySummaryWidget::class,

            IncomeExpenseChart::class,
            ExpenseCategoryChart::class,

            LatestTransactions::class,
            TopExpenseWidget::class,

            BudgetUsageWidget::class,

            SavingGoalWidget::class,
        ];
    }
}