<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
// use Filament\Pages\Dashboard;
use App\Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class JeremiaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('jeremia')
            ->path('jeremia')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            // ->widgets([
           
            //     // \App\Filament\Widgets\FinanceOverview::class,

            //     // \App\Filament\Widgets\MonthlySummaryWidget::class,
            
            //     // \App\Filament\Widgets\IncomeExpenseChart::class,
            //     // \App\Filament\Widgets\ExpenseCategoryChart::class,
            
            //     // \App\Filament\Widgets\LatestTransactions::class,
            //     // \App\Filament\Widgets\TopExpenseWidget::class,
            
            //     // \App\Filament\Widgets\BudgetUsageWidget::class,
            
            //     // \App\Filament\Widgets\SavingGoalWidget::class,
            // ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ;
    }
}
