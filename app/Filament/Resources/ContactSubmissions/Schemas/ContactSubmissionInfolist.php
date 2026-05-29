<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submission')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('phone'),
                        TextEntry::make('email'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('message')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
