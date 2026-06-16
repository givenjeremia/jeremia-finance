<?php

namespace App\Filament\Resources\TelegramSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Services\TelegramService;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class TelegramSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),

                IconColumn::make('is_enabled')
                    ->boolean(),
    
                IconColumn::make('daily_summary')
                    ->boolean(),
    
                IconColumn::make('monthly_summary')
                    ->boolean(),
    
                IconColumn::make('budget_alert')
                    ->boolean(),
    
                IconColumn::make('debt_reminder')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),


                Action::make('testTelegram')
                ->label('Test')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(function ($record) {

                    try {

                        // app(TelegramService::class)->send(
                        //     $record->bot_token,
                        //     $record->chat_id,
                        //     '✅ Telegram Finance Connected'
                        // );

                        Notification::make()
                            ->title('Telegram message sent')
                            ->success()
                            ->send();

                    } catch (\Throwable $e) {

                        Notification::make()
                            ->title('Telegram failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
