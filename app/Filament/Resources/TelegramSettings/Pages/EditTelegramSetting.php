<?php

namespace App\Filament\Resources\TelegramSettings\Pages;

use App\Filament\Resources\TelegramSettings\TelegramSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTelegramSetting extends EditRecord
{
    protected static string $resource = TelegramSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
