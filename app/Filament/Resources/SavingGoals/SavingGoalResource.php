<?php

namespace App\Filament\Resources\SavingGoals;

use App\Filament\Resources\SavingGoals\Pages\CreateSavingGoal;
use App\Filament\Resources\SavingGoals\Pages\EditSavingGoal;
use App\Filament\Resources\SavingGoals\Pages\ListSavingGoals;
use App\Filament\Resources\SavingGoals\Schemas\SavingGoalForm;
use App\Filament\Resources\SavingGoals\Tables\SavingGoalsTable;
use App\Models\SavingGoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SavingGoalResource extends Resource
{
    protected static ?string $model = SavingGoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SavingGoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SavingGoalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSavingGoals::route('/'),
            'create' => CreateSavingGoal::route('/create'),
            'edit' => EditSavingGoal::route('/{record}/edit'),
        ];
    }
}
