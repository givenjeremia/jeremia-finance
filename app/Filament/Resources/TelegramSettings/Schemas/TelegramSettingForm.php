<?php

namespace App\Filament\Resources\TelegramSettings\Schemas;


use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class TelegramSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                Select::make('user_id')->relationship('user', 'name')->required(),

                TextInput::make('bot_token')->password()->revealable(),

                TextInput::make('chat_id'),

                Toggle::make('is_enabled'),

                Toggle::make('daily_summary'),

                Toggle::make('monthly_summary'),

                Toggle::make('budget_alert'),

                Toggle::make('debt_reminder'),
            ]);
    }
}
