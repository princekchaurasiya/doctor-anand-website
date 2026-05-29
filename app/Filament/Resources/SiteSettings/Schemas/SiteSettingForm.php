<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branding & contact')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tagline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(50),
                        TextInput::make('whatsapp')
                            ->tel()
                            ->maxLength(50),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('open_hours')
                            ->maxLength(255),
                        Textarea::make('address_line')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('service_areas')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('frontend_public_url')
                            ->label('Public site URL')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('og_image_path')
                            ->label('Social share image')
                            ->image()
                            ->directory('uploads/site')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
                Section::make('SEO defaults')
                    ->columns(2)
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Homepage stats')
                    ->schema([
                        Repeater::make('stats')
                            ->schema([
                                TextInput::make('label')
                                    ->required(),
                                TextInput::make('value')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->collapsible(),
                    ]),
                Section::make('Testimonials')
                    ->schema([
                        Repeater::make('testimonials')
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                Textarea::make('quote')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->collapsible(),
                    ]),
                Section::make('FAQs (site-wide)')
                    ->schema([
                        Repeater::make('faqs')
                            ->schema([
                                TextInput::make('question')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('answer')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->collapsible(),
                    ]),
            ]);
    }
}
