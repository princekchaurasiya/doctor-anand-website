<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submission')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->disabled(),
                        TextInput::make('phone')
                            ->disabled(),
                        TextInput::make('email')
                            ->disabled(),
                        Textarea::make('message')
                            ->disabled()
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
