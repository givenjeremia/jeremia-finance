<?php

namespace App\Filament\Resources\Todos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TodoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Toggle::make('is_done')
                    ->required(),
            ]);
    }
}
