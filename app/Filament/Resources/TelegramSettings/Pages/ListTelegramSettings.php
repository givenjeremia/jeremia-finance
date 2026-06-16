<?php

namespace App\Filament\Resources\TelegramSettings\Pages;

use App\Filament\Resources\TelegramSettings\TelegramSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTelegramSettings extends ListRecords
{
    protected static string $resource = TelegramSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
