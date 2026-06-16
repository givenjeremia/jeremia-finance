<?php

namespace App\Filament\Widgets;

use App\Models\Account;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

class DashboardFilters extends Widget implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.widgets.dashboard-filters';

    protected int|string|array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = [
            'period' => 'today',
            'accountId' => null,
            'transactionType' => null,
            'startDate' => null,
            'endDate' => null,
        ];

        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->columns([
                'md' => 5,
                'xl' => 5,
            ])
            ->components([

                Select::make('period')
                    ->label('Period')
                    ->default('today')
                    ->live()
                    ->native(false)
                    ->options([
                        'today' => 'Today',
                        'week' => 'This Week',
                        'month' => 'This Month',
                        'year' => 'This Year',
                        'custom' => 'Custom Range',
                    ]),

                Select::make('accountId')
                    ->label('Account')
                    ->native(false)
                    ->searchable()
                    ->options(
                        Account::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray()
                    ),

                Select::make('transactionType')
                    ->label('Type')
                    ->native(false)
                    ->options([
                        'income' => 'Income',
                        'expense' => 'Expense',
                    ]),

                DatePicker::make('startDate')
                    ->label('Start Date')
                    ->live()
                    ->hidden(
                        fn ($get) => $get('period') !== 'custom'
                    ),

                DatePicker::make('endDate')
                    ->label('End Date')
                    ->live()
                    ->hidden(
                        fn ($get) => $get('period') !== 'custom'
                    ),
            ]);
    }

    public function applyFilters(): void
    {
        session([
            'dashboard_filters' => $this->data,
        ]);

        $this->dispatch('dashboardFiltersUpdated');
    }

    public function resetFilters(): void
    {
        $this->data = [
            'period' => 'today',
            'accountId' => null,
            'transactionType' => null,
            'startDate' => null,
            'endDate' => null,
        ];

        $this->form->fill($this->data);

        session()->forget('dashboard_filters');

        $this->dispatch('dashboardFiltersUpdated');
    }
}