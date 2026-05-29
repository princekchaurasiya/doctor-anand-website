<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Post')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, ?string $operation): void {
                                if ($operation === 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug((string) $state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL path: /blog/your-slug'),
                        TextInput::make('category')
                            ->maxLength(255),
                        TagsInput::make('tags')
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('body')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                                'codeBlock',
                                'undo',
                                'redo',
                            ]),
                        FileUpload::make('featured_image_path')
                            ->label('Featured image')
                            ->image()
                            ->directory('uploads/blog')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publishing')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(false),
                        DateTimePicker::make('published_at')
                            ->label('Publish date')
                            ->seconds(false),
                    ]),
                Section::make('SEO')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(255),
                        TextInput::make('focus_keyword')
                            ->maxLength(255),
                        Textarea::make('meta_description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
