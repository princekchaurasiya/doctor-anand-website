<?php

namespace App\Filament\Resources\HomepageSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomepageSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('section_key')
                    ->label('Key')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('heading')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('sort_order')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
