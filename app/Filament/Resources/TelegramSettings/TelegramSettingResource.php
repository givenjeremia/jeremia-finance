<?php

namespace App\Filament\Resources\TelegramSettings;

use App\Filament\Resources\TelegramSettings\Pages\CreateTelegramSetting;
use App\Filament\Resources\TelegramSettings\Pages\EditTelegramSetting;
use App\Filament\Resources\TelegramSettings\Pages\ListTelegramSettings;
use App\Filament\Resources\TelegramSettings\Schemas\TelegramSettingForm;
use App\Filament\Resources\TelegramSettings\Tables\TelegramSettingsTable;
use App\Models\TelegramSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TelegramSettingResource extends Resource
{
    protected static ?string $model = TelegramSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TelegramSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TelegramSettingsTable::configure($table);
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
            'index' => ListTelegramSettings::route('/'),
            'create' => CreateTelegramSetting::route('/create'),
            'edit' => EditTelegramSetting::route('/{record}/edit'),
        ];
    }
}
