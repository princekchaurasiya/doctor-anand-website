<?php

namespace App\Filament\Resources\HomepageSections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomepageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Section')
                    ->columns(2)
                    ->schema([
                        Select::make('section_key')
                            ->options([
                                'hero' => 'Hero',
                                'about' => 'About',
                                'how_it_works' => 'How it works',
                                'capabilities' => 'Capabilities',
                                'who_needs' => 'Who needs home visits',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabledOn('edit'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        TextInput::make('heading')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('subheading')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('body')
                            ->rows(8)
                            ->columnSpanFull(),
                        FileUpload::make('image_path')
                            ->label('Image')
                            ->image()
                            ->directory('uploads/homepage')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
