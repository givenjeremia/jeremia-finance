<?php

namespace App\Filament\Resources\Notes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
